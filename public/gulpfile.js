var gulp = require('gulp');
var browserify = require('browserify');
var watchify = require('watchify');
var source = require('vinyl-source-stream');

gulp.task('timereport', function() {
  var watchBundle = watchify(browserify('./js/timereport.js', watchify.args));

  watchBundle.on('update', rebundle);

  function rebundle() {
    return watchBundle.bundle()
    .pipe(source('timereport-bundle.js'))
    .pipe(gulp.dest('./dist/'));
  }

  rebundle();
});
