"use strict";

// директории исходников и готовых файлов
const { src, dest } = require("gulp");
const gulp = require("gulp");
const autoprefixer = require("gulp-autoprefixer");
const cssbeautify = require("gulp-cssbeautify");
const removeComments = require("gulp-strip-css-comments");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const cssnano = require("gulp-cssnano");
const rigger = require("gulp-rigger");
const uglify = require("gulp-uglify");
const plumber = require("gulp-plumber");
const imagemin = require("gulp-imagemin");
const gulpif = require("gulp-if");
const del = require("del");
const htmlPartial = require("gulp-html-partial");
const fileinclude = require("gulp-file-include");
const browsersync = require("browser-sync").create();
const svgSprite = require("gulp-svg-sprite");
const webpack = require("webpack");
const webpackStream = require("webpack-stream");
require("dotenv").config(); // need to load .env
// const RevAll = require("gulp-rev-all");
const exec = require("child_process").exec;

let isDev = true;
let isProd = !isDev;

const ser = "true" == process.env.USE_BLADE;

const webConfig = {
    entry: {
        bundle: "./src/assets/js/app.js",
    },
    output: {
        filename: "[name].js",
        libraryTarget: "var",
        library: "microLib",
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: "babel-loader",
                exclude: "/node_modules/",
            },
        ],
    },
    mode: isDev ? "development" : "production",
    devtool: isDev ? "eval" : false,
};

/* Paths */
const path = {
    build: {
        html:
            "true" == process.env.USE_BLADE
                ? "../resources/views/dist/"
                : "./dist/",
        script:
            "true" == process.env.USE_BLADE
                ? "../public/js/"
                : "./dist/assets/js/",
        css:
            "true" == process.env.USE_BLADE
                ? "../public/css/"
                : "./dist/assets/css/",
        images:
            "true" == process.env.USE_BLADE
                ? "../public/img/dist/"
                : "./dist/assets/img/",
        svg:
            "true" == process.env.USE_BLADE
                ? "../public/svg/"
                : "./dist/assets/sprite/",
    },
    src: {
        html: "src/*.html",
        script: "src/assets/js/dest/bundle.js",
        css: "src/assets/sass/style.scss",
        images: "src/assets/img/**/*.{jpg,png,svg,gif,ico}",
        svg: "src/assets/svg/**/*.svg",
    },
    watch: {
        html: "src/**/*.html",
        script: "src/assets/js/**/*.js",
        css: "src/assets/sass/**/*.scss",
        images: "src/assets/img/**/*.{jpg,png,svg,gif,ico}",
        svg: "src/assets/svg/**/*.svg",
    },
    // clean: "./dist",
};

function script() {
    return gulp
        .src("./src/assets/js/app.js")
        .pipe(webpackStream(webConfig), webpack)
        .pipe(gulp.dest(path.build.script))
        .pipe(gulpif(!ser, browsersync.stream()));
}

/* Настройка локального сервера */
function browserSync(done) {
    browsersync.init({
        server: {
            baseDir: "./dist/",
        },
        port: 4000,
    });
}

function browserSyncReload(done) {
    browsersync.reload();
}

/* Tasks для работы с html файлами */
function html() {
    cleanLaravelViewCache();
    // panini.refresh();
    return (
        src(path.src.html, { base: "src/" }) // считываем все html в папке src *то что считываем*
            // подзадачи для html файлов
            .pipe(plumber())
            .pipe(
                fileinclude({
                    prefix: "@@",
                    basepath: "./src/partials/",
                })
            )
            .pipe(
                gulpif(
                    ser,
                    rename({
                        extname: ".blade.php",
                    })
                )
            )
            .pipe(dest(path.build.html))
            // .pipe(exec('php ../artisan view:clear')) // clear cache of laravel templates
            .pipe(gulpif(!ser, browsersync.stream()))
    );
}

function css() {
    return (
        src(path.src.css, { base: "src/assets/sass/" })
            .pipe(plumber())
            .pipe(sass())
            .pipe(
                autoprefixer({
                    Browserslist: ["last 8 versions"],
                    cascade: true,
                })
            )
            .pipe(cssbeautify())
            .pipe(dest(path.build.css))
            .pipe(
                gulpif(
                    isProd,
                    cssnano({
                        zindex: false,
                        discardComments: {
                            removeAll: true,
                        },
                    })
                )
            )
            .pipe(removeComments())
            .pipe(
                gulpif(
                    isProd,
                    rename({
                        suffix: ".min",
                        extname: ".css",
                    })
                )
            )
            // .pipe(RevAll.revision())
            .pipe(dest(path.build.css))
            .pipe(gulpif(!ser, browsersync.stream()))
    );
}

function images() {
    return src(path.src.images).pipe(imagemin()).pipe(dest(path.build.images));
}

function svg() {
    // Basic configuration example
    var config = {
        mode: {
            symbol: {
                // symbol mode to build the SVG
                render: {
                    css: false, // CSS output option for icon sizing
                    scss: false, // SCSS output option for icon sizing
                },
                dest: "./", // destination folder
                prefix: ".svg--%s", // BEM-style prefix if styles rendered
                sprite: "sprite.svg", //generated sprite name
            },
        },
    };
    return src(path.src.svg).pipe(svgSprite(config)).pipe(dest(path.build.svg));
}

function clean() {
    return del(
        [
            path.build.css,
            path.build.html,
            path.build.svg,
            path.build.images,
            path.build.script,
        ],
        { force: true }
    );
}

function cleanLaravelViewCache() {
    // return del("../storage/framework/views/*.php", {force:true});
    exec("php ../artisan view:clear"); // clear cache of laravel templates
}

async function cleanCache() {
    // return del("../storage/framework/views/*.php", {force:true});
    exec("php ../artisan view:clear"); // clear cache of laravel templates
}

// слежка за файлами, и вызов
function watchFiles() {
    gulp.watch([path.watch.html], html);
    gulp.watch([path.watch.css], css);
    gulp.watch([path.watch.script], script);
    gulp.watch([path.watch.images], images);
    gulp.watch([path.watch.svg], svg);
}

const build = gulp.series(clean, gulp.parallel(html, css, images, script, svg)); // для выполнения всех тасков
const watch = gulp.parallel(build, watchFiles, browserSync); //browserSync

/* Exports Tasks */
exports.html = html;
exports.css = css;
exports.script = script;
exports.images = images;
exports.svg = svg;
exports.clean = clean;
exports.cleanLaravelViewCache = cleanLaravelViewCache;
exports.cleanCache = cleanCache;
exports.build = build;
exports.watch = watch;
exports.default = watch;
