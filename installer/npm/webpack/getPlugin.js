//css整合成1个文件
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
//生成html
import HtmlWebpackPlugin from 'html-webpack-plugin';
//webpack
import webpack from 'webpack';
//预渲染
import PrerenderSPAPlugin from 'prerender-spa-plugin';

import { ReactLoadablePlugin } from 'react-loadable/webpack';
//复制文件
import CopyWebpackPlugin from 'copy-webpack-plugin';
//虚拟入口
import MockEntryPlugin from './plugins/MockEntryPlugin';
//通知
import NotifyPlugin from './plugins/NotifyPlugin';
//manifest
import ManifestPlugin from './plugins/ManifestPlugin';

let getPlugin = options => {
    let plugin = [];

    //定义常量
    let define = new webpack.DefinePlugin({
        IS_SERVER_RENDER: options.isServerRender,
    });
    plugin.push(define);

    if (!options.isServer) {
        //客户端
        if (options.isServerRender) {
            //服务器渲染
            //react-loadable
            let reactLoadable = new ReactLoadablePlugin({
                filename: options.buildPath + '/server/react-loadable.json',
            });
            plugin.push(reactLoadable);
        }
        //生成html文件
        let html = new HtmlWebpackPlugin({
            title: 'My App',
            filename: 'index.html',
            meta: {
                description: 'description',
                keyword: 'keyword',
            },
            template: options.templatePath + '/index.html',
        });
        plugin.push(html);
        //打包css成1个文件
        let miniCssExtract = new MiniCssExtractPlugin({
            // Options similar to the same options in webpackOptions.output
            // both options are optional
            filename: 'css/[name].css?v=[contenthash]',
            //chunkFilename: "css/[id].css?v=[contenthash]"
        });
        plugin.push(miniCssExtract);
    }

    //当开启 HMR 的时候使用该插件会显示模块的相对路径，建议用于开发环境。
    if (options.mode == 'development') {
        let namedModules = new webpack.NamedModulesPlugin();
        plugin.push(namedModules);
    }

    //预渲染
    if (options.prerender) {
        const Renderer = PrerenderSPAPlugin.PuppeteerRenderer;
        let prerender = new PrerenderSPAPlugin({
            staticDir: options.buildPath,
            routes: ['/', '/Todo', '/Counter'],
        });
        plugin.push(prerender);
    }

    //复制文件
    let copy = new CopyWebpackPlugin([
        {
            from: __dirname + '/../.htaccess',
            to  : __dirname + '/../build'
        }
    ]);
    plugin.push(copy);

    //虚拟入口
    plugin.push(new MockEntryPlugin())

    //通知
    plugin.push(new NotifyPlugin())

    //生成manifest.json
    plugin.push(new ManifestPlugin(options.buildPath))

    return plugin;
};
export default getPlugin;
