require('vuetifyjs-mix-extension');

const path = require('path');
const fs = require('fs-extra');
const mix = require('laravel-mix');
const config = require('./webpack.config');

mix.js('resources/js/app.js', 'public/dist/js')
    .sass('resources/sass/app.scss', 'public/dist/css')
    .vue()
    .vuetify('vuetify-loader', 'resources/sass/_variables.scss');

mix.extract();

if(mix.inProduction()) {
    // mix.version() // Use `laravel-mix-versionhash` for the generating correct Laravel Mix manifest file.
} else {
    mix.sourceMaps();
}

mix.webpackConfig(config);

mix.then(() => {
    if(mix.inProduction()) {
        process.nextTick(() => publishAssets());
    }
});

function publishAssets() {
    const publicDir = path.resolve(__dirname, './public');

    fs.removeSync(path.join(publicDir, 'dist'));
    fs.copySync(path.join(publicDir, 'build', 'dist'), path.join(publicDir, 'dist'));
    fs.removeSync(path.join(publicDir, 'build'));
}
