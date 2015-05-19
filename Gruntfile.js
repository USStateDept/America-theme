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
              'sites/misinfo/style.css': 'sites/misinfo/style.scss',
              'sites/climate/style.css': 'sites/climate/style.scss',
              'sites/publications/style.css': 'sites/publications/style.scss',
              'sites/docs/style.css': 'sites/docs/style.scss'
            },
          }
        },

        uglify: {
          build: {
            files: {
              'js/dist/main.min.js': ['js/src/vendor/modernizr.min.js', 'js/src/file-ext.js', 'js/src/video-watermark.js', 'js/src/sharelines.js', 'js/src/plugins/responsive-menu.js'],
              'js/dist/lte-ie8.min.js': ['js/src/vendor/html5shiv.min.js', 'js/src/vendor/respond.min.js'],
              'js/dist/analytics-events.min.js': ['js/src/analytics/analytics-social-events.js', 'js/src/analytics/analytics-video-events.js'],
              'sites/misinfo/js/dist/script.js': ['sites/misinfo/js/src/init.js'],
              'sites/climate/js/dist/script.js': ['sites/climate/js/src/init.js'],
              'sites/publications/js/dist/script.js': ['sites/publications/js/src/init.js'],
              'sites/docs/js/dist/script.js': ['sites/docs/js/src/prism.js']
            }
          }
        },

        imagemin: {
          dynamic: {
            files: [
              {
                expand: true,
                cwd: 'images/src/',
                src: ['**/*.{png,jpg,gif}'],
                dest: 'images/dist/'
              },
              {
                expand: true,
                cwd: 'sites/misinfo/images/src/',
                src: ['**/*.{png,jpg,gif}'],
                dest: 'sites/misinfo/images/dist/'
              },
              {
                expand: true,
                cwd: 'sites/climate/images/src/',
                src: ['**/*.{png,jpg,gif}'],
                dest: 'sites/climate/images/dist/'
              },
              {
                expand: true,
                cwd: 'sites/publications/images/src/',
                src: ['**/*.{png,jpg,gif}'],
                dest: 'sites/publications/images/dist/'
              },
              {
                expand: true,
                cwd: 'sites/docs/images/src/',
                src: ['**/*.{png,jpg,gif}'],
                dest: 'sites/docs/images/dist/'
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
            files: [
              {expand: true,
              cwd: 'images/src',
              src: ['*.svg'],
              dest: 'images/dist',
              ext: '.min.svg'},

              {expand: true,
              cwd: 'sites/publications/images/src',
              src: ['*.svg'],
              dest: 'sites/publications/images/dist',
              ext: '.min.svg'},

              {expand: true,
              cwd: 'sites/misinfo/images/src',
              src: ['*.svg'],
              dest: 'sites/misinfo/images/dist',
              ext: '.min.svg'},

              {expand: true,
              cwd: 'sites/climate/images/src',
              src: ['*.svg'],
              dest: 'sites/climate/images/dist',
              ext: '.min.svg'}
            ]
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
               cwd: 'images/dist',
               src: ['*.svg'],
               dest: 'images/dist',
               ext: '.svgz'},

              {expand: true,
               cwd: 'sites/publications/images/dist',
               src: ['*.svg'],
               dest: 'sites/publications/images/dist',
               ext: '.svgz'},

               {expand: true,
                cwd: 'sites/misinfo/images/dist',
                src: ['*.svg'],
                dest: 'sites/misinfo/images/dist',
                ext: '.svgz'},

                {expand: true,
                 cwd: 'sites/climate/images/dist',
                 src: ['*.svg'],
                 dest: 'sites/climate/images/dist',
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
