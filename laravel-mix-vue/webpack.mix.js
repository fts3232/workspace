const mix = require('laravel-mix');
const path = require('path');
//mix.setResourceRoot('../');
//mix.setPublicPath('./public/build');

var sassOptions = {
    //processCssUrls: false,
    autoprefixer: true,
};
let BUILD_PATH = path.resolve(path.resolve(__dirname), 'public/js/build');
let APP_PATH = path.resolve(path.resolve(__dirname), 'resources/assets/js');
if (mix.inProduction()) {
    sassOptions.postCss = [
        require('postcss-sprites')({
            retina    : true, //支持retina，可以实现合并不同比例图片
            verbose   : true,
            spritePath: './images', //雪碧图合并后存放地址
            //styleFilePath: resourcesPath + '/assets/css',
            basePath  : './images',
            filterBy  : function (image) {
                //过滤一些不需要合并的图片，返回值是一个promise，默认有一个exist的filter
                if (image.originalUrl.indexOf('sprites') === -1) {
                    return Promise.reject();
                }

                return Promise.resolve();
            },
            groupBy   : function (image) {
                var url = path.dirname(image.url);
                if (image.originalUrl.indexOf('open-account-') !== -1) {
                    url = 'open-account-sprites'
                } else if (image.originalUrl.indexOf('index-') !== -1 || image.originalUrl.indexOf('banner-') !== -1) {
                    url = 'index-sprites'
                } else if (image.originalUrl.indexOf('icon-') !== -1) {
                    url = 'icon-sprites'
                } else {
                    url = 'sprites'
                }
                return Promise.resolve(url);
            },
            hooks     : {
                onSaveSpritesheet: function (opts, spritesheet) {
                    // We assume that the groups is not an empty array
                    var filenameChunks = spritesheet.groups.concat(
                        spritesheet.extension
                    );
                    return path.join(
                        opts.spritePath,
                        filenameChunks.join('.')
                    );
                },
            },
        })
    ]
}
//
mix.webpackConfig({
    output   : {
        chunkFilename: 'js/build/[name].bundle.js?v=[chunkhash]'
    },
    externals: {
        'vue'                          : 'Vue',
        'element-ui'                   : 'ELEMENT',
        'element-ui/lib/locale/lang/en': 'ELEMENT.lang.en',
        'vue-i18n'                     : 'VueI18n',
        'vuex'                         : 'Vuex',
        'vue-router'                   : 'VueRouter',
        'postcss-loader'               : 'postcss-loader',
        'style-loader'                 : 'style-loader',
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
})
mix.js('resources/assets/js/app.js', 'public/js').version();
mix.sass('resources/assets/sass/app.scss', 'public/css').options(sassOptions).version();
mix.postCss('resources/assets/css/iconFont.css', 'public/css').version();
//mix.copyDirectory('resources/images/pic', 'images');

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
