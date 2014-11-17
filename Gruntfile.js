module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                sourceMap: true
            },
            js: {
                files: {
                    'media/js/dist/public.min.js': [
                        'bower_components/jquery/dist/jquery.min.js',
                        'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.js',
                        'bower_components/jquery-ui-touch-punch/jquery.ui.touch-punch.js',
                        'bower_components/jquery.cookie/jquery.cookie.js',
                        'media/js/*.js', 
                        'media/js/public/*.js', 
                        'media/js/public/**/*.js'
                    ],
                    'media/js/dist/app.min.js': [
                         'bower_components/jquery/dist/jquery.min.js',
                         'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.js',
                         'bower_components/jquery-ui/ui/core.js',
                         'bower_components/jquery-ui/ui/widget.js',
                         'bower_components/jquery-ui/ui/mouse.js',
                         'bower_components/jquery-ui-touch-punch/jquery.ui.touch-punch.js',
                         'bower_components/jquery.cookie/jquery.cookie.js',
                         'bower_components/chart.js/Chart.min.js',
                         'bower_components/typeahead.js/dist/typeahead.bundle.min.js',
                         'bower_components/moment/min/moment-with-locales.js',
                         'bower_components/jquery-ui/ui/draggable.js',
                         'media/js/*.js', 
                         'media/js/app/*.js', 
                         'media/js/app/**/*.js'
                    ]
                }
            }
        },
        compass: {
            dist: {
                options: {
                    sassDir: 'media/scss',
                    cssDir: 'media/css',
                    environment: 'production'
                },
                files: {
                    'media/css/app.css': 'media/scss/app.scss',
                    'media/css/public.css': 'media/scss/public.scss'
                }
            }
        },
        watch: {
            scripts: {
                files: ['**/*.js'],
                tasks: ['uglify'],
                options: {
                    spawn: false,
                }
            },
            css: {
                files: ['**/*.scss'],
                tasks: ['compass']
            }
        },
    });

    // Load plugins
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Default task(s).
    grunt.registerTask('default', [ 'uglify', 'compass' ]);

};