module.exports = function ( grunt ) {

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		wp_readme_to_markdown: {
			dist: {
				files: {
					'README.md': 'readme.txt'
				}
			}
		},
		makepot: {
			target: {
				options: {
					domainPath: 'languages',
					exclude: [ 'node_modules/.*', 'tests/.*' ],
					mainFile: 'image-quality.php',
					potFilename: 'image-quality.pot',
					potHeaders: {
						poedit: false
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
		'wp_readme_to_markdown', 'makepot'
	] );

};