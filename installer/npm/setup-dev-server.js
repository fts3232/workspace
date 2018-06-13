import fs from 'fs';
import path from 'path';
import MFS from 'memory-fs';
import webpack from 'webpack';
import chokidar from 'chokidar';
import getConfig from './webpack.config.babel.js'
import webpackDevMiddleware from 'webpack-dev-middleware';

const config = getConfig({},{
    'mode': 'production',
    'build-path':'build',
    'src-path':'assets'
});

let compiler = webpack(config);
compiler.outputFileSystem = MFS;

compiler.watch({}, (err, stats) => {
    if (err)
        throw err;
    stats = stats.toJson();
    // 打印错误和警告信息
    stats
        .errors
        .forEach(err => {
            console.error(err);
        });
    stats
        .warnings
        .forEach(warn => {
            console.warn(warn);
        })
    // 打包的文件所在路径

})