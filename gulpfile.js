const gulp = require('gulp');
const babel = require('gulp-babel');
const zip = require('gulp-zip');
const cssnano = require('cssnano');
const shell = require('gulp-shell');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');
const rtlcss = require('gulp-rtlcss');
const rename = require('gulp-rename');
const autoprefixer = require('autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass')(require('sass'));

/*
===========================================================
=
= Change these constants according to your need
=
====================================================
*/

// 1# Script files path

const scriptPath = {

    scriptSource: [

        './public/assets/src/js/vendor/*.js',
        './public/assets/src/js/scripts/*.js',
        '!./public/assets/src/js/conditional/*.js',
    ],

    scriptDist: "./public/assets/build/js/",
}
const outputJavaScriptFileName = "simple-gdpr-cookie-compliance-public.js";

let conditionalScriptPath = {
    conditionalScriptSource: [

        './public/assets/src/js/conditional/*.js',
    ],
    conditionalScriptBuildPath: "./public/assets/build/js/conditional/",
}

// 2# SASS/SCSS file path

const sassPath = {

    sassSource: [

        "./public/assets/src/scss/**/*.scss",
        "!./public/assets/src/scss/conditional/*.scss",
    ],
    sassDist: "./public/assets/build/css/",
}
const compiledSassCssFileName = "simple-gdpr-cookie-compliance-public.css";

let conditionalSassPath = {
    conditionalSassSource: [

        "./public/assets/src/scss/conditional/**"
    ],
    compiledConditionalSassBuildPath: "./public/assets/build/css/conditional/",
}

// 3# LTR & RTL CSS path

const rtlCssPath = {

    rtlCssSource: "./public/assets/build/css/" + compiledSassCssFileName,
    rtlCssDist: "./public/assets/build/css/", // where would you like to save your generated RTL CSS
}

// 4# zip file path

let outputBuildFileZip = 'simple-gdpr-cookie-compliance.zip';

const sourceFilesDirsToCompress = {

    sourceFilesDirs: [

        './*',
        './*/**',

        '!./.gitignore',
        '!./.github/**',
        '!./.vscode',
        '!./public/assets/src/**',
        '!./gulpfile.js',
        '!./package.json',
        '!./package-lock.json',
        '!./node_modules/**',
        '!./composer.json',
        '!./composer.lock',
        '!./sftp-config.json',
        '!./webpack.mix.js',
        '!./babelrc',
        '!./distignore'
    ],

    pathToSaveProductionZip: "./",
}

/*
===========================================================
=
= Define task (Almost no chnages required)
=
====================================================
*/

// Task to compile scripts.

gulp.task('scriptsTask', function () {
    return gulp.src(scriptPath.scriptSource)
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(concat(outputJavaScriptFileName))
        .pipe(uglify())
        .pipe(gulp.dest(scriptPath.scriptDist));
});

gulp.task('conditionalScriptsTask', function () {
    return gulp.src(conditionalScriptPath.conditionalScriptSource)
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(uglify())
        .pipe(gulp.dest(conditionalScriptPath.conditionalScriptBuildPath));
});

// Task to compile SASS/SCSS files.

gulp.task('sassTask', function () {
    let onError = function (err) {
        notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep"
        })(err);
        this.emit('end');
    };
    return gulp.src(sassPath.sassSource)
        .pipe(sourcemaps.init()) // initialize sourcemaps first
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(postcss([autoprefixer('last 2 version'), cssnano()])) // PostCSS plugins
        .pipe(concat(compiledSassCssFileName))
        .pipe(sourcemaps.write('.')) // write sourcemaps file in current directory
        .pipe(gulp.dest(sassPath.sassDist)); // put final CSS in dist folder
});

gulp.task('conditionalSassTask', function () {
    let onError = function (err) {
        notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep"
        })(err);
        this.emit('end');
    };
    return gulp.src(conditionalSassPath.conditionalSassSource)
        .pipe(sourcemaps.init())
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(postcss([autoprefixer('last 2 version'), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(conditionalSassPath.compiledConditionalSassBuildPath));
});

// Task to convert LTR css to RTL

gulp.task('doRtlTask', function () {
    return gulp.src(rtlCssPath.rtlCssSource)
        .pipe(rtlcss()) // Convert to RTL.
        .pipe(rename({ suffix: '-rtl' })) // Append "-rtl" to the filename.
        .pipe(gulp.dest(rtlCssPath.rtlCssDist)); // Output RTL stylesheets.
});

// Task to generate Production Zip File

gulp.task('zipProductionFiles', function () {
    return gulp.src(sourceFilesDirsToCompress.sourceFilesDirs)
        .pipe(zip(outputBuildFileZip))
        .pipe(gulp.dest(sourceFilesDirsToCompress.pathToSaveProductionZip))
});

//=========================================
// = C O M M A N D S                      =
//=========================================
//
// 1. Command: gulp assets
// 2. Command: gulp zip
//
//=========================================


gulp.task('default', shell.task(

    'echo ===== ⛔️ Ooops! gulp default command is disabled in this project. These are the available commands: gulp assets & gulp zip =====',
));

gulp.task('zip', gulp.series('zipProductionFiles', (done) => {
    done();
}));

gulp.task('assets', gulp.series('scriptsTask', 'conditionalScriptsTask', 'sassTask', 'conditionalSassTask', 'doRtlTask', (done) => {

    gulp.watch(scriptPath.scriptSource, gulp.series('scriptsTask'));
    gulp.watch(sassPath.sassSource, gulp.series('sassTask'));
    gulp.watch(rtlCssPath.rtlCssSource, gulp.series('doRtlTask'));
    gulp.watch(conditionalSassPath.conditionalSassSource, gulp.series('conditionalSassTask'));
    gulp.watch(conditionalScriptPath.conditionalScriptSource, gulp.series('conditionalScriptsTask'));
    done();
}));