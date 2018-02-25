const Encore = require('@symfony/webpack-encore');
const HardSourceWebpackPlugin = require('hard-source-webpack-plugin');
Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    //clean
    .cleanupOutputBeforeBuild()
    //source
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/main', './assets/js/main.js')
    .addStyleEntry('css/main', './assets/scss/main.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()
    //vue
    .enableVueLoader()
    //webpack cache
    .addPlugin(new HardSourceWebpackPlugin())

    // show OS notifications when builds finish/fail
    .enableBuildNotifications(!Encore.isProduction())
;
// export the final configuration
let config = Encore.getWebpackConfig();
config.watchOptions = {
    poll: true,
};
module.exports = config;
