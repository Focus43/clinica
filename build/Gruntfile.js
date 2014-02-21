/*global module:false*/
module.exports = function(grunt) {

    var _initConfigs = {
        pkg: grunt.file.readJSON('package.json'),
        banner: '/*! <%= pkg.project %> - Deploy v: <%= pkg.version %>; Author: <%= pkg.author.name %> (<%= pkg.author.url %>) */\n',
        filename: '<%= pkg.name %>',
        concat: {},
        strip: {},
        uglify: {},
        jshint: {},
        sass: {},
        watch: {}
    }

    // These plugins provide necessary tasks.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-strip');
    grunt.loadNpmTasks('grunt-newer');
    grunt.loadNpmTasks('grunt-bump');

    // Miss Greek build settings
    require('../web/packages/miss_greek/grunt_settings.js').extraConfigs(grunt, _initConfigs);

    // Project configuration.
    grunt.initConfig(_initConfigs);

    // Default task.
    grunt.registerTask('default', []);

};