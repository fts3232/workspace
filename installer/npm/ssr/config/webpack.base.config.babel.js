import VueLoaderPlugin from 'vue-loader/lib/plugin';
//css整合成1个文件
import MiniCssExtractPlugin from "mini-css-extract-plugin";
//补全css
import AutoPrefixer from 'autoprefixer';
//css 2x图插件
import PostCssAt2x from 'postcss-at2x';

let config = function (env, arg) {
    let config = {
        mode: arg.mode,
        resolve     : {
            extensions: ['.js', '.jsx'],
            alias     : {
                'vue$': 'vue/dist/vue.js' // 'vue/dist/vue.common.js' for webpack 1
            }
        },
        watchOptions: {
            ignored: /node_modules/
        },
        module      : {
            rules: [
                {
                    test  : /\.vue$/,
                    loader: 'vue-loader',
                },
                {
                    test: /\.s?[ac]ss$/,
                    use : [
                        arg.mode == 'development' ? 'vue-style-loader' : MiniCssExtractPlugin.loader,
                        {
                            loader : 'css-loader',
                            options: {// some options
                                minimize: arg.mode == 'production'
                            }
                        },
                        {
                            loader : 'postcss-loader',
                            options: {
                                plugins: [
                                    new PostCssAt2x(),
                                    new AutoPrefixer()
                                ]
                            }
                        },
                        'sass-loader'
                    ],
                },
                {
                    test   : /\.(js|jsx)$/,
                    loader : 'babel-loader',
                    exclude: /(node_modules|bower_components)/,
                },
                {
                    test  : /\.(png|jpg|svg)$/,
                    loader: [
                        {
                            loader : 'url-loader',
                            options: {
                                limit     : 8192,
                                fallback  : 'file-loader',
                                publicPath: './images/',
                                outputPath: 'images/',
                                name      : '[name].[ext]?v=[hash:8]'
                            }
                        }
                    ],
                },
                {
                    test  : /\.(ttf|woff)$/,
                    loader: [
                        {
                            loader : 'url-loader',
                            options: {
                                limit     : 8192,
                                fallback  : 'file-loader',
                                publicPath: './fonts/',
                                outputPath: 'fonts/',
                                name      : '[name].[ext]?v=[hash:8]'
                            }
                        }
                    ],
                },
            ]
        },
        externals   : {
            'vue'                          : 'Vue',
            'element-ui'                   : 'ELEMENT',
            'element-ui/lib/locale/lang/en': 'ELEMENT.lang.en',
            'vue-i18n'                     : 'VueI18n',
            'vuex'                         : 'Vuex',
            'vue-router'                   : 'VueRouter',
            'postcss-loader'               : 'postcss-loader',
            'style-loader'                 : 'style-loader',
            'css-loader'                   : 'css-loader',
            'sass-loader'                  : 'sass-loader',
            "lodash"                       : 'lodash',
            "react"                        : 'React',
            'mockjs'                       : 'Mock',
            'superagent'                   : 'superagent',
            'prop-types'                   : 'React.PropTypes',
            'react-dom'                    : 'ReactDOM',
            'react-router'                 : 'ReactRouter',
            'react-router-dom'             : 'react-router-dom',
            'history/createBrowserHistory' : 'history',//history插件
            'moment/moment.js'             : 'moment',//时间插件
            'pubsub-js'                    : 'PubSub',//pubSub插件
            'react-quill'                  : 'ReactQuill',//富文本编辑器
            'jquery'                       : '$',
            'bootstrap'                    : true,
            'fancybox'                     : true,
            'co'                           : true,
            '_'                            : true,
            'async'                        : true,
            'datetimepicker'               : true,
            'selectpicker'                 : true,
            'sweetalert'                   : true,
            'highcharts'                   : true,
            'director'                     : true
        },
        plugins     : [
            new VueLoaderPlugin(),
            new MiniCssExtractPlugin({
                // Options similar to the same options in webpackOptions.output
                // both options are optional
                filename     : 'css/[name].css?v=[contenthash]',
                chunkFilename: "css/[id].css?v=[contenthash]"
            }),
        ]
    };
    return config;
}
export default config;