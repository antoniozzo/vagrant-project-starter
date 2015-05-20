/* Imports
   ================================================ */

var config      = require('./gulpconfig.json'),
	gulp        = require('gulp'),
	less        = require('gulp-less'),
	uglify      = require('gulp-uglify'),
	jshint      = require('gulp-jshint'),
	concat      = require('gulp-concat'),
	notify      = require('gulp-notify'),
	plumber     = require('gulp-plumber'),
	rename      = require('gulp-rename'),
	stylish     = require('jshint-stylish'),
	minifycss   = require('gulp-minify-css'),
	sourcemaps  = require('gulp-sourcemaps'),
	browserSync = require('browser-sync'),
	svg         = require('gulp-svg-sprite'),
	clean       = require('gulp-rimraf'),
	rev         = require('gulp-rev'),
	shell       = require('gulp-shell'),
	seq         = require('run-sequence'),
	revO        = require('gulp-rev-outdated'),
	gutil       = require('gulp-util');


/* Methods
   ========================================================== */

var onError = function(error) {
	notify.onError({
		title    : 'Gulp',
		subtitle : 'Failure!',
		message  : "Error: <%= error.message %>",
		sound    : 'Beep'
	})(error);

	this.emit('end');
};


/* CSS tasks
   ========================================================== */

// clean
gulp.task('css-clean', function() {
	return gulp.src(config.css.dist, {read: false})
		.pipe(clean());
});

// compile & minify
gulp.task('less', function() {
	return gulp.src(config.css.src)
    	.pipe(plumber({errorHandler: onError}))
		.pipe(sourcemaps.init())
			.pipe(less())
			.pipe(minifycss({noAdvanced: true}))
			.pipe(rename(config.css.id + '.css'))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(config.css.dist));
});


/* JS tasks
   ========================================================== */

// clean
gulp.task('js-clean', function() {
	return gulp.src(config.js.dist, {read: false})
		.pipe(clean());
});

// js linter
gulp.task('js-lint', function() {
	return gulp.src(config.js.src)
		.pipe(plumber({errorHandler: onError}))
		.pipe(jshint())
		.pipe(jshint.reporter(stylish));
});

// compile & minify
gulp.task('js-scripts', ['js-lint'], function() {
	return gulp.src(config.js.vendor.concat(config.js.src))
		.pipe(plumber({errorHandler: onError}))
		.pipe(sourcemaps.init())
			.pipe(concat(config.js.id + '.js'))
			.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(config.js.dist));
});


/* SVG tasks
   ========================================================== */

gulp.task('svg', function() {
	return gulp.src(config.svg.src)
		.pipe(plumber({errorHandler: onError}))
		.pipe(gulp.dest(config.svg.dist))
		.pipe(svg({
			mode : {
				symbol : {
					dest   : '.',
					sprite : config.svg.id + '.svg'
				}
			}
		}))
		.pipe(gulp.dest(config.svg.dist + '/sprite'));
});


/* REVISION tasks
   ========================================================== */

gulp.task('rev-clean', function() {
	return gulp.src([
			config.css.dist + '/*.css',
			config.js.dist + '/*.js',
			config.svg.dist + '/*.svg'
		], {read: false})
		.pipe(revO(1))
		.pipe(clean());
});

gulp.task('rev', function() {
	return gulp.src([
			config.css.dist + '/' + config.css.id + '.css',
			config.js.dist + '/' + config.js.id + '.js',
		], {base: config.rev.dist})
		.pipe(gulp.dest(config.rev.dist))
		.pipe(rev())
		.pipe(gulp.dest(config.rev.dist))
		.pipe(rev.manifest())
		.pipe(gulp.dest(config.rev.dist));
});


/* STYLE GUIDE tasks
   ========================================================== */

gulp.task('styleguide', shell.task([
	'./node_modules/kss/bin/kss-node '
		+ config.styleguide.src
		+ ' ' + config.styleguide.dist
		+ ' --template ' + config.styleguide.template
		+ ' --css ' + config.styleguide.css
]));


/* BROWSER SYNC tasks
   ========================================================== */

gulp.task('browser-sync', function() {
	browserSync({
		proxy : config.browser.host,
		open  : false
	});
});

// Reload all Browsers
gulp.task('bs-reload', function() {
	browserSync.reload({once: true});
});

// Stream reload css 
gulp.task('bs-css', function() {
	return gulp.src(config.css.dist + '/' + config.css.id + '.css')
		.pipe(plumber({errorHandler: onError}))
		.pipe(browserSync.reload({stream: true}));
});


/* WATCH tasks
   ========================================================== */

gulp.task('watch', function() {
	gulp.watch(config.svg.src, ['svg', 'bs-reload']);

	gulp.watch(config.css.watch, function() {
		seq('less', 'rev-clean', 'rev', 'styleguide', 'bs-css');
	});

	gulp.watch(config.js.src, function() {
		seq('js-scripts', 'rev-clean', 'rev', 'bs-reload');
	});
});


/* BUILD tasks
   ========================================================== */

gulp.task('build', function() {
	seq('svg', 'less', 'js-scripts', 'rev-clean', 'rev', 'styleguide');
});

gulp.task('heroku:production', ['build']);


/* DEFAULT task
   ========================================================== */

gulp.task('default', ['watch', 'browser-sync']);
