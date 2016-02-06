var OUT_FOLDER  = 'public/',
    ASSETS      = './resources/assets/';

var gulp        = require('gulp'),
    plumber     = require('gulp-plumber'),

    stylus      = require('gulp-stylus'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano     = require('gulp-cssnano'),

    concat      = require('gulp-concat'),
    rename      = require('gulp-rename');

gulp.task('styl', function () {
    "use strict";

    var stream = gulp.src(ASSETS + 'styl/app.styl')
        .pipe(plumber())
        .pipe(stylus({
            'include css': true
        }))
        .pipe(autoprefixer({
            browsers: ['last 3 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(OUT_FOLDER + 'css'))
        .pipe(rename({suffix: ".min"}))
        .pipe(cssnano())
        .pipe(gulp.dest(OUT_FOLDER + 'css'));

    return stream;
});


gulp.task('watch', function () {
    "use strict";

    gulp.watch(ASSETS + 'styl/**/*.styl', ['styl']);
    //gulp.watch('./src/js/**/*.js', ['js']);

});

gulp.task('default', ['styl', 'watch']);