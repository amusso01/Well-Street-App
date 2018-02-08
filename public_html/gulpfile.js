'use strict';

//dependency

var gulp = require('gulp');
var sass = require('gulp-sass');
var minifyCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var changed = require('gulp-changed');
var livereload = require('gulp-livereload');


/*-scss/ css folder*/

var SCSS_SRC='./src/style.scss';
var SCSS_DEST='./media/css/';


//TASK->complile

gulp.task('compile_scss',function(){
    gulp.src(SCSS_SRC)
        .pipe(sass().on('error',sass.logError))
        .pipe(minifyCSS())
        .pipe(rename({suffix:'.min'}))
        .pipe(changed(SCSS_DEST))
        .pipe(gulp.dest(SCSS_DEST))
        .pipe(livereload());

});

//TASK->detect changes in scss

gulp.task('watch_scss',function(){
    livereload.listen();
    gulp.watch(SCSS_SRC,['compile_scss']);
});


//run TASK

gulp.task('default',['watch_scss']);