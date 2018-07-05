import getLoader from './getLoader';
import getPlugin from './getPlugin';
let config = function (env, arg, iServerRender = false, isServer = false) {
    let config = {
        mode        : arg.mode,
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
            rules: getLoader(arg.mode, isServer);
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
            //'prop-types'                   : 'React.PropTypes',
            'react-dom'                    : 'ReactDOM',
            'react-router'                 : 'ReactRouter',
            'react-router-dom'             : 'ReactRouterDOM',
            'react-redux'                  : 'ReactRedux',
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
        plugins     : getPlugin(arg.mode, isServer, isServer);
    };
    return config;
}
export default config;