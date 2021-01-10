/**
 * Laravel Mix configuration file.
 *
 * "Laravel Mix Mix is a thin layer on top of webpack for the rest of us.
 * It exposes a simple, fluent API for dynamically constructing your webpack configuration."
 *
 * @see https://laravel-mix.com/
 */

const mix = require( 'laravel-mix' );

/*
 * -----------------------------------------------------------------------------
 * Build process
 * -----------------------------------------------------------------------------
 * The section below handles processing, compiling, transpiling, and combining
 * all of the framework's assets into their final location.
 * -----------------------------------------------------------------------------
 */

/*
 * Sets the development path to assets.
 */
const devPath  = 'resources';

/*
 * Sets the path to the generated assets.
 */
mix.setPublicPath( 'dist' );

/*
 * Set options.
 */
mix.options( {
	postCss        : [ require( 'postcss-preset-env' )() ],
	processCssUrls : false
} );

/*
 * Compile CSS.
 */

// Sass configuration.
var sassConfig = {
	sassOptions: {
		outputStyle: 'expanded',
		indentType  : 'tab',
		indentWidth : 4
    }
};

mix.sass( `${devPath}/scss/admin.scss`, 'css', sassConfig );
