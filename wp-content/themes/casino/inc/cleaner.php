<?php

remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

remove_action( 'wp_head', 'wp_shortlink_wp_head' ); // removes shortlink.
remove_action( 'wp_head', 'feed_links', 2 ); // removes feed links.
remove_action( 'wp_head', 'feed_links_extra', 3 );  // removes comments feed.
remove_action( 'wp_head', 'profile_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_resource_hints', 2 );

/**
 * WordPress REST
 */
