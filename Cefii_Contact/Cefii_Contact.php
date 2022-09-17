<?php
/*
Plugin Name: Cefii Contact
Description: Widget permettant a un internaute de communiquer son telephone afin d'etre rappele
Version: 1.0
*/

class Cefii_Contact
{
    public function __construct()
    {
        include_once plugin_dir_path(__FILE__).'/Cefii_Contact_Plugin.php';
        add_action('widgets_init', function () {
            register_widget('Cefii_Contact_Widget');
        });
        $inst_contact = new Cefii_Contact_Plugin();
        include_once plugin_dir_path(__FILE__).'/Cefii_Contact_Widget.php';
        add_action('wp_head', array($inst_contact, 'cefii_contact_front_head'));
        if (isset($_POST['action'])) {
            add_action(
                'wp_ajax_nopriv_cefii_contact',
                array($inst_contact, 'cefii_contact_front_ajax')
            );
            add_action(
                'wp_ajax_cefii_contact',
                array($inst_contact, 'cefii_contact_front_ajax')
            );
        }
        add_action('admin_menu', array($inst_contact, 'cefii_contact_menu'));
    }
    public function cefii_contact_admin()
    {
        require_once('template-admin.php');
    }
}
new Cefii_Contact();