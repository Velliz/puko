let gulp = require('gulp');
let minifyCSS = require("gulp-minify-css");
let minifyHTML = require('gulp-htmlmin');
let babel = require('gulp-babel');
let uglify = require('gulp-uglify');
let stripDebug = require('gulp-strip-debug');

gulp.task('minifycss', done => {
    gulp.src('./assets/css/**/*.css')
        .pipe(minifyCSS())
        .pipe(gulp.dest('./assets/css/'));
    done();
});

gulp.task('minifyhtml', function () {
    return gulp.src('./assets/**/*.html')
        .pipe(minifyHTML({
            collapseWhitespace: true,
            removeComments: true,
            minifyCSS: false,
            minifyJS: true
        }))
        .pipe(gulp.dest('./assets/'));
});

gulp.task('minifyjs', function () {
    return gulp.src('./assets/scripts/**/*.js')
        .pipe(babel({
            presets: [
                ['@babel/env', {
                    modules: false
                }]
            ]
        }))
        .pipe(uglify())
        .pipe(stripDebug())
        .pipe(gulp.dest('./assets/scripts/'));
});

gulp.task('minify', gulp.parallel(
    'minifycss',
    'minifyhtml',
    'minifyjs'
));
