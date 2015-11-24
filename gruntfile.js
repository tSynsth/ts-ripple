/* jshint node:true */
module.exports = function( grunt ){
	'use strict';

	grunt.initConfig({

		// Setting folder templates
		dirs: {
			css: 'assets/css/',
			sass: 'assets/sass/',
			js: 'assets/js/'
		},
		// Compile all .sass files.
	    compass: {
		    dev: {
		        cwd: '<%= dirs.sass %>',
				src: [
					'*.scss'
				],
		        outputstyle: 'expanded',
		        dest: '<%= dirs.css %>',
		        linecomments: true
		      },
		    prod: {
		        cwd: '<%= dirs.sass %>',
				src: [
					'*.scss'
				],
		        outputstyle: 'compressed',
		        dest: '<%= dirs.css %>',
		        linecomments: false,
		        forcecompile: true
		    }
	    },
		// Minify all .css files.
		cssmin: {
			minify: {
				expand: true,
				cwd: '<%= dirs.css %>/',
				src: [
					'*.css',
					'!*.min.css'
				],
				dest: '<%= dirs.css %>/',
				ext: '.min.css'
			}
		},
		// Minify .js files.
		uglify: {
			options: {
				preserveComments: 'some'
			},
			jsfiles: {
				files: [{
					expand: true,
					cwd: '<%= dirs.js %>/',
					src: [
						'*.js',
						'!*.min.js',
						'!Gruntfile.js',
					],
					dest: '<%= dirs.js %>/',
					ext: '.min.js'
				}]
			}
		},
		jshint: {
	    	files: ['gruntfile.js', 'assets/js/frontend.js'],
		    options: {
			    globals: {
			    	jQuery: true
			    }
	    	}
	    },
		// Watch changes for assets
		watch: {
			compass: {
				files: [
					'<%= dirs.sass %>/*.scss'
				],
				tasks: ['compass:prod']
			},
			css: {
				files: [
					'<%= dirs.css %>/*.css',
					'!<%= dirs.css %>/*.min.css'
				],
				tasks: ['cssmin:minify']
			},
			js: {
				files: [
					'<%= dirs.js %>/*js',
					'!<%= dirs.js %>/*.min.js'
				],
				tasks: [
						'uglify',
						'jshint'
				]
			}
		}

	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-contrib-compass' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	// Register tasks
	grunt.registerTask( 'dev', [
		'jshint',
		'compass:dev',
		'uglify'
	]);
	grunt.registerTask( 'default', [
		'compass:prod',
		'cssmin',
		'uglify',
		'jshint'
	]);
	grunt.registerTask( 'prod', [
		'compass:prod',
		'cssmin',
		'uglify',
		'jshint'
	]);
	grunt.registerTask('build', [
	    'jshint',
	    'compass:prod',
	    'cssmin',
		'uglify',
  	]);
};