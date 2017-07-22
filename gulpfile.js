'use strict';

const gulp = require('gulp'),
    sass = require('gulp-sass'),
    minifyCSS = require('gulp-minify-css'),
    concatCSS = require('gulp-concat-css'),
    concatJS = require('gulp-concat'),
    autoprefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    babel = require('gulp-babel');

/**
 * Tarea para compilar scss
 * 1) Compila scss
 * 2) Agrega los prefijos propietarios
 * 3) Concatena a styles.min.css
 * 4) Minifica el archivo
 * 5) Mueve el resultado a la carpeta destino
 */
gulp.task('scss', function() {
    gulp.src('./resources/src/scss/**/*.scss')
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .pipe(autoprefixer({
            versions: ['last 2 browsers']
        }))
        .pipe(concatCSS('styles.min.css'))
        .pipe(minifyCSS({
            keepBreaks: false
        }))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('es5', () => {
    gulp.src('./resources/src/js/**/*.js')
        .pipe(babel())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('default', () => {
    gulp.watch('./resources/src/scss/**/*.scss', ['scss']);
});