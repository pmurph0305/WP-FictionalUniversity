<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
 * @since 2.6.0
 */
define('AUTH_KEY',         'xAfJYcuWcky/0mlQmbmL3n3J37lPYJWGQxuOsa+80nDt2rs/7kFA4RCklM0EJs1Sxvau2UiVck5XmDSNjYwjZg==');
define('SECURE_AUTH_KEY',  'iFvggpcRU+tqVX7qql6zsyhM2liQ0nLOaXA+VyA4elmM+H7CpZvBS+aqKKQ3DMIOlFH0MnmrgvkoVmjj9V7Lag==');
define('LOGGED_IN_KEY',    'Itc5++X5hf43hMoZmxb79RlOz4IWP4SQ0QB+NA5lEH0CTbaT2Ya38VNN3UsEiAKk23f9MyN3nCP31vUuT596eg==');
define('NONCE_KEY',        '0VZcMiMfgvxbdKvMCRlCpM1yyHlqRyoNg5aEPmFIPx5kQ3OM7C55lrV7CXw1LMMLjGwPES8HjZynnDOHiQgt1w==');
define('AUTH_SALT',        'p/RhgxRw2OSdVyD2hk+WEbP7DaJLFXp5QbCwHLXodvNwzyYOC/l8oDx+D6DvAoFN3mtwzMk+JwR4B3w2WI4ktw==');
define('SECURE_AUTH_SALT', 'AzhROXAT7Im6Om+X+7zEgcYj1wPTnSa/wcml5c97MW8V+hQ0jSRelyR7VmD78yZHSFknPb+ABSBZQDyQTPif+w==');
define('LOGGED_IN_SALT',   '6JV24mBdWI5WmuKdVXCkRc0g9+HXlmQHqWqkbljBamUw5saoxdfBeZ7OGEVYJRsnkIJfDxkM85/GyWBsLjJlPg==');
define('NONCE_SALT',       'hMEThthEajTjnXnHcPfd53e0itKCywULU7X3MtBj0gZmt5a5rRymZUlM+n/V7deVlIcovsyVvD4CpE/0245oXw==');
define('GOOGLE_API_KEY', 'AIzaSyCL8MwWZSfSg5yNqF4zGLaSXGrfCsxMCjc');
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
