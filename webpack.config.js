const path = require('path');
const mix = require('laravel-mix');
const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

module.exports = {
    devtool: 'source-map',
    plugins: [
        // new BundleAnalyzerPlugin()
    ],
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '~': path.resolve('./resources/js')
        }
    },
    output: {
        chunkFilename: 'dist/js/[chunkhash].js',
        path: path.resolve(mix.inProduction() ? './public/build' : './public')
    }
};
