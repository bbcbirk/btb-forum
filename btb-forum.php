<?php
/**
 * BTB Forum
 *
 * @package           BtbForum
 * @author            Birk Thestrup Blauner
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       BTB Forum
 * Description:       Add new user role, which can access private pages. Also add a Forum post type, where users can create new posts.
 * Version:           beta
 * Author:            Birk Thestrup Blauner
 * Text Domain:       btb-forum
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


defined('ABSPATH') or die('Nothing to do here...');

class BtbForum {

    function __construct() {
        add_action( 'init', array($this, 'add_forum_member_role') );
        add_action( 'init', array($this, 'custom_post_type') );
    }

    function activate() {
        $this->add_forum_member_role();
        $this->custom_post_type();
        //generate a plugin page with fields
        flush_rewrite_rules();
    }

    function deactivate() {

        remove_role('forum_member');
        flush_rewrite_rules();

    }

    function add_forum_member_role() {
        add_role( 
            'forum_member',
            __('Forum Member', 'btb-forum'),
            array(
                'delete_posts'          => true,
                'edit_posts'            => true,
                'read'                  => true,
                'read_private_pages'    => true,
                'read_private_posts'    => true,
            ), 
        );
    }

    function custom_post_type() {
        register_post_type('book', ['public' => true, 'label' => 'books']);
    }
}

if (class_exists('BtbForum')) {
    $btbForum = new BtbForum();
}

// Activation
register_activation_hook( __FILE__, array($btbForum, 'activate') );

// Deactivation
register_deactivation_hook( __FILE__, array($btbForum, 'deactivate') );