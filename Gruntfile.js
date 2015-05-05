module.exports = function(grunt) {

    require('time-grunt')(grunt);

    // Special block that makes watch work with just the changed js files...

    var pkg = grunt.file.readJSON('package.json');

    var srcFiles = pkg.srcFiles;
    var changedFiles = Object.create(null);
    var onChange = grunt.util._.debounce(function() {

      // Modified to point to jshint.files as per the task example in the question.
      grunt.config('jshint.files', Object.keys(changedFiles));
      changedFiles = Object.create(null);
    }, 200);

    grunt.event.on('watch', function(action, filepath) {

        var parts = filepath.split('.');
        var ext = parts.pop();
        if( ext !== 'js' ) {
            return false;
        }
        changedFiles[filepath] = action;
        onChange();
    });

    // end of special block that makes watch work with just the changed js files...


    /**
     * Start of main GRUNT configuration
     */
    grunt.initConfig({


        // populate pkg var with data from package.json
        pkg: grunt.file.readJSON('package.json'),


        /**
         * WATCH will monitor for file changes and redo associated tasks when they are detected.
         */
        watch: {
            liveReload: {
              files: srcFiles,
              options: {
                livereload: true,
                nospawn: true
              }
            },

            /** Watch Sections' build.less files */
            lessSections: {
                files: [ 'sections/*/build.less' ], // files to watch
                tasks: [ 'less:compileSections' ],  // what to do on change
                options: { nospawn: true }          // No child process - 500ms faster
            },
            lessMain: {
                // what files/folder we watching?
                files: [ 'style.less' ],
                // tasks to run in order when something changes
                tasks: ['less:compileMain'],
                options: {
                    nospawn: true,
                }
            }
          },


	    // Less compiler options

	    less: {

			compileMain: {
	            src: 'build.less',
              dest: 'build.css',
                options: {
                    strictMath: true,
                    sourceMap: false                }
	        },
      compileSections: {
                src:    'sections/*/build.less', //'sections/*/build.less',
                dest:   '',
                expand: true,
                rename: function(dest, src) {
                    return src.replace("build.less", "build.css");
                },

            }
	    },

    concurrent: {
        all: {
          //  tasks: ['watch:js', 'watch:less', 'watch:php'],
            tasks: [ 'watch:lessMain', 'watch:lessSections'],
            options: {
                logConcurrentOutput: true
            }
        }
    },

    cssmin: {
      options: {
        shorthandCompacting: false,
        roundingPrecision: -1
      },
      main: {
        src: 'build.css',
        dest: 'build.css'
      }
    }

    }
    );


    /**
     * Load the GRUNT modules we are using
     */
     require('load-grunt-tasks')(grunt);

   /**
    * Register the GRUNT tasks along with the times they will be activated.
    */

    /** Run on GRUNT initialization */
    grunt.registerTask( 'default', 	[ 'less', 'cssmin', 'concurrent' ] );

    grunt.registerTask( 'css', 	[ 'less', 'cssmin' ] );

    /** TODO: document  */
    grunt.registerTask( 'debug', 	[ 'less' ] );
}
