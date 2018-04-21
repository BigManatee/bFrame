var gulp = require('gulp'),
	sass = require('gulp-sass'),
	sourcemaps = require('gulp-sourcemaps'),
	minify = require('gulp-minify-css');
 
gulp.task('sass', function () {
	return gulp.src('./public/static/scss/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass().on('error', sass.logError))
		.pipe(minify())
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('./public/static/css'));
});
 
gulp.task('sass:watch', function () {
	var watcher = gulp.watch('./public/static/scss/*.scss', ['sass']);
	watcher.on('change', function(event) {
    	console.log('File %s was %s', event.path, event.type);
  	});
});
