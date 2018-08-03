//css整合成1个文件
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
//补全css
import AutoPrefixer from 'autoprefixer';
//css 2x图插件
import PostCssAt2x from 'postcss-at2x';
//css 雪碧图
import PostCssSprites from 'postcss-sprites';

let getLoader = otpions => {
    //font
    let fontLoader = [
        {
            loader: 'url-loader',
            options: {
                limit: 8192,
                fallback: 'file-loader',
                publicPath: '/fonts/',
                outputPath: 'fonts/',
                name: '[name].[ext]?v=[hash:8]',
                emitFile: otpions.isServer ? false : true, //服务器端不生成font文件
            },
        },
    ];

    //image
    let imageLoader = [
        {
            loader: 'url-loader',
            options: {
                limit: 8192,
                fallback: 'file-loader',
                publicPath: '/images/',
                outputPath: 'images/',
                name: '[name].[ext]?v=[hash:8]',
                emitFile: otpions.isServer ? false : true, //服务器端不生成image文件
            },
        },
    ];

    //css
    let cssLoader;

    if (otpions.isServer) {
        //服务器端不打包css
        cssLoader = ['css-loader', 'sass-loader'];
    } else {
        cssLoader = [
            MiniCssExtractPlugin.loader, //打包css整合成1个文件
            {
                loader: 'css-loader',
                options: {
                    // some options
                    minimize: otpions.mode == 'production', //生产模式开启压缩
                },
            },
            {
                loader: 'postcss-loader',
                options: {
                    plugins: [new PostCssAt2x(), new AutoPrefixer()],
                },
            },
            'sass-loader',
        ];
        if (otpions.mode == 'production') {
            cssLoader[2]['options']['plugins'].push(
                new PostCssSprites({
                    retina: true, //支持retina，可以实现合并不同比例图片
                    verbose: true,
                    spritePath: otpions.buildPath, //雪碧图合并后存放地址
                    styleFilePath: otpions.buildPath + '/css',
                    basePath: './',
                    filterBy: function(image) {
                        //过滤一些不需要合并的图片，返回值是一个promise，默认有一个exist的filter
                        if (image.originalUrl.indexOf('?__sprites') === -1) {
                            return Promise.reject();
                        }
                        return Promise.resolve();
                    },
                    groupBy: function(image) {
                        //将图片分组，可以实现按照文件夹生成雪碧图
                        var groupName = '/sprite';
                        var url = path.dirname(image.url);
                        url = url.replace(/\.\.\//g, '');
                        url = url.replace(/\.\//g, '');
                        if (image.url.indexOf('@2x') !== -1) {
                            groupName = '/sprite@2x';
                        } else if (image.url.indexOf('@3x') !== -1) {
                            groupName = '/sprite@3x';
                        }
                        return Promise.resolve(url + groupName);
                    },
                    hooks: {
                        onSaveSpritesheet: function(opts, spritesheet) {
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
            );
        }
    }

    //整合
    let loader = {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: cssLoader,
            },
            {
                test: /\.(js|jsx)$/,
                loader: [
                    'babel-loader',
                    {
                        loader: 'eslint-loader',
                        options: {
                            // some options
                            fix: true,
                        },
                    },
                ],
                exclude: /(node_modules|bower_components)/,
            },
            {
                test: /\.(png|jpg|svg)$/,
                loader: imageLoader,
            },
            {
                test: /\.(ttf|woff)$/,
                loader: fontLoader,
            },
        ],
    };
    return loader;
};

export default getLoader;
