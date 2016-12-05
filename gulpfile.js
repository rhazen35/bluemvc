var gulp         = require('gulp'),

//  Define all task dependencies
    concat       = require('gulp-concat'),
    cssmin       = require('gulp-clean-css'),
    rename       = require("gulp-rename"),
    sass         = require('gulp-sass'),
    uglify       = require('gulp-uglify'),
    sourcemaps   = require('gulp-sourcemaps'),

//  Auto-prefixes css using data from -> www.caniuse.com
    autoprefixer = require('gulp-autoprefixer'),

    basePaths = {
        bower: './bower_components'
    };



gulp.task('default', [
    'scripts',
    'styles',
    'watch'
]);

// scripts task
gulp.task('scripts', function() {
    return gulp.src('./src/js/application.js')
    // init sourcemap functionality
        .pipe(sourcemaps.init())
        .pipe(concat('app.js'))
        .pipe(uglify({
            mangle: false
        }))
        .pipe(rename({
            suffix: '.min'
        }))
        // Write source maps
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./public/js/'));
});

// styles task
gulp.task('styles', function() {
    return gulp.src('./src/scss/**/*.scss')

    // init sourcemap functionality
        .pipe(sourcemaps.init())

        // Compile sass/scss
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))



        // Add vendor prefixes
        .pipe(autoprefixer({
            browsers: ['last 2 versions', '> 5%', 'ie 10-11'],
            cascade: true
        }))

        // Create minified css
        .pipe(cssmin())

        // rename to style.min.css
        .pipe(rename({
            suffix: '.min'
        }))
        // Write source maps
        .pipe(sourcemaps.write('./maps'))

        // store result in /web/css/style.min.css
        // This is the file that should be linked to in html
        .pipe(gulp.dest('./public/css/'));
});

// watch task: Automatically run tasks when a change to a file is detected.
gulp.task('watch', function() {
    gulp.watch('./src/js/**/*.js', ['scripts']);

    gulp.watch(
        'src/scss/**/*.scss',
        ['styles']
    );
});
