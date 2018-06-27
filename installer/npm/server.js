import LRU from 'lru-cache'
import fs from 'fs';
import cheerio from 'cheerio';
import createApp from './build/server.js';

import Koa from 'koa';
import KoaStatic from 'koa-static';

//缓存
const microCache = LRU({
    max   : 100,
    maxAge: 1000 // 重要提示：条目在 1 秒后过期。
})

const template = fs.readFileSync('./build/index.html','utf-8');

const app = new Koa();

//静态资源目录
app.use(KoaStatic('./build'))

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

app.use(async ctx => {
    if (microCache.get(ctx.request.url)) {
        ctx.body = microCache.get(ctx.request.url)
    } else {
        const context = {}
        let $ = cheerio.load(template)
        $('#app').html(createApp(ctx.request.url, context))
        microCache.set(ctx.request.url, $.html())
        ctx.body = $.html();
    }
});

//error
app.on('error', err => {
    console.log('server error', err)
});

const server = app.listen(process.env.PORT || 3000, function () {
    var host = server.address().address;
    var port = server.address().port;

    console.log('Example app listening at http://%s:%s', host, port);
});

