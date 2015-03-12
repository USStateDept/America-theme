module.exports = function(grunt) {
    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
          options: {
            sourceMap: true
          },
          dist: {
            files: {
              'style.css': 'style.scss'
            }
          }
        },

        cssc: {
          build: {
            options: {
              sortSelectors: false,
              sortDeclarations: false,
              sort: false,
              safe: true
            },
            // dest: src
            files: {
              'style.min.css': 'style.css'
            }
          }
        },

        uglify: {
          build: {
            files: {
              'js/main.min.js': ['js/file-ext.js', 'js/responsive-menu.js']
            }
          }
        },

        imagemin: {
          dynamic: {
            files: [{
              expand: true,
              cwd: 'images-src/',
              src: ['**/*.{png,jpg,gif}'],
              dest: 'images/'
            }]
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
        }
      });

    grunt.task.registerTask('default', [
      'sass',
      'optimages',
      'uglify',
      'cssc'
    ]);

    grunt.task.registerTask('optimages', [
      'imagemin',
      'svgmin',
      'compress'
    ]);

};
