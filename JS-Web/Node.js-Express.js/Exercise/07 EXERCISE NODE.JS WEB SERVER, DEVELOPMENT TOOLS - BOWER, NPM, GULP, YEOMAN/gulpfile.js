let gulp = require('gulp');
let htmlmin = require('gulp-htmlmin');

gulp.task('minify', function () {
  return gulp.src('./views/*.html', { base: './' })
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(gulp.dest('./'))
});
