<?php
define( 'WP_CACHE', true );



 // Added by WP Rocket

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "krikate" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "root" );

/** Database hostname */
define( 'DB_HOST', "127.0.0.1" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'AL?8^c[tVuOU.Y/1<t_(l{|d |yxxtTVB?_Mlsox%%X]BV5:ZxOW(28f,H[,=1.c' );
define( 'SECURE_AUTH_KEY',  'u2O4p,^U18+f2x^p/-?tej}85B|dDXf&trpuRu*wAYno?4O%cRj.hzEEpEJ%Ojbz' );
define( 'LOGGED_IN_KEY',    ')Eu2s7MSpn9;W^v;U9+IdSos6:x{*?G.i;S|9cNiuvI3$Qg8bbB|%|a$k)!VZV]_' );
define( 'NONCE_KEY',        'yX{6 b(ov;egUakS7zKlKZ] .KA<O,n>TKdyvu#/bLD!1NNHch3!jfBoy=Ri3/e&' );
define( 'AUTH_SALT',        'J@ahpBmZ.^%Y4sodQ_G!gu@PX.]%sy.%,[1[@0,G@2F=rG<P-fDZpV@X &C%Qp10' );
define( 'SECURE_AUTH_SALT', 'f%QI_p6<%ucV^Zl:p=8b,^V7Td))A!#r!5AkePPr(:.B_`&BWINqHGxLim&pA$Be' );
define( 'LOGGED_IN_SALT',   'e[g4mF}ffNta@TF(CgF!CL/Bs4@J]vI<3v)gmW]svuJTMI*U>TLhoC~2.A[o2ur8' );
define( 'NONCE_SALT',       '^uYqh4UZA{Mt@dpr!j$F%@n%_@5fPmt,|gi{A >d*wKc;XSa_D!P]oSV,r8a{v0 ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'krikate_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
