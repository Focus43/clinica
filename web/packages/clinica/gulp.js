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
        }
        //sources = {
        //    scss: {
        //        core: _pathTo('css/src/core.scss'),
        //        app: _pathTo('css/src/app.scss')
        //    },
        //    js: {
        //        core: [
        //            _pathTo('bower_components/fastclick/lib/fastclick.js'),
        //            _pathTo('bower_components/angular/angular.js'),
        //            _pathTo('bower_components/angular-sanitize/angular-sanitize.js'),
        //            _pathTo('bower_components/gsap/src/uncompressed/TweenMax.js'),
        //            _pathTo('bower_components/gsap/src/uncompressed/plugins/ScrollToPlugin.js'),
        //            _pathTo('bower_components/imagesloaded/imagesloaded.pkgd.js'),
        //            _pathTo('bower_components/masonry/dist/masonry.pkgd.js'),
        //            _pathTo('bower_components/svg.js/dist/svg.min.js'),
        //            _pathTo('bower_components/moment/moment.js'),
        //            _pathTo('js/3rd_party/*.js')
        //        ],
        //        app: [
        //            _pathTo('js/src/**/*.js')
        //        ]
        //    }
        //};

    /**
     * Sass compilation
     * @param _style
     * @returns {*|pipe|pipe}
     */
    function runSass( files, _style ){ utils.log("runSass" )
        return gulp.src(files)
            .pipe(sass({compass:true, style:(_style || 'nested')}))
            .on('error', function( err ){
                utils.log(utils.colors.red(err.toString()));
                this.emit('end');
            })
            .pipe(gulp.dest(_pathTo('css/')));
    }

    /**
     * Javascript builds (concat, optionally minify)
     * @param files
     * @param fileName
     * @param minify
     * @returns {*|pipe|pipe}
     */
    //function runJs( files, fileName, minify ){
    //    return gulp.src(files)
    //        .pipe(concat(fileName))
    //        .pipe(minify === true ? uglify() : utils.noop())
    //        .pipe(gulp.dest(_pathTo('js/')));
    //}

    /**
     * Run JSHint
     * @param files
     * @returns {*|pipe|pipe}
     */
    //function runJsHint( files ){
    //    return gulp.src(files)
    //        .pipe(jshint(_pathTo('.jshintrc')))
    //        .pipe(jshint.reporter('jshint-stylish'));
    //}

    /** Register individual tasks */
    //gulp.task(_taskName('jshint'), function(){ return runJsHint(sources.js.app); });
    gulp.task(_taskName('sass:dashboard:dev'), function(){ return runSass(sources.scss.dashboard); });
    gulp.task(_taskName('sass:dashboard:prod'), function(){ return runSass(sources.scss.dashboard, 'compressed'); });
    gulp.task(_taskName('sass:app:dev'), function(){ return runSass(sources.scss.app); });
    gulp.task(_taskName('sass:app:prod'), function(){ return runSass(sources.scss.app, 'compressed'); });
    gulp.task(_taskName('sass:ie8:dev'), function(){ return runSass(sources.scss.ie8); });
    gulp.task(_taskName('sass:ie8:prod'), function(){ return runSass(sources.scss.ie8, 'compressed'); });
    //gulp.task(_taskName('js:core:dev'), function(){ return runJs(sources.js.core, 'core.js', false) });
    //gulp.task(_taskName('js:core:prod'), function(){ return runJs(sources.js.core, 'core.js', true) });
    //gulp.task(_taskName('js:app:dev'), [_taskName('jshint')], function(){ return runJs(sources.js.app, 'app.js', false) });
    //gulp.task(_taskName('js:app:prod'), [_taskName('jshint')], function(){ return runJs(sources.js.app, 'app.js', true) });

    /** Run all dev tasks */
    gulp.task(_taskName('build:dev'), [
        _taskName('sass:dashboard:dev'),
        _taskName('sass:app:dev'),
        _taskName('sass:ie8:dev'),
        //_taskName('js:core:dev'),
        //_taskName('js:app:dev')
    ], function(){ utils.log(utils.colors.bgGreen('Dev build OK')); });

    /** Run all prod tasks */
    gulp.task(_taskName('build:prod'), [
        _taskName('sass:dashboard:prod'),
        _taskName('sass:app:prod'),
        _taskName('sass:ie8:prod'),
        //_taskName('js:core:prod'),
        //_taskName('js:app:prod')
    ], function(){ utils.log(utils.colors.bgGreen('Prod build OK')); });

    /** Watches */
    gulp.task(_taskName('watches'), function(){
        gulp.watch(_pathTo('css/src/clinica.app.scss'), {interval:1000}, [_taskName('sass:app:dev')]);
        gulp.watch(_pathTo('css/src/clinica.dashboard.scss'), {interval:1000}, [_taskName('sass:dashboard:dev')]);
        gulp.watch(_pathTo('css/src/ie8.scss'), {interval:1000}, [_taskName('sass:ie8:dev')]);
        //gulp.watch(_pathTo('js/src/**/*.js'), {interval:1000}, [_taskName('js:app:dev')]);
    });

};