var gulp          = require('gulp'),
	gutil         = require('gulp-util' ),
	sass          = require('gulp-sass'),
	cleancss      = require('gulp-clean-css'),
	rename        = require('gulp-rename'),
	autoprefixer  = require('gulp-autoprefixer'),
	sourcemaps    = require('gulp-sourcemaps')
	notify        = require('gulp-notify'),
	tinypng 	  = require('gulp-tinypng-compress');


gulp.task('styles', function() {
	return gulp.src('scss/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({ outputStyle: 'expanded' }).on("error", notify.onError()))
		//.pipe(rename({ suffix: '.min', prefix : '' }))
		.pipe(autoprefixer(['last 4 versions']))
		.pipe(sourcemaps.write())
		//.pipe(cleancss( /*{level: { 1: { specialComments: 0 } } }*/)) // Opt., comment out when debugging
		.pipe(gulp.dest('../'))
});

gulp.task('tinypng', function () {
	gulp.src('../images/**/*.{png,jpg,jpeg}')
		.pipe(tinypng({
			key: 'fCqEOwAjE-xjBf-xYe0VWLCvPQnco849',
			sigFile: 'images/.tinypng-sigs',
			log: true
		}))
		.pipe(gulp.dest('../images/'));
});

gulp.task('watch', function() {
	gulp.watch('scss/**/*.scss', gulp.parallel('styles'));
});

gulp.task('default', gulp.parallel('styles', 'watch'));
