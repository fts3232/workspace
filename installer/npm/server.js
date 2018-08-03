import LRU from 'lru-cache';
import fs from 'fs';
import cheerio from 'cheerio';
import Loadable from 'react-loadable';
import Koa from 'koa';
import KoaStatic from 'koa-static';
import { getBundles } from 'react-loadable/webpack';
import KoaRouter from 'Koa-router';
import axios from 'axios';
import { createStore } from 'redux';
import stats from './build/server/react-loadable.json';
import createApp from './build/server/main.js';

// 缓存
const microCache = LRU({
    max: 100,
    maxAge: 5000, // 重要提示：条目在 1 秒后过期。
});

const template = fs.readFileSync('./build/index.html', 'utf-8');

const app = new Koa();

// 静态资源目录
app.use(KoaStatic('./build', { index: 'asd.asdad' }));

const router = new KoaRouter();

// x-response-time

app.use(async (ctx, next) => {
    const start = Date.now();
    await next();
    const ms = Date.now() - start;
    ctx.set('X-Response-Time', `${ms}ms`);
});

// logger

app.use(async (ctx, next) => {
    const start = Date.now();
    await next();
    const ms = Date.now() - start;
    console.log(`${ctx.method} ${ctx.url} - ${ms}`);
});

// response

router.get('/name', (ctx, next) => {
    ctx.body = 'asdsad';
});

router.get('/*', async (ctx, next) => {
    await axios.get('http://localhost:3001/name').then(response => {
        const preloadedState = { name: response.data, count: 100 };
        const store = createStore((state = { name: '', count: 0 }, action) => {
            const { name, count } = state;
            switch (action.type) {
                case 'increase':
                    return { count: count + 1 };
                default:
                    return state;
            }
        }, preloadedState);

        const { modules, html } = createApp(ctx.request.url, store);

        const bundles = getBundles(stats, modules);
        const $ = cheerio.load(template);
        $('#app').html(html);
        bundles.map(bundle =>
            $('script')
                .eq(3)
                .after(`<script src="${bundle.file}"></script>`)
        );

        $('script').eq(3).after(`<script>
            // 警告：关于在 HTML 中嵌入 JSON 的安全问题，请查看以下文档
            // http://redux.js.org/recipes/ServerRendering.html#security-considerations
            window.__PRELOADED_STATE__ = ${JSON.stringify(
                preloadedState
            ).replace(/</g, '\\\u003c')}
            </script>`);
        ctx.body = $.html();
        // microCache.set(ctx.request.url, $.html())
    });

    // asda = 'asdasd'
    // fs.writeSync(fd,$.html());
    // fs.closeSync(fd)
    // console.log('文件已创建')
});

app.use(router.routes()).use(router.allowedMethods());

// error
app.on('error', err => {
    console.log('server error', err);
});

// 预加载完所有组件才监听端口
Loadable.preloadAll().then(() => {
    const server = app.listen(process.env.PORT || 3000, () => {
        const { host, port } = server.address();

        console.log('Example app listening at http://%s:%s', host, port);
    });
});
