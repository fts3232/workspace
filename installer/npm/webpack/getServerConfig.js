import nodeExternals from 'webpack-node-externals';

let getServerConfig = function(options) {
    let config = {
        //入口文件
        entry: options.srcPath + '/js/entry-server.js',
        target: 'node',
        //输出的文件名 合并以后的js会命名为bundle.js
        output: {
            filename: 'main.js',
            path: options.buildPath + '/server',
            libraryTarget: 'commonjs2',
        },
        externals: [nodeExternals()],
        plugins: [],
    };

    return config;
};
export default getServerConfig;
