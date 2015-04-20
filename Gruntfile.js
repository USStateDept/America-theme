module.exports = function(grunt) {
    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
          dist: {
            options: {
              style: 'compressed'
            },
            files: {
              'style.css': 'style.scss',
              'disinfo/style.css': 'disinfo/style.scss',
              'climate/style.css': 'climate/style.scss'
            },
          }
        },

        uglify: {
          build: {
            files: {
              'js/main.min.js': ['js/modernizr.min.js', 'js/file-ext.js', 'js/responsive-menu.js', 'js/play-button.js'],
              'js/lte-ie8.min.js': ['js/html5shiv.min.js', 'js/respond.min.js'],
              'js/analytics-events.min.js': ['js/analytics-social-events.js', 'js/analytics-video-events.js']
            }
          }
        },

        imagemin: {
          dynamic: {
            files: [
              {
                expand: true,
                cwd: 'images-src/',
                src: ['**/*.{png,jpg,gif}'],
                dest: 'images/'
              },
              {
                expand: true,
                cwd: 'disinfo/images-src/',
                src: ['**/*.{png,jpg,gif}'],
                dest: 'disinfo/images/'
              },
              {
                expand: true,
                cwd: 'climate/images-src/',
                src: ['**/*.{png,jpg,gif}'],
                dest: 'climate/images/'
              }
            ]
          }
        },

        // Requires SVGO
        svgmin: {
          options: {
            plugins: [
              { collapseGroups: false }
            ]
          },
          dist: {
            files: [{
              expand: true,
              cwd: 'images-src',
              src: ['*.svg'],
              dest: 'images',
              ext: '.min.svg'
            }]
          }
        },

        // Requires gzip
        compress: {
          main: {
            options: {
              mode: 'gzip'
            },
            files: [
              {expand: true,
               cwd: 'images',
               src: ['*.svg'],
               dest: 'images',
               ext: '.svgz'}
            ]
          }
        },
        watch: {
          css: {
            files: '**/*.scss',
            tasks: ['sass']
          }
        }
      });

    grunt.task.registerTask('default', [
      'sass',
      'optimages',
      'uglify',
    ]);

    grunt.task.registerTask('optimages', [
      'imagemin',
      'svgmin',
      'compress'
    ]);
};
