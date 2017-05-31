var gulp        = require('gulp'),
    include     = require('gulp-include'),
    eslint      = require('gulp-eslint'),
    isFixed     = require('gulp-eslint-if-fixed'),
    babel       = require('gulp-babel'),
    uglify      = require('gulp-uglify'),
    rename      = require('gulp-rename'),
    sourcemap   = require('gulp-sourcemaps'),
    runSequence = require('run-sequence'),
    readme      = require('gulp-readme-to-markdown');

var config = {
  src: {
    js: './src/js'
  },
  dist: {
    js: './static/js'
  }
};

gulp.task('es-lint', function() {
  return gulp.src(config.src.js + '/**/*.js')
    .pipe(eslint({fix: true}))
    .pipe(eslint.format())
    .pipe(isFixed(config.src.js));
});

gulp.task('js-build', function() {
  return gulp.src(config.src.js + '/script.js')
    .pipe(include({
      includePaths: [config.src.js]
    }))
    .on('error', console.log)
    .pipe(babel())
    .pipe(uglify())
    .pipe(rename('ucf-page-assets.min.js'))
    .pipe(gulp.dest(config.dist.js));
});

gulp.task('js', function() {
  runSequence('es-lint', 'js-build');
});

gulp.task('readme', function() {
  gulp.src('readme.txt')
    .pipe(readme({
      details: false,
      screenshot_ext: []
    }))
    .pipe(gulp.dest('.'));
});

gulp.task('watch', function() {
  gulp.watch(config.src.js + '/**/*.js', ['js']);
});

gulp.task('default', ['readme']);
