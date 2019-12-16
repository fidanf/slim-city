var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var autoprefixer = require('gulp-autoprefixer');
var apidoc = require('gulp-apidoc');
var nano = require('gulp-cssnano');

// Javascript files
var scripts = [
    "resources/assets/scripts/jquery.dataTables.min.js",
    "resources/assets/scripts/dataTables.bootstrap.min.js"
];

gulp.task('scripts', function () {
	return gulp.src(scripts)
	.pipe(concat('app.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./public/js'))
});

// CSS & Sass files
var styles = [
    "resources/assets/styles/bootstrap.min.css",
    "resources/assets/styles/dataTables.bootstrap.min.css",
    "resources/assets/styles/jquery-ui.min.css",
    "resources/assets/styles/app.scss"
];

gulp.task('styles', function () {
return gulp.src(styles)
	.pipe(sass())
	.pipe(nano())
	.pipe(concat('app.css'))
	.pipe(gulp.dest('./public/css'))
});

// Api Doc
gulp.task('apidoc', function(done){
    apidoc({
        src: "./",
        dest: "doc/",
        includeFilters: [ ".*\\.php$" ]
    }, done);
});

gulp.task('watch-build', function () {
	// /**/**/*.ext pour inclure les éventuels subdir
	gulp.watch('resources/assets/styles/**/**/*.scss', ['styles']);
	gulp.watch('resources/assets/scripts/**/**/*.js', ['scripts']);
	gulp.watch('app/Controllers/**/**/*.php', ['apidoc']);
});

gulp.task('default', ['styles', 'scripts']);

gulp.task('watch', ['default', 'watch-build']);