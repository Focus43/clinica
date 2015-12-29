module.exports = function( gulp ){

    // Get the name of the parent directory so we can use it to "namespace" tasks
    var directoryName = require('path').basename(__dirname);

    /** Return full absolute filesystem path to something in this directory */
    function _pathTo(_path){
        return __dirname + '/' + _path;
    }

    /** Prepends a task name with the parent directory for uniqueness. */
    function _taskName( taskName ){
        return directoryName + ':' + taskName;
    }

    /**
     * Include required libraries, and declare source paths.
     */
    var utils   = require('gulp-util'),
        concat  = require('gulp-concat'),
        uglify  = require('gulp-uglify'),
        sass    = require('gulp-ruby-sass'),
        jshint  = require('gulp-jshint'),
        sources = {
            scss: {
                dashboard: _pathTo('css/src/clinica.dashboard.scss'),
                app: _pathTo('css/src/clinica.app.scss'),
                ie8: _pathTo('css/src/ie8.scss')
            }
        };

    /**
     * Sass compilation
     * @param _style
     * @returns {*|pipe|pipe}
     */
    function runSass( files, _style ){ utils.log("runSass" )
        return sass(files, {
                compass:    true,
                style:      (_style || 'nested')
            })
            .on('error', function( err ){
                utils.log(utils.colors.red(err.toString()));
                this.emit('end');
            })
            .pipe(gulp.dest(_pathTo('css/')));
    }

    /** Register individual tasks */
    //gulp.task(_taskName('jshint'), function(){ return runJsHint(sources.js.app); });
    gulp.task(_taskName('sass:dashboard:dev'), function(){ return runSass(sources.scss.dashboard); });
    gulp.task(_taskName('sass:dashboard:prod'), function(){ return runSass(sources.scss.dashboard, 'compressed'); });
    gulp.task(_taskName('sass:app:dev'), function(){ return runSass(sources.scss.app); });
    gulp.task(_taskName('sass:app:prod'), function(){ return runSass(sources.scss.app, 'compressed'); });
    gulp.task(_taskName('sass:ie8:dev'), function(){ return runSass(sources.scss.ie8); });
    gulp.task(_taskName('sass:ie8:prod'), function(){ return runSass(sources.scss.ie8, 'compressed'); });

    /** Run all dev tasks */
    gulp.task(_taskName('build:dev'), [
        _taskName('sass:dashboard:dev'),
        _taskName('sass:app:dev'),
        _taskName('sass:ie8:dev')
    ], function(){ utils.log(utils.colors.bgGreen('Dev build OK')); });

    /** Run all prod tasks */
    gulp.task(_taskName('build:prod'), [
        _taskName('sass:dashboard:prod'),
        _taskName('sass:app:prod'),
        _taskName('sass:ie8:prod')
    ], function(){ utils.log(utils.colors.bgGreen('Prod build OK')); });

    /** Watches */
    gulp.task(_taskName('watches'), function(){
        gulp.watch(_pathTo('css/src/clinica.app.scss'), {interval:1000}, [_taskName('sass:app:dev')]);
        gulp.watch(_pathTo('css/src/clinica.dashboard.scss'), {interval:1000}, [_taskName('sass:dashboard:dev')]);
        gulp.watch(_pathTo('css/src/ie8.scss'), {interval:1000}, [_taskName('sass:ie8:dev')]);
    });

};