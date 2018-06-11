// /* webpack.config.js */

import path from 'path';
import webpack from 'webpack';
import VueSSRClientPlugin from 'vue-server-renderer/client-plugin'
//压缩js
import UglifyJs from 'uglifyjs-webpack-plugin';
//css 雪碧图
import PostCssSprites from 'postcss-sprites';
//压缩css
import OptimizeCSSAssetsPlugin from 'optimize-css-assets-webpack-plugin';
//优化css
import cssnano from 'cssnano';
//生成html
import HtmlWebpackPlugin from 'html-webpack-plugin';

import baseConfig from './webpack.base.config.babel.js'

import merge from 'webpack-merge'
//清理文件夹插件
//import CleanWebpackPlugin from 'clean-webpack-plugin';
//定义了一些文件夹的路径
const ROOT_PATH = path.resolve(__dirname);

let config = function (env, arg) {
    const BUILD_PATH = path.resolve(ROOT_PATH, arg['build-path']);
    const SRC_PATH = path.resolve(ROOT_PATH, arg['src-path']);
    const TEMPLATE_PATH = path.resolve(SRC_PATH, 'template');
    let config = merge(baseConfig(env, arg), {
        /*
        source-map  在一个单独的文件中产生一个完整且功能完全的文件。这个文件具有最好的source map，但是它会减慢打包文件的构建速度；
        cheap-module-source-map 在一个单独的文件中生成一个不带列映射的map，不带列映射提高项目构建速度，但是也使得浏览器开发者工具只能对应到具体的行，不能对应到具体的列（符号），会对调试造成不便；
        eval-source-map 使用eval打包源文件模块，在同一个文件中生成干净的完整的source map。这个选项可以在不影响构建速度的前提下生成完整的sourcemap，但是对打包后输出的JS文件的执行具有性能和安全的隐患。不过在开发阶段这是一个非常好的选项，但是在生产阶段一定不要用这个选项；
        cheap-module-eval-source-map  这是在打包文件时最快的生成source map的方法，生成的Source Map 会和打包后的JavaScript文件同行显示，没有列映射，和eval-source-map选项具有相似的缺点；
         */
        //devtool: 'eval-source-map',//配置生成Source Maps，选择合适的选项
        //项目的文件夹 可以直接用文件夹名称 默认会找index.js 也可以确定是哪个文件名字
        //入口文件
        entry       : {
            'app': SRC_PATH + '/js/entry-client.js'
            /* 'vendor': [
                 APP_PATH + '/components/Component.vue',
                 APP_PATH + '/views/Common/View.vue',
                 APP_PATH + '/views/Common/Dialog.vue',
             ],*/
        },
        //输出的文件名 合并以后的js会命名为bundle.js
        output      : {
            path         : BUILD_PATH,
            filename     : 'js/[name].js?v=[hash]',
            chunkFilename: 'js/[name].bundle.js?v=[chunkhash]',
            publicPath   : arg.mode == 'development' ? 'http://localhost:3000/' : './',
        },
        optimization: {
            minimizer  : [
                new UglifyJs({
                    uglifyOptions: {
                        output  : {
                            comments: false,  // remove all comments
                        },
                        compress: {
                            warnings: false
                        }
                    }
                }),
                new OptimizeCSSAssetsPlugin({
                    assetNameRegExp    : /\.css$/g,
                    cssProcessor       : cssnano,
                    cssProcessorOptions: {discardComments: {removeAll: true}},
                    canPrint           : true
                })
            ],
            splitChunks: {
                chunks                : "async",
                minSize               : 30000,
                minChunks             : 1,
                maxAsyncRequests      : 5,
                maxInitialRequests    : 3,
                automaticNameDelimiter: '~',
                name                  : true,
                cacheGroups           : {
                    common : {
                        name     : 'common',
                        chunks   : 'initial',
                        enforce  : true,
                        minChunks: 2,
                        test     : /\.js$/
                    },
                    vendors: {
                        name    : 'vendors',
                        test    : /[\\/]node_modules[\\/]/,
                        chunks  : "all",
                        priority: 10,
                    },
                    default: {
                        minChunks         : 2,
                        priority          : -20,
                        reuseExistingChunk: true
                    }
                }
            }
        },
        plugins     : [
            /*new CleanWebpackPlugin(['js', 'css', 'images', 'fonts'], {
                root   : BUILD_PATH,
                verbose: true,
                dry    : false
            }),*/
            new webpack.NamedModulesPlugin(),
            new HtmlWebpackPlugin({
                title   : 'My App',
                filename: 'index.html',
                template: TEMPLATE_PATH + '/index.html'
            }),
            new webpack.DefinePlugin({
                'process.env.VUE_ENV': '"client"'
            }),
            new VueSSRClientPlugin()
        ]
    });
    if (arg.mode == 'production') {
        config.module.rules[1]['use'][2]['options']['plugins'].push(new PostCssSprites({
            retina       : true,//支持retina，可以实现合并不同比例图片
            verbose      : true,
            spritePath   : BUILD_PATH,//雪碧图合并后存放地址
            styleFilePath: BUILD_PATH + '/css',
            basePath     : './',
            filterBy     : function (image) {
                //过滤一些不需要合并的图片，返回值是一个promise，默认有一个exist的filter
                if (image.originalUrl.indexOf('?__sprites') === -1) {
                    return Promise.reject();
                }
                return Promise.resolve();
            },
            groupBy      : function (image) {
                //将图片分组，可以实现按照文件夹生成雪碧图
                var groupName = '/sprite';
                var url = path.dirname(image.url);
                url = url.replace(/\.\.\//g, '');
                url = url.replace(/\.\//g, '');
                if (image.url.indexOf('@2x') !== -1) {
                    groupName = '/sprite@2x';
                }
                else if (image.url.indexOf('@3x') !== -1) {
                    groupName = '/sprite@3x';
                }
                return Promise.resolve(url + groupName);
            },
            hooks        : {
                onSaveSpritesheet: function (opts, spritesheet) {
                    // We assume that the groups is not an empty array
                    var filenameChunks = spritesheet.groups.concat(spritesheet.extension);
                    return path.join(opts.spritePath, filenameChunks.join('.'));
                }
            }
        }))
    }
    return config;
}
export default config;