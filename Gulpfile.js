var gulp = require('gulp'),
		watch = require('gulp-watch'),
		phpUnit= require('gulp-phpunit'),
		shell = require('gulp-shell'),
		notify = require('gulp-notify'),
		_ = require('lodash');

gulp.task('phpunit', function () {
	gulp.src('')
		.pipe(shell('clear'));
	gulp.src('./phpunit.xml').pipe(phpUnit('phpunit'), {notify:true})
		.on('error', notify.onError(testNotification('fail', 'phpunit')))
		.pipe(notify(testNotification('pass', 'phpunit')));
});

function testNotification(status, pluginName, override) {
	var options = {
		title: ( status == 'pass' ) ? 'Tests Passed' : 'Tests Failed',
		message: ( status == 'pass' ) ? '\n\nAll tests have passed!\n\n' : '\n\nOne or more tests failed...\n\n',
		icon: __dirname + '/icons/'+ status +'.png'
	};
	options = _.merge(options, override);
	return options;
}
gulp.task('watch', function () {
	gulp.watch(['tests/**/*.php', '**/*.php'], ['phpunit']);
});

gulp.task('develop', function () {
	gulp.start('phpunit');
	gulp.start('watch');
});

gulp.task('default', function () {
	gulp.start('phpunit')
});
