<?php
/*
Plugin Name: CEFii YouTube
Plugin URI: https://www.cefii.fr
Description: widget permettant l'affichage d'une vidéo YouTube
Author: Mathieu Pawlicha
Version: 1.0
*/

class CefiiYouTube extends WP_Widget
{
    public function __construct()
    {
        $widget_options = array(
            'classname' => 'widget_cefiiyoutube',
            'description' => "Widget permettant l'affichage d'une vidéo YouTube",
//             Konfiguracja widżetu odbywa się zatem poprzez wywołanie konstruktora klasy nadrzędnej, który może przyjąć do 4 argumentów:
// identyfikator, który będzie rozpoznawany w ramach WP
// nazwa, która będzie wyświetlana w Wygląd > Widgety
// szereg opcji, takich jak nazwa klasy dla interfejsu, opis w zapleczu itp.
// tabela z opcjami konfiguracyjnymi, takimi jak np. szerokość formularza.
        );
        parent::__construct('widget-cefiiyoutube', 'CEFii YouTube', $widget_options);
    }
    public function form($instance)
    {
        $defaults = array(
            'title' => "Video CEFii YouTube",
            'idVideo' => ''
        );
        // ^^^^ W tym celu tworzymy tablicę, którą dodajemy do zmiennej $instance za pomocą metody wp_parse_args()  ,  która umożliwia przypisanie wartości, jeśli są puste.
        $instance=wp_parse_args($instance, $defaults); ?>
<p>
    <label for="">Titre:</label>
    <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>"
        name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('idVideo'); ?>">Identifiant
        de la vidéo youTube:</label>
    <input class="widefat" type="text" id="<?php echo $this->get_field_id('idVideo'); ?>"
        name="<?php echo $this->get_field_name('idVideo'); ?>" value="<?php echo $instance['idVideo']?>" />
</p>
<!-- ^^^^ Następnie „wypełnimy” różne atrybuty pozostawione puste w tej funkcji. 
Tutaj użyjemy 2 metod WP: get_field_id() i get_field_name() , które pozwalają na wygenerowanie identyfikatora i nazwy , ale także na pobranie ich wartości.  -->
<?php
    }

    public function update($new_instance, $old_instance)
    {
        // Aby WP mógł zapisać wartości, musimy zmodyfikować metodę update() , aby zapisać nowe wartości. Do zabezpieczenia pól używamy funkcji strip_tags() :
        $instance = $old_instance;
        $instance['title']=strip_tags($new_instance['title']);
        $instance['idVideo']=strip_tags($new_instance['idVideo']);
        return $instance;
    }

    public function widget($args, $instance)
    {
        extract($args);
        echo $before_widget;
        echo $before_title.$instance['title'].$after_title;
        if ($instance['idVideo']!="") {
            ?>
<iframe src="https://www.youtube.com/embed/<?php echo $instance['idVideo']; ?>" allowfullscreen></iframe>
<?php
        }
        echo $after_widget;
    }
}


function register_cefii_youtube()
{
    register_widget('CefiiYouTube');
}

add_action('widgets_init', 'register_cefii_youtube');