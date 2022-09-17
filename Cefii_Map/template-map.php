<div id="menuMap">
    <ul>
        <li><a href="?page=Cefii_Map">Creer une carte</a></li>
        <?php
            $maplist = $this->getmaplist();
            foreach ($maplist as $getmap) {
                if ($_GET['id'] == $getmap->id) {
                    $active = " id=\"active\" ";
                } else {
                    $active = "";
                }
                echo "<li ".$active."><a href=\"?page=Cefii_Map&p=map&id=".$getmap->id."\">".$getmap->titre."</a></li>";
            }
            ?>
    </ul>
</div>

<div class="wrapCefiiMap">
    <h2>Cefii Map</h2>
    <?php $map = $this->getmap($_GET['id']); ?>
    <h3 class="title">Creer une carte: <?php echo $map[0]->titre; ?>
    </h3>
    <div id="infosContainer">
        <div id="infosMap">
            <h3 class="title">Parametres :</h3>
            <div id="placecode">
                <p>Copiez (ctrl+c) le code et collez (ctrl+v) dans le page ou l'atricle ou vous voulez voir apparaitre
                    votre carte:
                    <input type="text" readonly value="[cefiimap id=&quot;<?php echo $map[0]->id; ?> &quot;]" />
                </p>
            </div>
            <form id="formMap" action="?page=Cefii_Map&action=updatemap" method="POST">
                <input type="hidden" name="Cm-id" value="<?php echo $map[0]->id ?>" />
                <p class="errorCefiiMap" id="Cm-title-error">Veuillez renseigner un titre</p>
                <p>
                    <label for="Cm-title">Titre* :</label><br />
                    <input type="text" id="Cm-title" name="Cm-title" value="<?php echo $map[0]->titre; ?>" />
                </p>
                <p class="errorCefiiMap" id="Cm-lat-error">Veuillez renseigner une latitude</p>
                <p>
                    <label for="Cm-latitude">Latitude* :</label><br />
                    <input type="text" id="Cm-latitude" name="Cm-latitude" value="<?php echo $map[0]->latitude; ?>" />
                </p>
                <p class="errorCefiiMap" id="Cm-long-error">Veuillez renseigner une longitude</p>
                <p>
                    <label for="Cm-longitude">Longitude* :</label><br />
                    <input type="text" id="Cm-longitude" name="Cm-longitude"
                        value="<?php echo $map[0]->longitude; ?>" />
                </p>
                <p>
                    <input type="submit" id="bt-map" value="Mettre a jour" class="button-primary" />
                </p>
                <small>* champs obligatoires</small>
            </form>
            <form action="?page=Cefii_Map&action=deletemap" id="formSuppr" method="POST">
                <p>
                    <input type="hidden" name="Cm-id" value="<?php echo $map[0]->id ?>" />
                </p>
                <p>
                    <input type="submit" id="suppr-map" value="supprimer la carte" class="button-secondary" />
                </p>
            </form>
        </div>
        <div id="mapPreview">
            <h3 class="title">Apercu :</h3>
            <div id="map"></div>

            <script>
            var coord = new google.maps
                .LatLng(<?php echo $map[0]->latitude; ?>, <?php echo $map[0]->longitude; ?>);
            var options = {
                center: coord,
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getelemenyById("map"), options);
            </script>
        </div>
    </div>
</div>