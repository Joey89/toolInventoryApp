/*jshint esversion: 6 */
var gulp = require('gulp'),
	sass = require('gulp-sass'),
	cleanCSS = require('gulp-clean-css'),
	uglify = require('gulp-uglify'),
	livereload = require('gulp-livereload'),
	imagemin = require('gulp-imagemin');

//Sass + live reload use: gulp watch
gulp.task('sass', function() {
  gulp.src('src/sass/main.scss')
  	.pipe(sass({style: 'expanded'}))
 	.pipe(gulp.dest('public/css'))
 	.pipe(livereload());
});
//Min Css Files - Might want to relook maybe.
gulp.task('min.css', () => {
	gulp.src('public/css/**/*.css')
	.pipe(cleanCSS())
	.pipe(gulp.dest('public/css/'));
});
// Min Js Files
gulp.task('min.js', () => {
	gulp.src('src/js/*.js')
	.pipe(uglify())
	.pipe(gulp.dest('public/js/'));
});
//Min images
gulp.task('min.image', () => {
	  gulp.src('src/images/*')
    .pipe(imagemin())
    .pipe(gulp.dest('public/images/'));
});
//Min ewverything
gulp.task('min.all', ['min.js', 'min.css', 'min.image'],() => {

});

gulp.task('watch', () =>{
	livereload.listen();
	gulp.watch('src/sass/**/*.scss', ['sass']); 
});