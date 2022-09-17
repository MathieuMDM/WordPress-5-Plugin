<?php

class Cefii_Contact_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_options = array(
            'classname' => 'widget_cefiicontact',
            'discription' => 'Pour transmettre un numero de telephone'
        );
        parent::__construct('widget-cefiicontact', 'CEFii Contact', $widget_options);
    }
}