const VueSSRClientPlugin = require('vue-server-renderer/client-plugin')

// ...

const config = merge(baseConfig, {
    target: 'web',
    entry: './src/entry.client.js',
    plugins: [
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'development'),
            'process.env.VUE_ENV': '"client"'
        }),
        /*new webpack.optimize.CommonsChunkPlugin({
            name: 'vender',
            minChunks: 2
        }),
        // extract webpack runtime & manifest to avoid vendor chunk hash changing
        // on every build.
        new webpack.optimize.CommonsChunkPlugin({
            name: 'manifest'
        }),*/
        new VueSSRClientPlugin()
    ]
})