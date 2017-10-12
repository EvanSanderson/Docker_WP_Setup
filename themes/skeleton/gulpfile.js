require('events').EventEmitter.prototype._maxListeners = 100;

'use strict';
var gulp = require('gulp'),
    browserSync = require('browser-sync').create(),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    minifyCSS = require('gulp-minify-css'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    sourcemaps = require('gulp-sourcemaps'),
    fileinclude = require('gulp-file-include'),
    es = require('event-stream'),
    cleanCSS = require('gulp-clean-css'),
    usemin = require('gulp-usemin'),
    inject = require('gulp-inject'),
    imagemin = require('gulp-imagemin'),
sass = require('gulp-sass');

gulp.task('default', function () {
  browserSync.init(null, {
    proxy: "wp.dev"
    });

	gulp.watch('./sass/**/*.scss', ['sass'], browserSync.reload);
  gulp.watch('./img/**/*').on('change', browserSync.reload);
  gulp.watch('./js/**/*.js').on('change', browserSync.reload);

});


// Run SASS compiling and reloading
gulp.task('sass', function() {
     gulp.src('./sass/**/*.scss')
      .pipe(sourcemaps.init())
        .pipe(sass({
          errLogToConsole: true
        }))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./css'))
        .pipe(browserSync.stream());

     return   gulp.src('css/*.css')
      .pipe(minifyCSS())
      .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9'))
      .pipe(concat('style.min.css'))
      .pipe(gulp.dest('dist/css'))
      .pipe(browserSync.stream());

});

// Minify CSS
gulp.task('minify', ['sass'], function() {
  return gulp.src('./css/*.css')
    .pipe(cleanCSS({
      compatibility: '*'
    }))
    .pipe(gulp.dest('dist/css'));
});

// Concat and uglify JavaScript
gulp.task('scripts', ['minify'], function() {
  return gulp.src('./js/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'))
      .pipe(browserSync.stream());
});

// Image minification
gulp.task('images', function() {
  return es.merge(
    gulp.src(['./img/**/*', '!dist/img/**/*.gif'])
          .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{
              removeViewBox: false
            },
            {
              cleanupIDs: false
            },
            {
              collapseGroups: false
            },
          {
            convertShapeToPath: false
          }]
          }))
          .pipe(gulp.dest('./img')),
    gulp.src('./img/**/*.gif')
      .pipe(gulp.dest('dist/images')),
    gulp.src(['./img/*.png', './img/*.jpg'])
          .pipe(imagemin({
            progressive: true
          }))
          .pipe(gulp.dest('dist/images')),
    gulp.src('./*.ico')
      .pipe(gulp.dest('dist/images'))
  );
});

// Main build function
gulp.task('build', function(){
  return gulp.start(
    'minify',
    'images'
  );
});