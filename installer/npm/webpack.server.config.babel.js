import nodeExternals from 'webpack-node-externals';
import merge from 'webpack-merge'
import VueSSRServerPlugin from 'vue-server-renderer/server-plugin';
import path from 'path';
import baseConfig from './webpack.base.config.babel.js'
import webpack from 'webpack';
const ROOT_PATH = path.resolve(__dirname);

let config = function (env, arg) {
    const BUILD_PATH = path.resolve(ROOT_PATH, arg['build-path']);
    const SRC_PATH = path.resolve(ROOT_PATH, arg['src-path']);
    const TEMPLATE_PATH = path.resolve(SRC_PATH, 'template');
    let config = merge(baseConfig(env, arg), {
        //入口文件
        entry: SRC_PATH + '/js/entry-server.js',
        target: 'node',
        //输出的文件名 合并以后的js会命名为bundle.js
        output      : {
            path         : BUILD_PATH,
            libraryTarget: 'commonjs2'
        },
        externals   : nodeExternals({
            // 不要外置化 webpack 需要处理的依赖模块。
            // 你可以在这里添加更多的文件类型。例如，未处理 *.vue 原始文件，
            // 你还应该将修改 `global`（例如 polyfill）的依赖模块列入白名单
            whitelist: /\.css$/,
        }),
        plugins     : [
            new VueSSRServerPlugin(),
            new webpack.DefinePlugin({
                'process.env.VUE_ENV': '"server"'
            }),
        ]
    })
    return config;
}
export default config;