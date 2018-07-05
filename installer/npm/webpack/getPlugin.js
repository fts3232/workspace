//css整合成1个文件
import MiniCssExtractPlugin from "mini-css-extract-plugin";
//生成html
import HtmlWebpackPlugin from 'html-webpack-plugin';
import webpack form 'webpack';


let getPlugin = (mode, isServerRender, isServer) => {
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

    let html = new HtmlWebpackPlugin({
        title   : 'My App',
        filename: 'index.html',
        template: TEMPLATE_PATH + '/index.html'
    })

    let define = new webpack.DefinePlugin({
        'SSR': arg.ssr
    })

    let reactLoadable = new ReactLoadablePlugin({
        filename: BUILD_PATH + '/server/react-loadable.json',
    })

    plugin.push(html);
    plugin.push(define);

    if (!isServer) {//客户端
        if (isServerRender) { //服务器渲染
            plugin.push(reactLoadable)
        }
        plugin.push(miniCssExtract)
    }
    if(mode == 'development'){
        plugin.push(namedModules);
    }
    return plugin;
}
export function getPlugin;