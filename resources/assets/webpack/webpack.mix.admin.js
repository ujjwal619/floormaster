let mix = require("laravel-mix");

if (!mix.config.production) {
    mix.webpackConfig({devtool: "inline-source-map"}).sourceMaps();
}

mix.
    setPublicPath(path.normalize("public/admin")).
    setResourceRoot("../").
    js("resources/assets/domain/admin/js/theme.js", "js/theme.js").version().
    js("resources/assets/domain/admin/js/app.js", "js/app.js").version().
    extract([
        "jquery", "popper.js", "bootstrap", "js-cookie", "jquery-smooth-scroll", "wnumb", "lodash",
        "vue", "malihu-custom-scrollbar-plugin", "axios", "@deveodk/vue-toastr"
    ]).
    autoload({
        jquery: ["$", "jQuery", "jquery", "window.jQuery"],
    }).
    sass("resources/assets/domain/admin/sass/vendor.scss", "css/vendor.css").version().
    sass("resources/assets/domain/admin/sass/theme.scss", "css/theme.css").version().
    sass("resources/assets/domain/admin/sass/app.scss", "css/app.css").version().
    sass("resources/assets/domain/admin/sass/dashboard/vendor.scss", "css/dashboard-vendor.css").version().
    sass("resources/assets/domain/admin/sass/dashboard/app.scss", "css/dashboard-app.css").version();
