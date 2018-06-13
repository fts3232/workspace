import express from 'express';
import path from 'path';

import React from 'react';
import LRU from 'lru-cache'
import fs from 'fs';
import cheerio from 'cheerio';
import App from './build/server/server.js';

const app = express();
app.use('/', express.static('./build'));
const template = fs.readFileSync('./build/index.html','utf-8');

app.use('*', (req, res, next) => {
    /*if (req.url.startsWith('/user/') || req.url.startsWith('/static/')) {
        return next()
    }*/
    const context = {}

    let $ = cheerio.load(template)
    $('#app').html(App)
    console.log($.html())
    res.end($.html())
    // return res.sendFile(path.resolve('build/index.html'))
})





//缓存
const microCache = LRU({
    max   : 100,
    maxAge: 1000 // 重要提示：条目在 1 秒后过期。
})

/*//渲染函数
function render(req, res) {
    const s = Date.now()

    res.setHeader("Content-Type", "text/html")

    //错误处理
    const handleError = err => {
        if (err.url) {
            res.redirect(err.url)
        } else if (err.code === 404) {
            res.status(404).send('404 | Page Not Found')
        } else {
            // Render Error Page or Redirect
            res.status(500).send('500 | Internal Server Error')
            console.error(`error during render : ${req.url}`)
            console.error(err.stack)
        }
    }

    //页面缓存
    const pageCache = microCache.get(req.url)
    if (pageCache) {
        return res.end(pageCache)
    }

    const context = {url: req.url}
    //渲染成字符串
    renderer.renderToString(context, (err, html) => {
        if (err) {
            return handleError(err)
        }
        res.send(html)
        microCache.set(req.url, html)
        if (!isProduction) {
            console.log(`whole request: ${Date.now() - s}ms`)
        }
    })

}

app.get('*', isProduction ? render : (req, res) => {
    readyPromise.then(() => {
        render(req, res)
    })
})*/

/*
app.use(express.static('build'));

readyPromise = require('./build/setup-dev-server')(
    app,
    templatePath,
    (bundle, options) => {
        renderer = createRenderer(bundle, options)
    }
)



app.get('*', (req, res) => {
    //res.send('hello world');
    const context = {url: req.url}

    const hit = microCache.get(req.url)
    if (hit) {
        return res.end(hit)
    }

    renderer.renderToString(context, (err, html) => {
        // 处理错误……
        if (err) {
            if (err.code === 404) {
                res.status(500).end('404 Not Found')
            } else {
                res.status(500).end('Internal Server Error')
            }
        } else {
            res.end(html)
            microCache.set(req.url, html)
        }
    })
})*/

const server = app.listen(process.env.PORT || 3000, function () {
    var host = server.address().address;
    var port = server.address().port;

    console.log('Example app listening at http://%s:%s', host, port);
});

