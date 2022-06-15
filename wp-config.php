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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp' );

/** MySQL database username */
define( 'DB_USER', 'wp' );

/** MySQL database password */
define( 'DB_PASSWORD', 'pass' );

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
define( 'AUTH_KEY',          'd]r|.$sz[WxI7O(z[*Y`>B=,a(X0@]|oXnV`Y@EF?6HHNIgn#w[?7OiE,.-@iyNp' );
define( 'SECURE_AUTH_KEY',   '~]Ik0f`lB[lEI%mryi# (&On!S?Xfj2GGw={9EMCWR8J4%b@CWDm*t[&&pSU~^=k' );
define( 'LOGGED_IN_KEY',     '*r;J5`+f+@bBd@,`:@-I;v9be>#8)Q/WG91?R7tdrS%SDy6,,{hOUPe,llgUn0u!' );
define( 'NONCE_KEY',         '9f#sWZNB`=uw[M_.|uC1/O/hZ2e8FOiA{=!/K*B3nHw0~{tjCsC.>>IGf58F{C,4' );
define( 'AUTH_SALT',         '9M#iZ}G0TLPO6!y-E<` z5H6W8oz#/~M;( xFJC+r@&/2o4xDtIsK9ns}1#Z`2_g' );
define( 'SECURE_AUTH_SALT',  '&9a-II}&!<;sOnxXP38otB5y3otH5in*>Pyc39$[hqV2[IxX#^yjY~{VOIlC>Lg7' );
define( 'LOGGED_IN_SALT',    'BNL=BcX.M|+Jw1R.C-*vle)<<MwX9o,uf{> yii0}kQ4R%o`[0x(|U{eli~q| U`' );
define( 'NONCE_SALT',        'JUM2MFPm4Z-t<ayhY=0TvJQs3VK4{BVh1`E&Ry}f>0/zvL6cO%WvPi+:MX)q*get' );
define( 'WP_CACHE_KEY_SALT', 'YvJN+a<<!Zi2-:E]u,3{@ZOrk3]hVw1yBHCR%IX;Ws$QGIZ>yZ=)e5pM|Tzgm7o_' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


$_SERVER[ "HTTPS" ] = "on";
define( 'WP_HOME', 'https://GwnMees-Website.Meesmeesie.repl.co' );
define( 'WP_SITEURL', 'https://GwnMees-Website.Meesmeesie.repl.co' );
define ('FS_METHOD', 'direct');
define('FORCE_SSL_ADMIN', true);


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
