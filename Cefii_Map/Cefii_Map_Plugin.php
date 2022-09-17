<?php
class Cefii_Map_Plugin
{
    public function cefii_map_install()
    {
        global $wpdb;
        $table_site = $wpdb->prefix . 'cefiimap';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_site'") != $table_site) {
            $sql = "CREATE TABLE `$table_site`(`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `titre` TEXT NOT NULL, `longitude` TEXT NOT NULL, `latitude` TEXT NOT NULL)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
    public function init()
    {
        if (function_exists('add_options_page')) {
            $mapage = add_options_page(
                'CEFii Map',
                'CEFii Map',
                'administrator',
                dirname(__FILE__),
                array($this, 'cefii_map_admin_page')
            );
            add_action('load-'. $mapage, array($this, 'cefii_map_admin_header'));
        }
    }
    public function cefii_map_admin_page()
    {
        if (isset($_GET['p']) && $_GET['p'] == 'map') {
            require_once('template-map.php');
        } else {
            require_once('template-admin.php');
        }

        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'createmap') {
                if ((trim($_POST['Cm-title']) != '') && (trim($_POST['Cm-latitude']) != '') && (trim($_POST['Cm-longitude']) != '')) {
                    $insertmap = $this->insertmap($_POST['Cm-title'], $_POST['Cm-latitude'], $_POST['Cm-longitude']);
                    if ($insertmap) {
                        ?>
<script>
<?php
                                $location = get_bloginfo('url') . '/wp-admin/options-general.php?page=Cefii_Map&map=ok'; ?>
window.location = "<?php echo $location; ?>";
</script>
<?php
                    } else {
                        echo '<p class="erreur">Une erreur est survenue.</p>';
                    }
                } else {
                    echo '<p class="erreur">Veuillez remplir tous les champs !</p>';
                }
            } elseif ($_GET['action'] == 'updatemap') {
                if ((trim($_POST['Cm-id']) != '') && (trim($_POST['Cm-title']) != '') && (trim($_POST['Cm-latitude']) != '') && (trim($_POST['Cm-longitude']) != '')) {
                    $updateMap = $this->updateMap($_POST['Cm-id'], $_POST['Cm-title'], $_POST['Cm-latitude'], $_POST['Cm-longitude']);
                    if ($updateMap) {
                        var_dump($_POST);
                    } else {
                        echo '<p class="erreur">Une erreur est survenue.</p>';
                    }
                } else {
                    echo '<p class="erreur">Veuillez remplir tous les champs !</p>';
                }
            }
            var_dump($_POST);
            if (isset($_GET['map'])) {
                if (isset($_GET['map']) == 'ok') {
                    echo '<p class="succes">la carte a été bien mis à jour.</p>';
                }
            } elseif ($_GET['action'] == 'deletemap') {
                if ((trim($_POST['Cm-id']) != '')) {
                    $deleteMap = $this->deleteMap($_POST['Cm-id']);
                    if ($deleteMap) {
                        ?>
<script>
<?php
                                $location = get_bloginfo('url') . '/wp-admin/options-general.php?page=Cefii_Map&map=ok'; ?>
window.location = "<?php echo $location; ?>";
</script>
<?php
                    } else {
                        echo '<p class="erreur">Une erreur est survenue.</p>';
                    }
                } else {
                    echo '<p class="erreur">Veuillez remplir tous les champs !</p>';
                }
            }
            var_dump($_POST);
            if (isset($_GET['map'])) {
                if (isset($_GET['map']) == 'ok') {
                    echo '<p class="succes">la carte a été bien mis à jour.</p>';
                }
            }
        }
    }
    public function cefii_map_admin_header()
    {
        wp_register_style('cefii_map_css', plugins_url('css/admin-cefii-map.css', __FILE__));
        wp_enqueue_style('cefii_map_css');
        wp_enqueue_script('cefii_map_js', plugins_url('js/admin-cefii-map.js', __FILE__), array('jquery'));
        wp_enqueue_script('google_map_js', 'https://maps.googleapis.com/maps/api/js?key=' . get_option('cleApi'));
        wp_localize_script('cefii_map_js', 'textJs', array( 'confirmation' => __('Do you want to delete this map?', 'cefii-map'),
        ));
    }
    public function cefii_map_front_header()
    {
        wp_enqueue_script('google_map_js', 'https://maps.googleapis.com/maps/api/js?key=' . get_option('cleApi'));
    }
    public function insertmap($title, $lat, $long)
    {
        global $wpdb;
        $table_map = $wpdb->prefix . 'cefiimap';
        $sql = $wpdb->prepare(
            "INSERT INTO " . $table_map . "(titre, longitude, latitude) VALUES (%s,%s,%s)",
            $title,
            $lat,
            $long
        );
        $req = $wpdb->query($sql);
        return $req;
    }
    public function updateMap($id, $title, $lat, $long)
    {
        global $wpdb;
        $table_map = $wpdb->prefix . 'cefiimap';
        $sql = $wpdb->prepare(
            "UPDATE " . $table_map . " SET titre=%s, longitude=%s, latitude=%s WHERE id=%d",
            $id,
            $title,
            $lat,
            $long
        );
        $req = $wpdb->query($sql);
        return $req;
    }
    public function deleteMap($id)
    {
        global $wpdb;
        $table_map = $wpdb->prefix . 'cefiimap';
        $sql = $wpdb->prepare(
            "DELETE FROM " . $table_map . " WHERE (id=%s)",
            $id
        );
        $req = $wpdb->query($sql);
        return $req;
    }
    public function getmaplist()
    {
        global $wpdb;
        $table_map = $wpdb->prefix . 'cefiimap';
        $sql = "SELECT * FROM " . $table_map;
        $maplist = $wpdb->get_results($sql);
        return $maplist;
    }
    public function getmap($id)
    {
        global $wpdb;
        $table_map = $wpdb->prefix . 'cefiimap';
        $sql = $wpdb->prepare("SELECT * FROM " . $table_map . " WHERE id=%d LIMIT 1", $id);
        $map = $wpdb->get_results($sql);
        return $map;
    }
    public function champ_cleApi()
    {
        ?>
<input type="text" name="cleApi" id="cleApi" value="<?php echo get_option('cleApi'); ?>" size="50" />
<?php
    }
    public function cefiiMap_options()
    {
        add_settings_section("cefiiMap-section", '', null, "Cefii_Map");
        add_settings_field("cleApi", "Votre cle API", array($this, 'champ_cleApi'), "Cefii_Map", "cefiiMap-section");
        register_setting("cefiiMap-section", "cleApi");
    }
    public function cefii_map_shortcode($att)
    {
        $map=$this->getmap($att['id']);
        ob_start(); ?>
<div id="map<?php echo $map[0]->id; ?>" style="width:400px;height:400px;" </div>
    <script>
    var coord = new google.maps
        .LatLng(<?php echo $map[0]->latitude; ?>, <?php echo $map[0]->longitude; ?>);
    var options = {
        center: coord,
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = google.maps.Map(document.getElementById(
        "map<?php echo $map[0]->id; ?>"), options);
    </script>
    <?php return ob_get_clean();
    }
    
    public function cefii_map_load_textdomain()
    {
        load_plugin_textdomain('cefii-map', false, dirname(plugin_basename(__FILE__)) . '/languares/');
    }
}

    // Ta klasa będzie zawierać dużą liczbę metod i utworzymy jej nową instancję w warunku, który pozwoli nam sprawdzić,czy
    // ta klasa istnieje.
    // if (class_exists('Cefii_Map')) {
    //     $inst_map = new Cefii_Map();
    // }

    // $wpdb->prefiks , aby pobrać prefiks tabeli;
    // $wpdb->get_var() , aby sprawdzić, czy tabela o tej samej nazwie nie istnieje.
    // Wykorzystamy również funkcję dbdelta() , która pozwala tworzyć i aktualizować tabele w WP.

    // if (isset($inst_map)) {
    //     register_activation_hook(__FILE__, array($inst_map, 'cefii_map_install'));
    //     add_action('admin_menu', array($inst_map, 'init'));
    //     add_action('admin_init', array($inst_map, 'cefiiMap_options'));
    //     add_action('wp_enqueue_scripts', array($inst_map, 'cefii_map_front_header'));
    //     add_action('plugins_loaded', array($inst_map, 'cefii_map_load_textdomain'));
    // }

    // if (function_exists('add_shortcode')) {
    //     add_shortcode('cefiimap', array($inst_map, 'cefii_map_shortcode'));
    // }