<?php
/**
 * Trigger this file on Plugin uninstall
 *
 * @package           BtbForum
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Clear Database stored data
$forum_posts = get_posts( array('post_type' => 'forum_post', 'numberposts' => -1) );
foreach ($forum_posts as $forum_post) {
    wp_delete_post( $forum_post->ID, true );
}

remove_role('forum_member');
global $wpdb;
$wpdb->query("UPDATE {$wpdb->prefix}usermeta SET meta_value = 0 WHERE meta_key = 'wp_user_level' AND user_id IN (SELECT user_id FROM {$wpdb->prefix}usermeta WHERE meta_key = 'wp_capabilities' AND meta_value = 'a:1:{s:12:\"forum_member\";b:1;}')");
$wpdb->query("UPDATE {$wpdb->prefix}usermeta SET meta_value = 'a:1:{s:10:\"subscriber\";b:1;}' WHERE meta_key = 'wp_capabilities' AND meta_value = 'a:1:{s:12:\"forum_member\";b:1;}'");