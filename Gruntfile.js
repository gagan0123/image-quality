
module.exports = function ( grunt ) {

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		wp_readme_to_markdown: {
			dist: {
				options: {
					screenshot_url: '<%= pkg.repository.url %>/raw/master/assets/{screenshot}.png',
					post_convert: function ( file ) {
						var project_icon = "\n<img src='" + grunt.config.get( 'pkg' ).repository.url + "/raw/master/assets/icon-128x128.png' align='right' />\n\n";
						return project_icon + file;
					}
				},
				files: {
					'README.md': 'readme.txt'
				}
			}
		},
		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					exclude: [ 'node_modules/.*', 'tests/.*' ],
					mainFile: '<%= pkg.main %>',
					potFilename: '<%= pkg.name %>.pot',
					potHeaders: {
						poedit: false,
						'report-msgid-bugs-to': '<%= pkg.bugs.url %>'
					},
					type: 'wp-plugin',
					updateTimestamp: false
				}
			}
		}
	} );

	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );

	grunt.registerTask( 'default', [
		'watch'
	] );

};