<?php

/*
Plugin Name: CEFii Copyright
Plugin URI: https://www.cefii.fr
Description: Mon premier plugin !
Author: Mathieu Pawlicha
Version: 0.1
Licence: GPL2
*/


function copyright()
{
    echo "<p>Copyright ajoute!</p>";
}

add_action('wp_footer', 'copyright');

// Stworzenie funkcji wyświetlającej tekst w akapicie.
// Prosimy WordPressa o wykonanie tej funkcji (drugi parametr) podczas akcji „ wp_footer”  (pierwszy parametr).