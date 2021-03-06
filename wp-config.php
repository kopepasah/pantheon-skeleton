<?php
/**
 * This config file is yours to hack on. It will work out of the box on Pantheon
 * but you may find there are a lot of neat tricks to be used here.
 *
 * See our documentation for more details:
 *
 * https://pantheon.io/docs
 *
 * @package Pantheon Skeleton
 */

if ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) && ! isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) {
	/**
	 * Local configuration information.
	 *
	 * If you are working in a local/desktop development environment and want to
	 * keep your config separate, we recommend using a 'wp-config-local.php' file,
	 * which you should also make sure you .gitignore.
	 *
	 * IMPORTANT: ensure your local config does not include wp-settings.php.
	 */
	require_once( dirname( __FILE__ ) . '/wp-config-local.php' );

} else {
	/**
	 * Pantheon platform settings. Everything you need should already be set.
	 */

	if ( isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) {
		// ** MySQL settings - included in the Pantheon Environment ** //
		/** The name of the database for WordPress */
		define( 'DB_NAME', $_ENV['DB_NAME'] );

		/** MySQL database username */
		define( 'DB_USER', $_ENV['DB_USER'] );

		/** MySQL database password */
		define( 'DB_PASSWORD', $_ENV['DB_PASSWORD'] );

		/** MySQL hostname; on Pantheon this includes a specific port number. */
		define( 'DB_HOST', $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'] );

		/** Database Charset to use in creating database tables. */
		define( 'DB_CHARSET', 'utf8' );

		/** The Database Collate type. Don't change this if in doubt. */
		define( 'DB_COLLATE', '' );

		/**
		 * Authentication Unique Keys and Salts.
		 *
		 * Change these to different unique phrases!
		 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
		 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
		 *
		 * Pantheon sets these values for you also. If you want to shuffle them you
		 * can do so via your dashboard.
		 *
		 * @since 2.6.0
		 */
		define( 'AUTH_KEY', $_ENV['AUTH_KEY'] );
		define( 'SECURE_AUTH_KEY', $_ENV['SECURE_AUTH_KEY'] );
		define( 'LOGGED_IN_KEY', $_ENV['LOGGED_IN_KEY'] );
		define( 'NONCE_KEY', $_ENV['NONCE_KEY'] );
		define( 'AUTH_SALT', $_ENV['AUTH_SALT'] );
		define( 'SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT'] );
		define( 'LOGGED_IN_SALT', $_ENV['LOGGED_IN_SALT'] );
		define( 'NONCE_SALT', $_ENV['NONCE_SALT'] );

		// A couple extra tweaks to help things run well on Pantheon.
		if ( isset( $_SERVER['HTTP_HOST'] ) ) { // WPCS: input var okay.
			$is_ssl = ( isset( $_SERVER['HTTP_X_SSL'] ) && 'ON' === $_SERVER['HTTP_X_SSL'] ) || ( isset( $_SERVER['HTTP_USER_AGENT_HTTPS'] ) && 'ON' === $_SERVER['HTTP_USER_AGENT_HTTPS'] );
			$protocol = $is_ssl ? 'https://' : 'http://';
			define( 'WP_HOME', $protocol . $_SERVER['HTTP_HOST'] ); // WPCS: input var ok; sanitization ok.
			define( 'WP_SITEURL', $protocol . $_SERVER['HTTP_HOST'] ); // WPCS: input var ok; sanitization ok.
		}
		// Don't show deprecations; useful under PHP 5.5.
		error_reporting( E_ALL ^ E_DEPRECATED );

		// Force the use of a safe temp directory when in a container.
		if ( defined( 'PANTHEON_BINDING' ) ) {
			define( 'WP_TEMP_DIR', sprintf( '/srv/bindings/%s/tmp', PANTHEON_BINDING ) );
		}

		// FS writes aren't permitted in test or live, so we should let WordPress know to disable relevant UI.
		if ( in_array( $_ENV['PANTHEON_ENVIRONMENT'], array( 'test', 'live' ), true ) && ! defined( 'DISALLOW_FILE_MODS' ) ) {
			define( 'DISALLOW_FILE_MODS', true );
		}
	} else {
		/**
		 * This block will be executed if you have NO wp-config-local.php and you
		 * are NOT running on Pantheon. Insert alternate config here if necessary.
		 *
		 * If you are only running on Pantheon, you can ignore this block.
		 */
		define( 'DB_NAME', 'database_name' );
		define( 'DB_USER', 'database_username' );
		define( 'DB_PASSWORD', 'database_password' );
		define( 'DB_HOST', 'database_host' );
		define( 'DB_CHARSET', 'utf8' );
		define( 'DB_COLLATE', '' );
		define( 'AUTH_KEY', 'put your unique phrase here' );
		define( 'SECURE_AUTH_KEY', 'put your unique phrase here' );
		define( 'LOGGED_IN_KEY', 'put your unique phrase here' );
		define( 'NONCE_KEY', 'put your unique phrase here' );
		define( 'AUTH_SALT', 'put your unique phrase here' );
		define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
		define( 'LOGGED_IN_SALT', 'put your unique phrase here' );
		define( 'NONCE_SALT', 'put your unique phrase here' );
	}
}

/* Standard wp-config.php stuff from here on down. */

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
if ( ! defined( 'WPLANG' ) ) {
	define( 'WPLANG', '' );
}

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * You may want to examine $_ENV['PANTHEON_ENVIRONMENT'] to set this to be
 * "true" in dev, but false in test and live.
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/**
 * Disable file mods if SFTP is not enabled.
 */
if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
	define( 'DISALLOW_FILE_MODS', ! is_writable( __FILE__ ) );
}

/**
 * Jetpack debug mode in all environments other than production.
 */
if ( ! isset( $_ENV['PANTHEON_ENVIRONMENT'] ) || 'live' !== $_ENV['PANTHEON_ENVIRONMENT'] ) {
	define( 'JETPACK_DEV_DEBUG', true );
}

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
