import nodeExternals from 'webpack-node-externals';
import merge from 'webpack-merge'
import path from 'path';
import baseConfig from './webpack.base.config.babel.js'

const ROOT_PATH = path.resolve(__dirname);

let config = function (env, arg) {
    const BUILD_PATH = path.resolve(ROOT_PATH, arg['build-path']);
    const SRC_PATH = path.resolve(ROOT_PATH, arg['src-path']);
    const TEMPLATE_PATH = path.resolve(SRC_PATH, 'template');
    let config = merge(baseConfig(env, arg, true, true), {
        //入口文件
        entry    : SRC_PATH + '/js/entry-server.js',
        target   : 'node',
        //输出的文件名 合并以后的js会命名为bundle.js
        output   : {
            filename     : 'main.js',
            path         : BUILD_PATH + '/server',
            libraryTarget: 'commonjs2'
        },
        externals: [nodeExternals()],
        plugins  : []
    })
    return config;
}
export default config;