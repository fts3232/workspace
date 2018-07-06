//css整合成1个文件
import MiniCssExtractPlugin from "mini-css-extract-plugin";
//生成html
import HtmlWebpackPlugin from 'html-webpack-plugin';
//webpack
import webpack from 'webpack';
//预渲染
import PrerenderSPAPlugin from 'prerender-spa-plugin';

import { ReactLoadablePlugin } from 'react-loadable/webpack';


let getPlugin = (options) => {
    let plugin = [];
    //打包css成1个文件
    let miniCssExtract = new MiniCssExtractPlugin({
        // Options similar to the same options in webpackOptions.output
        // both options are optional
        filename: 'css/[name].css?v=[contenthash]',
        //chunkFilename: "css/[id].css?v=[contenthash]"
    })

    //当开启 HMR 的时候使用该插件会显示模块的相对路径，建议用于开发环境。
    let namedModules = new webpack.NamedModulesPlugin()

    //生成html文件
    let html = new HtmlWebpackPlugin({
        title   : 'My App',
        filename: 'index.html',
        meta:{
            description: 'description',
            keyword:'keyword'
        },
        template: options.templatePath + '/index.html'
    })

    //定义常量
    let define = new webpack.DefinePlugin({
        'IS_SERVER_RENDER': options.isServerRender
    })

    //react-loadable
    let reactLoadable = new ReactLoadablePlugin({
        filename: options.buildPath + '/server/react-loadable.json',
    })


    plugin.push(define);

    if (!options.isServer) {//客户端
        if (options.isServerRender) { //服务器渲染
            plugin.push(reactLoadable)
        }
        plugin.push(html);
        plugin.push(miniCssExtract);
    }
    if(options.mode == 'development'){
        plugin.push(namedModules);
    }

    //预渲染
    const Renderer = PrerenderSPAPlugin.PuppeteerRenderer;
    let prerender = new PrerenderSPAPlugin({
        staticDir: options.buildPath,
        routes   : ['/', '/Todo', '/Counter'],
    })
    if(options.prerender){
        plugin.push(prerender);
    }

    return plugin;
}
export default getPlugin;