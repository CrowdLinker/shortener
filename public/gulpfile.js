var gulp = require('gulp'),
    minifycss = require('gulp-minify-css'),
    autoprefixer = require('gulp-autoprefixer'),
    notify = require('gulp-notify'),
    sass = require('gulp-ruby-sass'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename');

// Where do you store your files?
var paths = {
    sass: ['sass'],
    images: 'buildimage/**/*',
    js: 'js/**/*'
};

gulp.task('css', function() {
    return gulp.src(paths.sass + '/**/*.scss')
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1'))
        .pipe(gulp.dest('css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss({keepSpecialComments: '1'}))
        .pipe(gulp.dest('css'))
});



gulp.task('images', function() {
    return gulp.src(paths.images)
        .pipe(imagemin({
            optimizationLevel: 7
        }))
        .pipe(gulp.dest('image'))
        .pipe(notify({
            message: 'Image minified. All done!'
        }));
});

gulp.task('sass', function () {
  gulp.src('./*.scss')
    .pipe(sass({errLogToConsole: true}))
    .pipe(gulp.dest('./'));
});

gulp.task('watch', function() {
    gulp.watch(paths.sass + '/**/*.scss', ['css']);
    gulp.watch(paths.images, ['images']);
});


// What tasks does running gulp trigger?
gulp.task('default', ['css', 'images','watch']);