<?php
class Cefii_Contact_Plugin
{
    public function cefii_contact_front_head()
    {
        wp_enqueue_script('front-cefii-contact-js', plugins_url('js/front-cefii-contact.js', __FILE__), array('jquery'));
        wp_localize_script('front-cefii-contact-js', 'cefiicontact', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'action' => 'cefii_contact',
            'nonce' => wp_create_nonce('cefii_contact_nonce')
        ));
    }
    public function cefii_contact_front_ajax()
    {
        check_ajax_referer('cefii_contact_nonce', 'nonce');
        $insertion = $this->inserData($_POST['nom'], $_POST['tel']);
        if ($insertion) {
            $message = '<spam style="color:green;">Votre demande a bien ete envoyee.</spam>';
        } else {
            $message = '<spam style="color:red;">Une erreur est survenue, veuillez ressayer.</spam>';
        }
        echo json_encode($message);
        exit();
    }
    public function ajaxContact(nom, tel, $){
        $.ajax({
            type: "POST",
            url: cefiicontact.ajaxurl,
            dataType: "json",
            data: {
                action: cefiicontact.action,
                nonce: cefiicontact.nonce,
                nom: nom,
                tel: tel
            },
            success: function(message) {
                $("#messageWidgetCefiiContact").html(message);
                $("#cefii_contact_nom").val("");
                $("#cefii_contact_tel").val("");
            }
        });
    }
    public function cefii_contact_menu(){
        $pagePlugin = add_menu_page('Cefii Contact', 'Cefii Contact', 'administrator', 'Cefii_Contact.php', array($this, 'cefii_contact_admin'), 'dashicons-phone');
        add_action('admin_head-'.$pagePlugin,array($this, 'cefii_contact_admin_head'));
    }
    public function cefii_contact_admin_head(){
        wp_register_style('cefii_contact_admin_css', plugins_url('css/cefii-contact-admin.css', __FILE__));
        wp_enquene_style('cefii_contact_admin_css');
    }
}