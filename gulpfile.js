var gulp = require('gulp');

var plugins = require('gulp-load-plugins')();
var prettify = require('gulp-prettify');
var cache = require('gulp-cache');
var clean = require('gulp-clean');

var source = './src'; //source folder
var destination = './dist'; //deploy folder

//LESS -> CSS
gulp.task('css', function () {
  return gulp.src(source + '/css/styles.less')
    .pipe(plugins.less())
    .pipe(plugins.csscomb())
    .pipe(plugins.cssbeautify({indent: '  '}))
    .pipe(plugins.autoprefixer())
    .pipe(gulp.dest(destination + '/css/'));
});

/*minify css
gulp.task('minify', function () {
  return gulp.src(destination + '/css/*.css')
    .pipe(plugins.csso())
    .pipe(plugins.rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(destination + '/css/'));
});*/

gulp.task('clear', function (done) {
  return cache.clearAll(done);
});
 
gulp.task('prettifyHTML', function() {
  gulp.src(source + '/html/*')
    .pipe(prettify({indent_size: 2}))
    .pipe(gulp.dest(destination + '/html/'))
});

gulp.task('prettifyPHP', function() {
  gulp.src(source + '/php/**/*.php')
    .pipe(prettify({indent_size: 2}))
    .pipe(gulp.dest(destination + '/php/'))
});

gulp.task('prettifyJS', function() {
  gulp.src(source + '/js/*')
    /*.pipe(prettify({indent_size: 2}))*/
    .pipe(gulp.dest(destination + '/js/'))
});

gulp.task('moveAssets', function() {
  gulp.src(source + '/assets/**')
    .pipe(gulp.dest(destination + '/assets/'))
});

gulp.task('moveLib', function() {
  gulp.src(source + '/lib/**')
    .pipe(gulp.dest(destination + '/lib/'))
});

gulp.task('remove', function () {
  return gulp.src(destination, {read: false})
    .pipe(clean());
});

gulp.task('moveIndex', function () {
  gulp.src(source + '/index.php')
    .pipe(gulp.dest(destination))
});

gulp.task('default', ['css', 'prettifyHTML', 'prettifyPHP', 'prettifyJS', 'moveAssets', 'moveLib', 'moveIndex']);
gulp.task('cc', ['clear']);
gulp.task('clean', ['remove'])
gulp.task('rebuild', ['clean', 'clean', 'css', 'prettifyHTML', 'prettifyPHP', 'prettifyJS', 'moveAssets', 'moveLib', 'moveIndex'])