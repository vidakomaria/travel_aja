<?php
define('WP_CACHE', false);
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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_transije');

/** MySQL database username */
define('DB_USER', 'transije_wp153');

/** MySQL database password */
define('DB_PASSWORD', '123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'jiqo7hnju2ofkbq26vpoqd2naj9muehzwk014249e80q7t9dy0nylphq9ywwzczz');
define('SECURE_AUTH_KEY',  'zv3ffyqdurhvqrukxo9ec15yo3gpmyd1y3hrkzqo0vnknoqprsdfboxrficu7f8m');
define('LOGGED_IN_KEY',    'ypk6wouws2jckjaoluek3meoio0elhjmo4dttsbml5xng8qn3q6dce5ay95h0cdb');
define('NONCE_KEY',        'halspq2fkyj4gsqdz3bfeqrehhp4mlejliokbvvqcl4t90ecich1xse6smhjgpsd');
define('AUTH_SALT',        'tvo7gcfbtq2n9loxicqcli343c5remlsdlkuskpe5yh29t6vlstjifljxrggwdl5');
define('SECURE_AUTH_SALT', 'vjd8pxpmrj3prqws1yjiclwjmscjaf8dqf4letow1zaxi06ocoyswzv23d3exq1g');
define('LOGGED_IN_SALT',   'gh8nbebnmq3hfi2aonzkco2xpsw4pfv7iu6ouvfrhfpdsxwamdu8uahbg2doyews');
define('NONCE_SALT',       'y3nehqkplbpqrzwi8ovltqrcjitsvjryswiwklizdshpaj4rm0g54k7p5uhljprw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpqt_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

/* Local development overrides. */
define( 'WP_HOME', 'http://127.0.0.1:8080' );
define( 'WP_SITEURL', 'http://127.0.0.1:8080' );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
define( 'DISABLE_WP_CRON', true );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
