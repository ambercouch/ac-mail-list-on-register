var siteLocalUrl = 'xxxxx.local';
var defaultBrowser = ['C:\\Program Files \\Firefox Developer Edition\\firefox.exe', 'Chrome'];

const gulp = require('gulp');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const browserSync = require('browser-sync').create();
const pipeline = require('readable-stream').pipeline;
const uglify = require('gulp-uglify');
//const svgstore = require('gulp-svgstore');
//const svgmin = require('gulp-svgmin');
//const rename = require('gulp-rename');

/*
 SOURCE FILES
 */
var jsScripts;
var jsPath = 'src/js/';
var jsAdminPath = 'src/admin/js/';
var jsNpmPath = 'node_modules/'
var jsCustomScripts = [
    'acelr-main.js',
    // 'custom.js',
];
var jsAdminScripts = [
    'acelr-admin.js'
];

var jsNpmScripts = [
    //All ready deprecated with browserify
    //'fitvids/dist/fitvids.js',
    'modaal/dist/js/modaal.js',
    //'flickity/dist/flickity.pkgd.js'
];

var cssNpmScripts = [
    //Add any vendor css scripts here that you want to include
    //'flickity/dist/flickity.css'
    //'remodal/dist/remodal.css',
    'modaal/dist/css/modaal.scss',
];

for (var i = 0; i < jsCustomScripts.length; i++) {
    //Add the default path
    jsCustomScripts[i] = jsPath + jsCustomScripts[i];
}
for (var i = 0; i < jsNpmScripts.length; i++) {
    //Add the default path
    jsNpmScripts[i] = jsNpmPath + jsNpmScripts[i];
}

for (var i = 0; i < cssNpmScripts.length; i++) {
    //Add the default path
    cssNpmScripts[i] = jsNpmPath + cssNpmScripts[i];
}

for (var i = 0; i < jsAdminScripts.length; i++) {
    //Add the default path
    jsAdminScripts[i] = jsAdminPath + jsCustomScripts[i];
}

//Concat the vendor scripts with the custom scripts
jsScripts = jsNpmScripts.concat(jsCustomScripts);



/*
 GULP TASKS
 */

//TASK: scripts - Concat and uglify all the vendor and custom javascript
function scripts() {
    return pipeline(
        gulp.src(jsScripts),
        concat('scripts-acsm.js'),
        uglify(),
        gulp.dest('dist/js/')
    );
}

function adminScripts() {
    return pipeline(
        gulp.src(jsAdminScripts),
        concat('scripts-acsm.js'),
        uglify(),
        gulp.dest('dist/admin/js/')
    );
}


//compile scss into css
function styles() {
    return gulp.src('src/scss/main.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error',sass.logError))
        .pipe(postcss([ autoprefixer(), cssnano({zindex: false}) ]))
        .pipe(concat('styles-acsm.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css/'))
        .pipe(browserSync.stream());
}

function vendorStyles(){
    return gulp.src(cssNpmScripts)
        .pipe(concat('_vendor.scss'))
        .pipe(gulp.dest('assets/scss/'));

    //console.log("testing vendorStyles")

}

function svgdefs() {
    return gulp
        .src('assets/images/svg/*.svg')
        .pipe(svgmin())
        .pipe(rename({prefix: 'icon-'}))
        .pipe(svgstore())
        .pipe(rename("defs.svg"))
        .pipe(gulp.dest('templates/inc/'));
}

function serve() {
    browserSync.init({
        proxy: siteLocalUrl,
        browser: defaultBrowser
    });

    gulp.watch("src/scss/**/*.scss",  styles);
    //gulp.watch("assets/images/svg/**/*.svg", svgdefs).on('change', browserSync.reload);
    //gulp.watch("templates/**/*.twig").on('change', browserSync.reload);
    gulp.watch("src/js/**/*.js", scripts ).on('change', browserSync.reload);

}

exports.serve = serve;
exports.styles = styles;
exports.scripts = scripts;
exports.adminScripts = adminScripts;
exports.svgdefs = svgdefs;
exports.vendorStyles = vendorStyles;
