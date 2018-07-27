import getLoader from './getLoader';
import getPlugin from './getPlugin';
import getClientConfig from './getClientConfig';
import getServerConfig from './getServerConfig';
import path from 'path';
import merge from 'webpack-merge';

let getBaseConfig = options => {
    let config = {
        mode: options.mode,
        resolve: {
            extensions: ['.js', '.jsx'],
        },
        output: {
            path: options.buildPath,
        },
        watchOptions: {
            ignored: /node_modules/,
        },
        module: getLoader(options),
        externals: {
            vue: 'Vue',
            'element-ui': 'ELEMENT',
            'element-ui/lib/locale/lang/en': 'ELEMENT.lang.en',
            'vue-i18n': 'VueI18n',
            vuex: 'Vuex',
            'vue-router': 'VueRouter',
            'postcss-loader': 'postcss-loader',
            'style-loader': 'style-loader',
            'css-loader': 'css-loader',
            'sass-loader': 'sass-loader',
            lodash: 'lodash',
            react: 'React',
            mockjs: 'Mock',
            superagent: 'superagent',
            //'prop-types'                   : 'React.PropTypes',
            'react-dom': 'ReactDOM',
            'react-router': 'ReactRouter',
            'react-router-dom': 'ReactRouterDOM',
            'react-redux': 'ReactRedux',
            'history/createBrowserHistory': 'history', //history插件
            'moment/moment.js': 'moment', //时间插件
            'pubsub-js': 'PubSub', //pubSub插件
            'react-quill': 'ReactQuill', //富文本编辑器
            jquery: '$',
            bootstrap: true,
            fancybox: true,
            co: true,
            _: true,
            async: true,
            datetimepicker: true,
            selectpicker: true,
            sweetalert: true,
            highcharts: true,
            director: true,
        },
        plugins: getPlugin(options),
    };
    return config;
};

let config = function(env, arg) {
    const ROOT_PATH = path.resolve(__dirname);
    const BUILD_PATH = path.resolve(ROOT_PATH, arg['build-path']);
    const SRC_PATH = path.resolve(ROOT_PATH, arg['src-path']);
    const TEMPLATE_PATH = path.resolve(SRC_PATH, 'template');

    let options = {
        buildPath: BUILD_PATH,
        srcPath: SRC_PATH,
        templatePath: TEMPLATE_PATH,
        isServerRender: arg['is-server-render'] == 'true' ? true : false,
        isServer: false,
        publicPath: arg['public-path'] ? arg['public-path'] : '/',
        prerender: arg['prerender'] == 'true',
        mode: arg.mode,
    };
    let client = merge(getBaseConfig(options), getClientConfig(options));

    if (!options.isServerRender) {
        return client;
    } else {
        options.isServer = true;
        let server = merge(getBaseConfig(options), getServerConfig(options));
        return [client, server];
    }
};
export default config;
