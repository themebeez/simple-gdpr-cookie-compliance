'use strict';
// include all necessary plugins in gulp file
var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var rtlcss = require('gulp-rtlcss');
// Task defined for java scripts bundling and minifying
// task to convert LTR css to RTL
gulp.task('dortl', function() {
    return gulp.src(['assets/build/css/simple-gdpr-cookie-compliance-public.css'])
        .pipe(rtlcss()) // Convert to RTL.
        .pipe(rename({ suffix: '-rtl' })) // Append "-rtl" to the filename.
        .pipe(gulp.dest('assets/build/css/')); // Output RTL stylesheets.
});
// declaring final task and command tasker
// just hit the command "gulp" it will run the following tasks...
gulp.task('default', gulp.series('dortl', (done) => {

    gulp.watch('assets/build/css/simple-gdpr-cookie-compliance-public.css', gulp.series('dortl'));

    done();
}));