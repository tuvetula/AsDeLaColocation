<?php
$title = "Déposer une nouvelle annonce";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron px-1 px-md-3">
        <h1 class="pb-3 text-center">Ajouter une nouvelle annonce</h1>
        <form method="post" action="index.php?page=addAdvertisement" enctype="multipart/form-data"
            onsubmit="spinnerSubmitButton()">
            <!-- ----------Annonce---------- -->
            <div class="container py-3 px-0 px-md-3 border-bottom border-dark">
                <?php if (isset($error) || isset($fillingError)){ ?>
                    <p class="text-danger font-weight-bold pb-1"><?php
                    if(isset($error)){
                        echo 'Problème avec les fichiers téléchargés.';
                    }else if(isset($fillingError)){
                        echo 'Veuillez corriger les erreurs.';
                } ?> </p> <?php } ?>
                <h2>Annonce</h2>
                <!-- Titre, Description -->
                <div class="container">
                    <!--Titre-->
                    <div class="form-group"
                        title="Le titre doit être unique si vous avez plusieurs annonces. Soyez précis et concis.Attention, votre titre est définitif, il ne pourra être modifié.">
                        <label class="font-weight-bold" for="title">Titre</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Titre de l'annonce"
                            maxlength="80" value="<?php if(isset($postData)){
                                echo $postData['title'];
                            }?>" required>
                        <div class="float-right" id="countTitle"></div>
                        <?php  if (isset($fillingError['title'])){ ?>
                        <p class="text-danger font-weight-bold pb-1" type="error" type="error"><?=$fillingError['title']?></p>
                        <?php } ?>
                    </div>
                    <!--Description-->
                    <div class="form-group pb-3">
                        <label class="font-weight-bold" for="description">Description</label>
                        <textarea class="form-control" id="description" rows="6" name="description"
                            placeholder="maximum 2000 caractères" maxlength="2000" required><?php if(isset($postData)){
                                echo $postData['description'];
                            }?></textarea>
                        <div class="float-right" id="countDescription"></div>
                        <?php if (isset($fillingError['description'])){ ?>
                        <p class="text-danger font-weight-bold pb-1" type="error" type="errorT"><?=$fillingError['description']?></p>
                        <?php } ?>
                    </div>
                    <!-- Type, catégorie, disponible le, location sans visite -->
                    <div class="row">
                        <!--Type de logement-->
                        <div class="form-group col-6 col-md-4 col-xl-3" title="Sélectionner le type de bien">
                            <label class="font-weight-bold">Type de logement</label>
                            <div class="form-check">
                                <input id="radioType1" class="form-check-input" type="radio" name="type" value="Maison" <?php if(isset($postData) && $postData['type']=="Maison"){
                                echo "checked";
                            }else if (!isset($postData)){echo "checked";}?>>
                                <label class="form-check-label" for="radioType1">
                                    Maison
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="radioType2" class="form-check-input" type="radio" name="type"
                                    value="Appartement" <?php if(isset($postData) && $postData['type']=="Appartement"){
                                echo "checked";
                            }?>>
                                <label class="form-check-label" for="radioType2">
                                    Appartement
                                </label>
                            </div>
                        </div>
                        <!--Catégorie du logement-->
                        <div class="form-group col-6 col-md-4 col-xl-3" title="Sélectionner la catégorie correspondante">
                            <label class="font-weight-bold">Catégorie</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory1" value="Location" <?php if(isset($postData) && $postData['category']=="Location"){
                                echo "checked";
                            }else if (!isset($postData)){echo "checked";}?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory1">
                                    Location
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory2" value="Colocation" <?php if(isset($postData) && $postData['category']=="Colocation"){
                                echo "checked";
                            }?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory2">
                                    Colocation
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory3" value="Sous-location" <?php if(isset($postData) && $postData['category']=="Sous-location"){
                                echo "checked";
                            }?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory3">
                                    Sous-location
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory4" value="Courte-durée" <?php if(isset($postData) && $postData['category']=="Courte-durée"){
                                echo "checked";
                            }?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory4">
                                    Courte-durée
                                </label>
                            </div>
                        </div>
                        <!-- Disponible le -->
                        <div class="form-group col-md-4 col-xl-3" title="Donner la date à laquelle le locataire pourra entrer">
                            <label for="availableDate" class="font-weight-bold">Disponible le</label>
                            <input class="form-control" type="date" min="<?php echo date('Y-m-d');?>" id="availableDate"
                                name="availableDate"
                                value="<?php if(isset($postData['availableDate'])){echo $postData['availableDate'];}else{echo date('Y-m-d');}?>"
                                required>
                        </div>
                        <!-- Location sans visite + meublé -->
                        <div class="form-group col-md-6 col-xl-3">
                            <!-- Meublé -->
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="isFurnished" name="isFurnished"
                                    <?php if(isset($postData['isFurnished'])){echo "checked";}?>>
                                <label class="custom-control-label font-weight-bold" for="isFurnished">Meublé</label>
                            </div>
                            <!-- Location sans visite -->
                            <div class="custom-control custom-checkbox"
                                title="J'accepte le dossier d'un candidat qui n'a pas visité">
                                <input type="checkbox" class="custom-control-input" id="rentWithoutVisit"
                                    name="rentWithoutVisit"
                                    <?php if(isset($postData['rentWithoutVisit'])){echo "checked";}?>>
                                <label class="custom-control-label font-weight-bold" for="rentWithoutVisit">Location
                                    sans
                                    visite</label>
                            </div>
                        </div>
                    </div>
                    <!-- Nom, Telephone, Mail pour les visites-->
                    <div class="row">
                        <!-- Nom du contact pour les visites -->
                        <div class="form-group col-lg-6 col-xl-4">
                            <label for="contactNameForVisit" class="font-weight-bold">Nom du contact pour les
                                visites</label>
                            <input id="contactNameForVisit" type="text" name="contactNameForVisit" class="form-control"
                                placeholder="Nom" maxlength="125" value="<?php if(isset($postData)){
                                echo $postData['contactNameForVisit'];
                            }?>" required>
                            <?php
                                if (isset($fillingError['contactNameForVisit'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['contactNameForVisit'];?></p>
                            <?php } ?>
                        </div>
                        <!-- Telephone du contact pour les visites -->
                        <div class="form-group col-lg-6 col-xl-4">
                            <label for="contactPhoneNumberForVisit" class="font-weight-bold">Telephone du contact
                                pour
                                les visites</label>
                            <input id="contactPhoneNumberForVisit" type="tel" name="contactPhoneNumberForVisit"
                                class="form-control" placeholder="Téléphone" maxlength="20" value="<?php if(isset($postData)){
                                echo $postData['contactPhoneNumberForVisit'];
                            }?>" required>
                            <?php
                                if (isset($fillingError['contactPhoneNumberForVisit'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['contactPhoneNumberForVisit'];?></p>
                            <?php } ?>
                        </div>
                        <!-- Mail du contact pour les visites -->
                        <div class="form-group col-lg-12 col-xl-4">
                            <label for="contactMailForVisit" class="font-weight-bold">Mail du contact pour les
                                visites</label>
                            <input id="contactMailForVisit" type="email" name="contactMailForVisit" class="form-control"
                                placeholder="Mail" maxlength="255" value="<?php if(isset($postData)){
                                echo $postData['contactMailForVisit'];
                            }?>" required>
                            <?php
                                if (isset($fillingError['contactMailForVisit'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['contactMailForVisit'];?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Situation du loueur -->
                        <div class="form-group col-md-6 col-xl-4">
                            <label for="renterSituation" class="font-weight-bold">Situation du loueur </label>
                            <select id="renterSituation" name="renterSituation" class="custom-select">
                                <option value="Propriétaire"
                                    <?php if (isset($postData) && $postData['renterSituation'] == 'Propriétaire'){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Propriétaire</option>
                                <option value="Locataire"
                                    <?php if (isset($postData) && $postData['renterSituation'] == 'Locataire'){echo "selected";}?>>
                                    Locataire</option>
                            </select>
                        </div>
                        <!-- Durée minimum de séjour -->
                        <div class="form-group col-md-6 col-xl-4">
                            <label for="locationMinDuration" class="font-weight-bold">Durée minimum de
                                séjour</label>
                            <select id="locationMinDuration" name="locationMinDuration" class="custom-select">
                                <option value="1 mois"
                                    <?php if (isset($postData) && $postData['locationMinDuration'] == '1 mois'){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    1 mois</option>
                                <option value="3 mois"
                                    <?php if (isset($postData) && $postData['locationMinDuration'] == '3 mois'){echo "selected";}?>>
                                    3 mois</option>
                                <option value="6 mois"
                                    <?php if (isset($postData) && $postData['locationMinDuration'] == '6 mois'){echo "selected";}?>>
                                    6 mois</option>
                                <option value="9 mois"
                                    <?php if (isset($postData) && $postData['locationMinDuration'] == '9 mois'){echo "selected";}?>>
                                    9 mois</option>
                                <option value="12 mois"
                                    <?php if (isset($postData) && $postData['locationMinDuration'] == '12 mois'){echo "selected";}?>>
                                    12 mois</option>
                            </select>
                        </div>
                        <!-- Nombre de colocataires déjà présent -->
                        <div class="form-group col-lg-6 col-xl-4">
                            <label class="font-weight-bold" for="nbOfOtherRoommatePresent">Nombre de
                                colocataire(s)
                                déjà
                                présent(s)</label>
                            <select id="nbOfOtherRoommatePresent" name="nbOfOtherRoommatePresent" class="custom-select">
                                <option value="0"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 0){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    0</option>
                                <option value="1"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 1){echo "selected";}?>>
                                    1</option>
                                <option value="2"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 2){echo "selected";}?>>
                                    2</option>
                                <option value="3"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 3){echo "selected";}?>>
                                    3</option>
                                <option value="4"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 4){echo "selected";}?>>
                                    4</option>
                                <option value="5"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 5){echo "selected";}?>>
                                    5</option>
                                <option value="6"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 6){echo "selected";}?>>
                                    6</option>
                                <option value="7"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 7){echo "selected";}?>>
                                    7</option>
                                <option value="8"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 8){echo "selected";}?>>
                                    8</option>
                                <option value="9"
                                    <?php if (isset($postData) && $postData['nbOfOtherRoommatePresent'] == 9){echo "selected";}?>>
                                    9</option>
                            </select>
                        </div>
                    <!-- Sex colocataires déja présents -->
                        <div class="form-group col-lg-6 offset-xl-8 col-xl-4" id="otherRoommateSex">
                            <label for="roommateSex" class="font-weight-bold">Colocataire(s) déja présent(s)
                                (sexe)</label>
                            <select id="roommateSex" name="roommateSex" class="custom-select">
                                <option id="otherRoommateSexWomenValue" value="Femme"
                                    <?php if (isset($postData) && $postData['roommateSex'] == "Femme"){echo "selected";}?>>
                                    Femme</option>
                                <option id="otherRoommateSexMenValue" value="Homme"
                                    <?php if (isset($postData) && $postData['roommateSex'] == "Homme"){echo "selected";}?>>
                                    Homme</option>
                                <option id="otherRoommateSexMixteValue" value="Mixte"
                                    <?php if (isset($postData) && $postData['roommateSex'] == "Mixte"){echo "selected";}?>>
                                    Mixte</option>
                                <option id="otherRoommateSexNullValue" value="Null"
                                    <?php if (isset($postData) && $postData['roommateSex'] == "Null"){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Null</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Colocataire idéal (sexe) -->
                        <div class="form-group col-md-6 col-xl-4">
                            <label for="idealRoommateSex" class="font-weight-bold">Colocataire idéal
                                (sexe)</label>
                            <select id="idealRoommateSex" name="idealRoommateSex" class="custom-select">
                                <option value="PeuImporte"
                                    <?php if (isset($postData) && $postData['idealRoommateSex'] == "PeuImporte"){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Peu importe</option>
                                <option value="Femme"
                                    <?php if (isset($postData) && $postData['idealRoommateSex'] == "Femme"){echo "selected";}?>>
                                    Femme</option>
                                <option value="Homme"
                                    <?php if (isset($postData) && $postData['idealRoommateSex'] == "Homme"){echo "selected";}?>>
                                    Homme</option>
                            </select>
                        </div>
                        <!-- Colocataire idéal (situation) -->
                        <div class="form-group col-md-6 col-xl-4">
                            <label for="idealRoommateSituation" class="font-weight-bold">Colocataire idéal
                                (situation)</label>
                            <select id="idealRoommateSituation" name="idealRoommateSituation" class="custom-select">
                                <option value="PeuImporte"
                                    <?php if (isset($postData) && $postData['idealRoommateSituation'] == "PeuImporte"){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Peu importe</option>
                                <option value="Etudiant"
                                    <?php if (isset($postData) && $postData['idealRoommateSituation'] == "Etudiant"){echo "selected";}?>>
                                    Etudiant(e)</option>
                                <option value="Salarié"
                                    <?php if (isset($postData) && $postData['idealRoommateSituation'] == "Salarié"){echo "selected";}?>>
                                    Salarié(e)</option>
                            </select>
                        </div>
                        <!-- Age minimum -->
                        <div class="form-group col-6 col-xl-2">
                            <label class="font-weight-bold" for="idealRoommateMinAge">Age minimum</label>
                            <select id="idealRoommateMinAge" name="idealRoommateMinAge" class="custom-select">
                                <option value="18"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 18){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    18</option>
                                <option value="19"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 19){echo "selected";}?>>
                                    19</option>
                                <option value="20"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 20){echo "selected";}?>>
                                    20</option>
                                <option value="21"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 21){echo "selected";}?>>
                                    21</option>
                                <option value="22"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 22){echo "selected";}?>>
                                    22</option>
                                <option value="23"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 23){echo "selected";}?>>
                                    23</option>
                                <option value="24"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 24){echo "selected";}?>>
                                    24</option>
                                <option value="25"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 25){echo "selected";}?>>
                                    25</option>
                                <option value="26"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 26){echo "selected";}?>>
                                    26</option>
                                <option value="27"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 27){echo "selected";}?>>
                                    27</option>
                                <option value="28"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 28){echo "selected";}?>>
                                    28</option>
                                <option value="29"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 29){echo "selected";}?>>
                                    29</option>
                                <option value="30"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 30){echo "selected";}?>>
                                    30</option>
                                <option value="31"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 31){echo "selected";}?>>
                                    31</option>
                                <option value="32"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 32){echo "selected";}?>>
                                    32</option>
                                <option value="33"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 33){echo "selected";}?>>
                                    33</option>
                                <option value="34"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 34){echo "selected";}?>>
                                    34</option>
                                <option value="35"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 35){echo "selected";}?>>
                                    35</option>
                                <option value="36"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 36){echo "selected";}?>>
                                    36</option>
                                <option value="37"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 37){echo "selected";}?>>
                                    37</option>
                                <option value="38"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 38){echo "selected";}?>>
                                    38</option>
                                <option value="39"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 39){echo "selected";}?>>
                                    39</option>
                                <option value="40"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 40){echo "selected";}?>>
                                    40</option>
                                <option value="41"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 41){echo "selected";}?>>
                                    41</option>
                                <option value="42"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 42){echo "selected";}?>>
                                    42</option>
                                <option value="43"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 43){echo "selected";}?>>
                                    43</option>
                                <option value="44"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 44){echo "selected";}?>>
                                    44</option>
                                <option value="45"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 45){echo "selected";}?>>
                                    45</option>
                                <option value="46"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 46){echo "selected";}?>>
                                    46</option>
                                <option value="47"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 47){echo "selected";}?>>
                                    47</option>
                                <option value="48"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 48){echo "selected";}?>>
                                    48</option>
                                <option value="49"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 49){echo "selected";}?>>
                                    49</option>
                                <option value="50"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 50){echo "selected";}?>>
                                    50</option>
                                <option value="51"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 51){echo "selected";}?>>
                                    51</option>
                                <option value="52"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 52){echo "selected";}?>>
                                    52</option>
                                <option value="53"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 53){echo "selected";}?>>
                                    53</option>
                                <option value="54"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 54){echo "selected";}?>>
                                    54</option>
                                <option value="55"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 55){echo "selected";}?>>
                                    55</option>
                                <option value="56"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 56){echo "selected";}?>>
                                    56</option>
                                <option value="57"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 57){echo "selected";}?>>
                                    57</option>
                                <option value="58"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 58){echo "selected";}?>>
                                    58</option>
                                <option value="59"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 59){echo "selected";}?>>
                                    59</option>
                                <option value="60"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 60){echo "selected";}?>>
                                    60</option>
                                <option value="61"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 61){echo "selected";}?>>
                                    61</option>
                                <option value="62"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 62){echo "selected";}?>>
                                    62</option>
                                <option value="63"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 63){echo "selected";}?>>
                                    63</option>
                                <option value="64"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 64){echo "selected";}?>>
                                    64</option>
                                <option value="65"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 65){echo "selected";}?>>
                                    65</option>
                                <option value="66"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 66){echo "selected";}?>>
                                    66</option>
                                <option value="67"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 67){echo "selected";}?>>
                                    67</option>
                                <option value="68"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 68){echo "selected";}?>>
                                    68</option>
                                <option value="69"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 69){echo "selected";}?>>
                                    69</option>
                                <option value="70"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 70){echo "selected";}?>>
                                    70</option>
                                <option value="71"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 71){echo "selected";}?>>
                                    71</option>
                                <option value="72"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 72){echo "selected";}?>>
                                    72</option>
                                <option value="73"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 73){echo "selected";}?>>
                                    73</option>
                                <option value="74"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 74){echo "selected";}?>>
                                    74</option>
                                <option value="75"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 75){echo "selected";}?>>
                                    75</option>
                                <option value="76"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 76){echo "selected";}?>>
                                    76</option>
                                <option value="77"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 77){echo "selected";}?>>
                                    77</option>
                                <option value="78"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 78){echo "selected";}?>>
                                    78</option>
                                <option value="79"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 79){echo "selected";}?>>
                                    79</option>
                                <option value="80"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 80){echo "selected";}?>>
                                    80</option>
                                <option value="81"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 81){echo "selected";}?>>
                                    81</option>
                                <option value="82"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 82){echo "selected";}?>>
                                    82</option>
                                <option value="83"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 83){echo "selected";}?>>
                                    83</option>
                                <option value="84"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 84){echo "selected";}?>>
                                    84</option>
                                <option value="85"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 85){echo "selected";}?>>
                                    85</option>
                                <option value="86"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 86){echo "selected";}?>>
                                    86</option>
                                <option value="87"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 87){echo "selected";}?>>
                                    87</option>
                                <option value="88"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 88){echo "selected";}?>>
                                    88</option>
                                <option value="89"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 89){echo "selected";}?>>
                                    89</option>
                                <option value="90"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 90){echo "selected";}?>>
                                    90</option>
                                <option value="91"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 91){echo "selected";}?>>
                                    91</option>
                                <option value="92"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 92){echo "selected";}?>>
                                    92</option>
                                <option value="93"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 93){echo "selected";}?>>
                                    93</option>
                                <option value="94"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 94){echo "selected";}?>>
                                    94</option>
                                <option value="95"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 95){echo "selected";}?>>
                                    95</option>
                                <option value="96"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 96){echo "selected";}?>>
                                    96</option>
                                <option value="97"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 97){echo "selected";}?>>
                                    97</option>
                                <option value="98"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 98){echo "selected";}?>>
                                    98</option>
                                <option value="99"
                                    <?php if (isset($postData) && $postData['idealRoommateMinAge'] == 99){echo "selected";}?>>
                                    99</option>
                            </select>
                        </div>
                        <!-- Age maximum -->
                        <div class="form-group col-6 col-xl-2">
                            <label class="font-weight-bold" for="idealRoommateMaxAge">Age maximum</label>
                            <select id="idealRoommateMaxAge" name="idealRoommateMaxAge" class="custom-select">
                                <option value="18"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 18){echo "selected";}?>>
                                    18</option>
                                <option value="19"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 19){echo "selected";}?>>
                                    19</option>
                                <option value="20"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 20){echo "selected";}?>>
                                    20</option>
                                <option value="21"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 21){echo "selected";}?>>
                                    21</option>
                                <option value="22"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 22){echo "selected";}?>>
                                    22</option>
                                <option value="23"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 23){echo "selected";}?>>
                                    23</option>
                                <option value="24"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 24){echo "selected";}?>>
                                    24</option>
                                <option value="25"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 25){echo "selected";}?>>
                                    25</option>
                                <option value="26"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 26){echo "selected";}?>>
                                    26</option>
                                <option value="27"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 27){echo "selected";}?>>
                                    27</option>
                                <option value="28"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 28){echo "selected";}?>>
                                    28</option>
                                <option value="29"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 29){echo "selected";}?>>
                                    29</option>
                                <option value="30"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 30){echo "selected";}?>>
                                    30</option>
                                <option value="31"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 31){echo "selected";}?>>
                                    31</option>
                                <option value="32"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 32){echo "selected";}?>>
                                    32</option>
                                <option value="33"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 33){echo "selected";}?>>
                                    33</option>
                                <option value="34"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 34){echo "selected";}?>>
                                    34</option>
                                <option value="35"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 35){echo "selected";}?>>
                                    35</option>
                                <option value="36"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 36){echo "selected";}?>>
                                    36</option>
                                <option value="37"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 37){echo "selected";}?>>
                                    37</option>
                                <option value="38"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 38){echo "selected";}?>>
                                    38</option>
                                <option value="39"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 39){echo "selected";}?>>
                                    39</option>
                                <option value="40"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 40){echo "selected";}?>>
                                    40</option>
                                <option value="41"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 41){echo "selected";}?>>
                                    41</option>
                                <option value="42"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 42){echo "selected";}?>>
                                    42</option>
                                <option value="43"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 43){echo "selected";}?>>
                                    43</option>
                                <option value="44"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 44){echo "selected";}?>>
                                    44</option>
                                <option value="45"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 45){echo "selected";}?>>
                                    45</option>
                                <option value="46"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 46){echo "selected";}?>>
                                    46</option>
                                <option value="47"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 47){echo "selected";}?>>
                                    47</option>
                                <option value="48"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 48){echo "selected";}?>>
                                    48</option>
                                <option value="49"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 49){echo "selected";}?>>
                                    49</option>
                                <option value="50"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 50){echo "selected";}?>>
                                    50</option>
                                <option value="51"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 51){echo "selected";}?>>
                                    51</option>
                                <option value="52"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 52){echo "selected";}?>>
                                    52</option>
                                <option value="53"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 53){echo "selected";}?>>
                                    53</option>
                                <option value="54"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 54){echo "selected";}?>>
                                    54</option>
                                <option value="55"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 55){echo "selected";}?>>
                                    55</option>
                                <option value="56"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 56){echo "selected";}?>>
                                    56</option>
                                <option value="57"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 57){echo "selected";}?>>
                                    57</option>
                                <option value="58"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 58){echo "selected";}?>>
                                    58</option>
                                <option value="59"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 59){echo "selected";}?>>
                                    59</option>
                                <option value="60"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 60){echo "selected";}?>>
                                    60</option>
                                <option value="61"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 61){echo "selected";}?>>
                                    61</option>
                                <option value="62"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 62){echo "selected";}?>>
                                    62</option>
                                <option value="63"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 63){echo "selected";}?>>
                                    63</option>
                                <option value="64"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 64){echo "selected";}?>>
                                    64</option>
                                <option value="65"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 65){echo "selected";}?>>
                                    65</option>
                                <option value="66"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 66){echo "selected";}?>>
                                    66</option>
                                <option value="67"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 67){echo "selected";}?>>
                                    67</option>
                                <option value="68"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 68){echo "selected";}?>>
                                    68</option>
                                <option value="69"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 69){echo "selected";}?>>
                                    69</option>
                                <option value="70"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 70){echo "selected";}?>>
                                    70</option>
                                <option value="71"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 71){echo "selected";}?>>
                                    71</option>
                                <option value="72"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 72){echo "selected";}?>>
                                    72</option>
                                <option value="73"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 73){echo "selected";}?>>
                                    73</option>
                                <option value="74"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 74){echo "selected";}?>>
                                    74</option>
                                <option value="75"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 75){echo "selected";}?>>
                                    75</option>
                                <option value="76"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 76){echo "selected";}?>>
                                    76</option>
                                <option value="77"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 77){echo "selected";}?>>
                                    77</option>
                                <option value="78"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 78){echo "selected";}?>>
                                    78</option>
                                <option value="79"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 79){echo "selected";}?>>
                                    79</option>
                                <option value="80"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 80){echo "selected";}?>>
                                    80</option>
                                <option value="81"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 81){echo "selected";}?>>
                                    81</option>
                                <option value="82"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 82){echo "selected";}?>>
                                    82</option>
                                <option value="83"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 83){echo "selected";}?>>
                                    83</option>
                                <option value="84"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 84){echo "selected";}?>>
                                    84</option>
                                <option value="85"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 85){echo "selected";}?>>
                                    85</option>
                                <option value="86"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 86){echo "selected";}?>>
                                    86</option>
                                <option value="87"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 87){echo "selected";}?>>
                                    87</option>
                                <option value="88"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 88){echo "selected";}?>>
                                    88</option>
                                <option value="89"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 89){echo "selected";}?>>
                                    89</option>
                                <option value="90"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 90){echo "selected";}?>>
                                    90</option>
                                <option value="91"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 91){echo "selected";}?>>
                                    91</option>
                                <option value="92"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 92){echo "selected";}?>>
                                    92</option>
                                <option value="93"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 93){echo "selected";}?>>
                                    93</option>
                                <option value="94"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 94){echo "selected";}?>>
                                    94</option>
                                <option value="95"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 95){echo "selected";}?>>
                                    95</option>
                                <option value="96"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 96){echo "selected";}?>>
                                    96</option>
                                <option value="97"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 97){echo "selected";}?>>
                                    97</option>
                                <option value="98"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 98){echo "selected";}?>>
                                    98</option>
                                <option value="99"
                                    <?php if (isset($postData) && $postData['idealRoommateMaxAge'] == 99){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    99</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ----------LOYER---------- -->
            <div class="container py-3 px-0 px-md-3 border-bottom border-dark">
                <h2>Loyer</h2>
                <div class="container">
                    <div class="row">
                        <!-- Montant HC -->
                        <div class="form-group col-sm-6 col-md-4" title="Loyer Hors Charges">
                            <label class="font-weight-bold" for="monthlyRentExcludingCharges">Loyer mensuel HC</label>
                            <div id="monthlyRentExcludingChargesDiv" class="input-group">
                                <input id="monthlyRentExcludingCharges" type="number" min="0"
                                    name="monthlyRentExcludingCharges" class="form-control"
                                    aria-describedby="basic-addon2" value="<?php if(isset($postData)){
                                echo $postData['monthlyRentExcludingCharges'];
                            }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                                <?php
                                if (isset($fillingError['monthlyRentExcludingCharges'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['monthlyRentExcludingCharges'];?></p>
                            <?php } ?>
                            </div>
                        </div>
                        <!-- Montant des charges -->
                        <div class="form-group col-sm-6 col-md-4">
                            <label class="font-weight-bold" for="charges">Montant des charges</label>
                            <div id="chargesDiv" class="input-group">
                                <input id="charges" type="number" min="0" name="charges" class="form-control"
                                    aria-describedby="basic-addon2" value="<?php if(isset($postData)){
                                    echo $postData['charges'];
                                    }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                                <?php
                                if (isset($fillingError['charges'])){?>
                                <p class="text-danger font-weight-bold pb-1" type="error"><?php
                                echo $fillingError['charges'];?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Montant de la caution -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="suretyBond">Montant de la caution</label>
                            <div id="suretyBondDiv" class="input-group">
                                <input id="suretyBond" type="number" min="0" name="suretyBond" class="form-control"
                                    aria-describedby="basic-addon2" value="<?php if(isset($postData)){
                                    echo $postData['suretyBond'];
                                    }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                                <?php
                                if (isset($fillingError['suretyBond'])){?>
                                <p class="text-danger font-weight-bold pb-1" type="error"><?php
                                echo $fillingError['suretyBond'];?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Le garant doit résider -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label for="guarantorLiving" class="font-weight-bold">Le garant doit résider</label>
                            <select id="guarantorLiving" name="guarantorLiving" class="custom-select">
                                <option value="France"
                                    <?php if (isset($postData) && $postData['guarantorLiving'] == "France"){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    France</option>
                                <option value="Europe"
                                    <?php if (isset($postData) && $postData['guarantorLiving'] == "Europe"){echo "selected";}?>>
                                    Europe</option>
                                <option value="PeuImporte"
                                    <?php if (isset($postData) && $postData['guarantorLiving'] == "PeuImporte"){echo "selected";}?>>
                                    Peu importe</option>
                            </select>
                        </div>
                        <!-- Ratio de solvabilité -->
                        <div class="form-group col-md-6 col-lg-4" title="A combien de loyers le revenu doit-il être supérieur?">
                            <label for="solvencyRatio" class="font-weight-bold">Ratio de solvabilité</label>
                            <select id="solvencyRatio" name="solvencyRatio" class="custom-select">
                                <option value="PeuImporte"
                                    <?php if (isset($postData) && $postData['solvencyRatio'] == "PeuImporte"){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Peu importe</option>
                                <option value="1X"
                                    <?php if (isset($postData) && $postData['solvencyRatio'] == "1X"){echo "selected";}?>>
                                    1X</option>
                                <option value="1.5X"
                                    <?php if (isset($postData) && $postData['solvencyRatio'] == "1.5X"){echo "selected";}?>>
                                    1.5X</option>
                                <option value="2X"
                                    <?php if (isset($postData) && $postData['solvencyRatio'] == "2X"){echo "selected";}?>>
                                    2X</option>
                                <option value="2.5X"
                                    <?php if (isset($postData) && $postData['solvencyRatio'] == "2.5X"){echo "selected";}?>>
                                    2.5X</option>
                                <option value="3X"
                                    <?php if (isset($postData) && $postData['solvencyRatio'] == "3X"){echo "selected";}?>>
                                    3X</option>
                                <option value="4X"
                                    <?php if (isset($postData) && $postData['solvencyRatio'] == "4X"){echo "selected";}?>>
                                    4X</option>
                                <option value="5X"
                                    <?php if (isset($postData) && $postData['solvencyRatio'] == "5X"){echo "selected";}?>>
                                    5X</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pt-md-2">
                        <!-- Exigences financières -->
                        <div class="form-group col-sm-6 col-lg-4" title="J'ai des exigences financières pour le candidat">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="financialRequirements"
                                    name="financialRequirements"
                                    <?php if(isset($postData['financialRequirements'])){echo "checked";}?>>
                                <label class="custom-control-label font-weight-bold"
                                    for="financialRequirements">Exigences financières</label>
                            </div>
                        </div>
                        <!-- Eligible aux aides -->
                        <div class="form-group col-sm-6 col-lg-4">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="eligibleForAids"
                                    name="eligibleForAids"
                                    <?php if(isset($postData['eligibleForAids'])){echo "checked";}?>>
                                <label class="custom-control-label font-weight-bold" for="eligibleForAids">Eligible aux
                                    aides (apl,...)</label>
                            </div>
                        </div>
                    </div>
                    <h3 class="pt-3">Inclus dans les charges:</h3>
                    <div class="row">
                        <!-- Electricité -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeElectricity"
                                    name="chargesIncludeElectricity"
                                    <?php if(isset($postData['chargesIncludeElectricity'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeElectricity">Electricité</label>
                            </div>
                        </div>
                        <!-- Eau chaude -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHotWater"
                                    name="chargesIncludeHotWater"
                                    <?php if(isset($postData['chargesIncludeHotWater'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeHotWater">Eau
                                    chaude</label>
                            </div>
                        </div>
                        <!-- Chauffage -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHeating"
                                    name="chargesIncludeHeating"
                                    <?php if(isset($postData['chargesIncludeHeating'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeHeating">Chauffage</label>
                            </div>
                        </div>
                        <!-- Internet -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeInternet"
                                    name="chargesIncludeInternet"
                                    <?php if(isset($postData['chargesIncludeInternet'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeInternet">Internet</label>
                            </div>
                        </div>
                        <!-- Charges de co-propriété -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="chargesIncludeCoOwnershipCharges" name="chargesIncludeCoOwnershipCharges"
                                    <?php if(isset($postData['chargesIncludeCoOwnershipCharges'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeCoOwnershipCharges">Charges de
                                    co-propriété</label>
                            </div>
                        </div>
                        <!-- Assurance habitation -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHomeInsurance"
                                    name="chargesIncludeHomeInsurance"
                                    <?php if(isset($postData['chargesIncludeHomeInsurance'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeHomeInsurance">Assurance
                                    habitation</label>
                            </div>
                        </div>
                        <!-- Révision chaudière -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeBoilerInspection"
                                    name="chargesIncludeBoilerInspection"
                                    <?php if(isset($postData['chargesIncludeBoilerInspection'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeBoilerInspection">Révision
                                    chaudière</label>
                            </div>
                        </div>
                        <!-- Taxe d'ordures ménagères -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="chargesIncludeHouseholdGarbageTaxes" name="chargesIncludeHouseholdGarbageTaxes"
                                    <?php if(isset($postData['chargesIncludeHouseholdGarbageTaxes'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeHouseholdGarbageTaxes">Taxe
                                    d'ordures ménagères</label>
                            </div>
                        </div>
                        <!-- Service de nettoyage -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeCleaningService"
                                    name="chargesIncludeCleaningService"
                                    <?php if(isset($postData['chargesIncludeCleaningService'])){echo "checked";}?>>
                                <label class="custom-control-label" for="chargesIncludeCleaningService">Service de
                                    nettoyage</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ---------- LOGEMENT ---------- -->
            <div class="container py-3 px-0 px-md-3 border-bottom border-dark">
                <h2>Logement</h2>
                <div class="container">
                    <!-- AdresseAutocomplete -->
                    <div id="divForstreetAutocompleteDiv">
                    </div>
                    <?php if (isset($fillingError['street']) || isset($fillingError['zipcode']) || isset($fillingError['city']) || isset($fillingError['country'])){ ?>
                    <p class="text-danger font-weight-bold pb-1" type="error" id="errorAddressPhp"><?php echo 'Veuillez renseigner une adresse valide';?></p>
                    <?php } ?>
                    <!-- Adresse -->
                    <div id="streetDiv" class="form-group">
                        <label for="street" class="font-weight-bold">Numéro et nom de rue</label>
                        <input id="street" type="text" name="street" title="Numéro et nom de rue" class="form-control"
                            placeholder="Saisir l'adresse du logement" maxlength="255" value="<?php if(isset($postData)){
                                echo $postData['street'];
                            }?>">
                            <p class="text-danger font-weight-bold pb-1" type="error">
                                <?php if (isset($fillingError['street'])){echo $fillingError['street'];} ?></p>
                    </div>
                    <!-- Code postal, ville, pays -->
                    <div class="row">
                        <!-- Code postal -->
                        <div id="zipcodeDiv" class="form-group col-md-2">
                            <label for="zipcode" class="font-weight-bold">Code postal</label>
                            <input id="zipcode" type="text" name="zipcode" title="Code postal" class="form-control"
                                placeholder="Code postal" maxlength="20" value="<?php if(isset($postData)){
                                echo $postData['zipcode'];
                            }?>">
                            <p class="text-danger font-weight-bold pb-1" type="error">
                                <?php if (isset($fillingError['zipcode'])){echo $fillingError['zipcode'];} ?></p>
                        </div>
                        <!-- Ville -->
                        <div id="cityDiv" class="form-group col-md-6">
                            <label for="city" class="font-weight-bold">Ville</label>
                            <input id="city" type="text" name="city" title="Ville" class="form-control"
                                placeholder="Ville" maxlength="60" value="<?php if(isset($postData)){
                                echo $postData['city'];
                            }?>">
                            <p class="text-danger font-weight-bold pb-1" type="error">
                                <?php if (isset($fillingError['city'])){echo $fillingError['city'];} ?></p>
                        </div>
                        <!-- Pays -->
                        <div id="countryDiv" class="form-group col-md-4">
                            <label for="country" class="font-weight-bold">Pays</label>
                            <input id="country" type="text" name="country" title="Pays" class="form-control"
                                placeholder="Pays" maxlength="60" value="<?php if(isset($postData)){
                                echo $postData['country'];
                            }?>">
                            <p class="text-danger font-weight-bold pb-1" type="error">
                                <?php if (isset($fillingError['country'])){echo $fillingError['country'];} ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Surface habitable -->
                        <div class="form-group col-md-12 col-lg-4" title="Surface totale du logement">
                            <label class="font-weight-bold" for="accomodationLivingAreaSize">Surface habitable du
                                logement</label>
                            <div id="accomodationLivingAreaSizeDiv" class="input-group">
                                <input id="accomodationLivingAreaSize" type="number" min="1"
                                    name="accomodationLivingAreaSize" class="form-control"
                                    aria-describedby="basic-addon2" value="<?php if(isset($postData)){
                                echo $postData['accomodationLivingAreaSize'];
                            }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m²</span>
                                </div>
                                <?php
                                if (isset($fillingError['accomodationLivingAreaSize'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['accomodationLivingAreaSize'];?></p>
                            <?php } ?>
                            </div>
                        </div>
                        <!-- Etage du logement -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label class="font-weight-bold" for="accomodationFloor">Etage du logement</label>
                            <select id="accomodationFloor" name="accomodationFloor" class="custom-select">
                                <option value="0"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 0){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    0</option>
                                <option value="1"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 1){echo "selected";}?>>
                                    1</option>
                                <option value="2"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 2){echo "selected";}?>>
                                    2</option>
                                <option value="3"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 3){echo "selected";}?>>
                                    3</option>
                                <option value="4"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 4){echo "selected";}?>>
                                    4</option>
                                <option value="5"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 5){echo "selected";}?>>
                                    5</option>
                                <option value="6"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 6){echo "selected";}?>>
                                    6</option>
                                <option value="7"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 7){echo "selected";}?>>
                                    7</option>
                                <option value="8"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 8){echo "selected";}?>>
                                    8</option>
                                <option value="9"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 9){echo "selected";}?>>
                                    9</option>
                                <option value="10"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 10){echo "selected";}?>>
                                    10</option>
                                <option value="11"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 11){echo "selected";}?>>
                                    11</option>
                                <option value="12"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 12){echo "selected";}?>>
                                    12</option>
                                <option value="13"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 13){echo "selected";}?>>
                                    13</option>
                                <option value="14"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 14){echo "selected";}?>>
                                    14</option>
                                <option value="15"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 15){echo "selected";}?>>
                                    15</option>
                                <option value="16"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 16){echo "selected";}?>>
                                    16</option>
                                <option value="17"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 17){echo "selected";}?>>
                                    17</option>
                                <option value="18"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 18){echo "selected";}?>>
                                    18</option>
                                <option value="19"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 19){echo "selected";}?>>
                                    19</option>
                                <option value="20"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 20){echo "selected";}?>>
                                    20</option>
                                <option value="21"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 21){echo "selected";}?>>
                                    21</option>
                                <option value="22"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 22){echo "selected";}?>>
                                    22</option>
                                <option value="23"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 23){echo "selected";}?>>
                                    23</option>
                                <option value="24"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 24){echo "selected";}?>>
                                    24</option>
                                <option value="25"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 25){echo "selected";}?>>
                                    25</option>
                                <option value="26"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 26){echo "selected";}?>>
                                    26</option>
                                <option value="27"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 27){echo "selected";}?>>
                                    27</option>
                                <option value="28"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 28){echo "selected";}?>>
                                    28</option>
                                <option value="29"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 29){echo "selected";}?>>
                                    29</option>
                                <option value="30"
                                    <?php if (isset($postData) && $postData['accomodationFloor'] == 30){echo "selected";}?>>
                                    30</option>
                            </select>
                        </div>
                        <!-- Nombre d'étages -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label class="font-weight-bold" for="buildingNbOfFloors">Nombre d'etages (immeuble)</label>
                            <select id="buildingNbOfFloors" name="buildingNbOfFloors" class="custom-select">
                                <option value="0"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 0){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    0</option>
                                <option value="1"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 1){echo "selected";}?>>
                                    1</option>
                                <option value="2"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 2){echo "selected";}?>>
                                    2</option>
                                <option value="3"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 3){echo "selected";}?>>
                                    3</option>
                                <option value="4"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 4){echo "selected";}?>>
                                    4</option>
                                <option value="5"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 5){echo "selected";}?>>
                                    5</option>
                                <option value="6"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 6){echo "selected";}?>>
                                    6</option>
                                <option value="7"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 7){echo "selected";}?>>
                                    7</option>
                                <option value="8"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 8){echo "selected";}?>>
                                    8</option>
                                <option value="9"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 9){echo "selected";}?>>
                                    9</option>
                                <option value="10"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 10){echo "selected";}?>>
                                    10</option>
                                <option value="11"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 11){echo "selected";}?>>
                                    11</option>
                                <option value="12"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 12){echo "selected";}?>>
                                    12</option>
                                <option value="13"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 13){echo "selected";}?>>
                                    13</option>
                                <option value="14"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 14){echo "selected";}?>>
                                    14</option>
                                <option value="15"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 15){echo "selected";}?>>
                                    15</option>
                                <option value="16"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 16){echo "selected";}?>>
                                    16</option>
                                <option value="17"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 17){echo "selected";}?>>
                                    17</option>
                                <option value="18"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 18){echo "selected";}?>>
                                    18</option>
                                <option value="19"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 19){echo "selected";}?>>
                                    19</option>
                                <option value="20"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 20){echo "selected";}?>>
                                    20</option>
                                <option value="21"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 21){echo "selected";}?>>
                                    21</option>
                                <option value="22"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 22){echo "selected";}?>>
                                    22</option>
                                <option value="23"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 23){echo "selected";}?>>
                                    23</option>
                                <option value="24"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 24){echo "selected";}?>>
                                    24</option>
                                <option value="25"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 25){echo "selected";}?>>
                                    25</option>
                                <option value="26"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 26){echo "selected";}?>>
                                    26</option>
                                <option value="27"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 27){echo "selected";}?>>
                                    27</option>
                                <option value="28"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 28){echo "selected";}?>>
                                    28</option>
                                <option value="29"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 29){echo "selected";}?>>
                                    29</option>
                                <option value="30"
                                    <?php if (isset($postData) && $postData['buildingNbOfFloors'] == 30){echo "selected";}?>>
                                    30</option>
                            </select>
                        </div>
                        <!-- Nombre de pièces -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label class="font-weight-bold" for="accomodationNbOfRooms">Nombre de pièces</label>
                            <select id="accomodationNbOfRooms" name="accomodationNbOfRooms" class="custom-select">
                                <option value="0"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 0){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    0</option>
                                <option value="1"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 1){echo "selected";}?>>
                                    1</option>
                                <option value="2"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 2){echo "selected";}?>>
                                    2</option>
                                <option value="3"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 3){echo "selected";}?>>
                                    3</option>
                                <option value="4"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 4){echo "selected";}?>>
                                    4</option>
                                <option value="5"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 5){echo "selected";}?>>
                                    5</option>
                                <option value="6"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 6){echo "selected";}?>>
                                    6</option>
                                <option value="7"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 7){echo "selected";}?>>
                                    7</option>
                                <option value="8"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 8){echo "selected";}?>>
                                    8</option>
                                <option value="9"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 9){echo "selected";}?>>
                                    9</option>
                                <option value="10"
                                    <?php if (isset($postData) && $postData['accomodationNbOfRooms'] == 10){echo "selected";}?>>
                                    10</option>
                            </select>
                        </div>
                        <!-- Nombre de salles de bains -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label class="font-weight-bold" for="accomodationNbOfBathrooms">Nombre de salles de
                                bain</label>
                            <select id="accomodationNbOfBathrooms" name="accomodationNbOfBathrooms"
                                class="custom-select">
                                <option value="0"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 0){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    0</option>
                                <option value="1"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 1){echo "selected";}?>>
                                    1</option>
                                <option value="2"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 2){echo "selected";}?>>
                                    2</option>
                                <option value="3"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 3){echo "selected";}?>>
                                    3</option>
                                <option value="4"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 4){echo "selected";}?>>
                                    4</option>
                                <option value="5"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 5){echo "selected";}?>>
                                    5</option>
                                <option value="6"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 6){echo "selected";}?>>
                                    6</option>
                                <option value="7"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 7){echo "selected";}?>>
                                    7</option>
                                <option value="8"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 8){echo "selected";}?>>
                                    8</option>
                                <option value="9"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 9){echo "selected";}?>>
                                    9</option>
                                <option value="10"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBathrooms'] == 10){echo "selected";}?>>
                                    10</option>
                            </select>
                        </div>
                        <!-- Nombre de chambres -->
                        <div class="form-group col-md-6 col-lg-4" title="Nombre de chambres que contient au total le logement">
                            <label class="font-weight-bold" for="accomodationNbOfBedrooms">Nombre de chambres</label>
                            <select id="accomodationNbOfBedrooms" name="accomodationNbOfBedrooms" class="custom-select">
                                <option value="0"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 0){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    0</option>
                                <option value="1"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 1){echo "selected";}?>>
                                    1</option>
                                <option value="2"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 2){echo "selected";}?>>
                                    2</option>
                                <option value="3"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 3){echo "selected";}?>>
                                    3</option>
                                <option value="4"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 4){echo "selected";}?>>
                                    4</option>
                                <option value="5"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 5){echo "selected";}?>>
                                    5</option>
                                <option value="6"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 6){echo "selected";}?>>
                                    6</option>
                                <option value="7"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 7){echo "selected";}?>>
                                    7</option>
                                <option value="8"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 8){echo "selected";}?>>
                                    8</option>
                                <option value="9"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 9){echo "selected";}?>>
                                    9</option>
                                <option value="10"
                                    <?php if (isset($postData) && $postData['accomodationNbOfBedrooms'] == 10){echo "selected";}?>>
                                    10</option>
                            </select>
                        </div>
                        <!-- Nombre de chambres à louer-->
                        <div class="form-group col-md-6 col-lg-4" title="Nombre de chambres disponibles">
                            <label class="font-weight-bold" for="nbOfBedroomsToRent">Nombre de chambres à louer</label>
                            <select id="nbOfBedroomsToRent" name="nbOfBedroomsToRent" class="custom-select">
                                <option value="1"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 1){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    1</option>
                                <option value="2"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 2){echo "selected";}?>>
                                    2</option>
                                <option value="3"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 3){echo "selected";}?>>
                                    3</option>
                                <option value="4"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 4){echo "selected";}?>>
                                    4</option>
                                <option value="5"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 5){echo "selected";}?>>
                                    5</option>
                                <option value="6"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 6){echo "selected";}?>>
                                    6</option>
                                <option value="7"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 7){echo "selected";}?>>
                                    7</option>
                                <option value="8"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 8){echo "selected";}?>>
                                    8</option>
                                <option value="9"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 9){echo "selected";}?>>
                                    9</option>
                                <option value="10"
                                    <?php if (isset($postData) && $postData['nbOfBedroomsToRent'] == 10){echo "selected";}?>>
                                    10</option>
                            </select>
                        </div>
                        <!-- Utilisation de la cuisine -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label for="kitchenUse" class="font-weight-bold">Utilisation de la cuisine</label>
                            <select id="kitchenUse" name="kitchenUse" class="custom-select">
                                <option value="Commun"
                                    <?php if (isset($postData) && $postData['kitchenUse'] == 'Commun'){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Commun</option>
                                <option value="Privée"
                                    <?php if (isset($postData) && $postData['kitchenUse'] == 'Privée'){echo "selected";}?>>
                                    Privée</option>
                            </select>
                        </div>
                        <!-- Utilisation du salon -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label for="livingRoomUse" class="font-weight-bold">Utilisation du salon</label>
                            <select id="livingRoomUse" name="livingRoomUse" class="custom-select">
                                <option value="Commun"
                                    <?php if (isset($postData) && $postData['livingRoomUse'] == 'Commun'){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Commun</option>
                                <option value="Privée"
                                    <?php if (isset($postData) && $postData['livingRoomUse'] == 'Privée'){echo "selected";}?>>
                                    Privée</option>
                                <option value="Aucun"
                                    <?php if (isset($postData) && $postData['livingRoomUse'] == 'Aucun'){echo "selected";}?>>
                                    Aucun</option>
                            </select>
                        </div>
                    </div>
                    <!-- Classe Energie -->
                    <div class="row">
                        <!--Performance energetique -->
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold" for="EnergeticPerformance">Diagnostic de performance
                                énergétique</label>
                            <div id="EnergeticPerformance" class="input-group mb-3">
                                <input id="energyClassNumber" type="number" min="1" name="energyClassNumber"
                                    class="form-control" placeholder="0" aria-describedby="basic-addon2" value="<?php if(isset($postData)){
                                echo $postData['energyClassNumber'];
                            }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">kWhEp/m²/an</span>
                                </div>
                                <div class="input-group-append  ">
                                    <span id="energyClassLetterView" class="input-group-text" id="basic-addon2"></span>
                                </div>
                                <?php
                                if (isset($fillingError['energyClassNumber'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['energyClassNumber'];?></p>
                            <?php } ?>
                            </div>
                        </div>
                        <!-- Ges -->
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold" for="EnergeticGes">Emissions de gaz à effet de serre</label>
                            <div id="EnergeticGes" class="input-group mb-3">
                                <input id="gesNumber" type="number" min="1" name="gesNumber" class="form-control"
                                    placeholder="0" aria-describedby="basic-addon2" value="<?php if(isset($postData)){
                                echo $postData['gesNumber'];
                            }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">kgeqCO2/m²/an</span>
                                </div>
                                <div class="input-group-append">
                                    <span id="gesLetterView" class="input-group-text" id="basic-addon2"></span>
                                </div>
                                <?php
                                if (isset($fillingError['gesNumber'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['gesNumber'];?></p>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <h3>Le logement comprend:</h3>
                    <div class="row">
                        <!-- Accès handicapé -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="handicapedAccessibility"
                                    name="handicapedAccessibility"
                                    <?php if(isset($postData['handicapedAccessibility'])){echo "checked";}?>>
                                <label class="custom-control-label " for="handicapedAccessibility">Accès
                                    handicapé</label>
                            </div>
                        </div>
                        <!-- Ascenceur -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasElevator"
                                    name="accomodationHasElevator"
                                    <?php if(isset($postData['accomodationHasElevator'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasElevator">Ascenceur</label>
                            </div>
                        </div>
                        <!-- Parking commun -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasCommonParkingLot"
                                    name="accomodationHasCommonParkingLot"
                                    <?php if(isset($postData['accomodationHasCommonParkingLot'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasCommonParkingLot">Parking
                                    commun</label>
                            </div>
                        </div>
                        <!-- Place de parking privée -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasPrivateParkingPlace" name="accomodationHasPrivateParkingPlace"
                                    <?php if(isset($postData['accomodationHasPrivateParkingPlace'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasPrivateParkingPlace">Place de
                                    parking privée</label>
                            </div>
                        </div>
                        <!-- Jardin -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasGarden"
                                    name="accomodationHasGarden"
                                    <?php if(isset($postData['accomodationHasGarden'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasGarden">Jardin</label>
                            </div>
                        </div>
                        <!-- Balcon -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasBalcony"
                                    name="accomodationHasBalcony"
                                    <?php if(isset($postData['accomodationHasBalcony'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasBalcony">Balcon</label>
                            </div>
                        </div>
                        <!-- Terrasse -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasTerrace"
                                    name="accomodationHasTerrace"
                                    <?php if(isset($postData['accomodationHasTerrace'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasTerrace">Terrasse</label>
                            </div>
                        </div>
                        <!-- Piscine -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasSwimmingPool"
                                    name="accomodationHasSwimmingPool"
                                    <?php if(isset($postData['accomodationHasSwimmingPool'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasSwimmingPool">Piscine</label>
                            </div>
                        </div>
                        <!-- Internet -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasInternet"
                                    name="accomodationHasInternet"
                                    <?php if(isset($postData['accomodationHasInternet'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasInternet">Internet</label>
                            </div>
                        </div>
                        <!-- Wifi -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasWifi"
                                    name="accomodationHasWifi"
                                    <?php if(isset($postData['accomodationHasWifi'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasWifi">Wifi</label>
                            </div>
                        </div>
                        <!-- Fibre optique -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasFiberOpticInternet" name="accomodationHasFiberOpticInternet"
                                    <?php if(isset($postData['accomodationHasFiberOpticInternet'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasFiberOpticInternet">Fibre
                                    optique</label>
                            </div>
                        </div>
                        <!-- Netflix -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasNetflix"
                                    name="accomodationHasNetflix"
                                    <?php if(isset($postData['accomodationHasNetflix'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasNetflix">Netflix</label>
                            </div>
                        </div>
                        <!-- Télévision -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasTv"
                                    name="accomodationHasTv"
                                    <?php if(isset($postData['accomodationHasTv'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasTv">Télévision</label>
                            </div>
                        </div>
                        <!-- Double vitrage -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasDoubleGlazing"
                                    name="accomodationHasDoubleGlazing"
                                    <?php if(isset($postData['accomodationHasDoubleGlazing'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasDoubleGlazing">Double
                                    vitrage</label>
                            </div>
                        </div>
                        <!-- Chauffe eau gaz -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasGasWaterHeater"
                                    name="accomodationHasGasWaterHeater"
                                    <?php if(isset($postData['accomodationHasGasWaterHeater'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasGasWaterHeater">Chauffe eau
                                    gaz</label>
                            </div>
                        </div>
                        <!-- Ballon d'eau chaude -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasHotWaterTank"
                                    name="accomodationHasHotWaterTank"
                                    <?php if(isset($postData['accomodationHasHotWaterTank'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasHotWaterTank">Ballon d'eau
                                    chaude</label>
                            </div>
                        </div>
                        <!-- Climatisation -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasAirConditioning"
                                    name="accomodationHasAirConditioning"
                                    <?php if(isset($postData['accomodationHasAirConditioning'])){echo "checked";}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasAirConditioning">Climatisation</label>
                            </div>
                        </div>
                        <!-- Chauffage éléctrique -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasElectricHeating"
                                    name="accomodationHasElectricHeating"
                                    <?php if(isset($postData['accomodationHasElectricHeating'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasElectricHeating">Chauffage
                                    électrique</label>
                            </div>
                        </div>
                        <!-- Chauffage individuel gaz -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasIndividualGasHeating" name="accomodationHasIndividualGasHeating"
                                    <?php if(isset($postData['accomodationHasIndividualGasHeating'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasIndividualGasHeating">Chauffage
                                    individuel gaz</label>
                            </div>
                        </div>
                        <!-- Chauffage collectif gaz -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasCollectiveGasHeating" name="accomodationHasCollectiveGasHeating"
                                    <?php if(isset($postData['accomodationHasCollectiveGasHeating'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasCollectiveGasHeating">Chauffage
                                    collectif gaz</label>
                            </div>
                        </div>
                        <!-- Lave linge -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasWashingMachine"
                                    name="accomodationHasWashingMachine"
                                    <?php if(isset($postData['accomodationHasWashingMachine'])){echo "checked";}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasWashingMachine">Lave-linge</label>
                            </div>
                        </div>
                        <!-- Lave vaisselle -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasDishwasher"
                                    name="accomodationHasDishwasher"
                                    <?php if(isset($postData['accomodationHasDishwasher'])){echo "checked";}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasDishwasher">Lave-vaisselle</label>
                            </div>
                        </div>
                        <!-- Réfrigérateur -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasFridge"
                                    name="accomodationHasFridge"
                                    <?php if(isset($postData['accomodationHasFridge'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasFridge">Réfrigérateur</label>
                            </div>
                        </div>
                        <!-- Congélateur -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasFreezer"
                                    name="accomodationHasFreezer"
                                    <?php if(isset($postData['accomodationHasFreezer'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasFreezer">Congélateur</label>
                            </div>
                        </div>
                        <!-- Plaques de cuisson -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasBakingTray"
                                    name="accomodationHasBakingTray"
                                    <?php if(isset($postData['accomodationHasBakingTray'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasBakingTray">Plaques de
                                    cuisson</label>
                            </div>
                        </div>
                        <!-- Hotte aspirante -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasExtractorHood"
                                    name="accomodationHasExtractorHood"
                                    <?php if(isset($postData['accomodationHasExtractorHood'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasExtractorHood">Hotte
                                    aspirante</label>
                            </div>
                        </div>
                        <!-- Four -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasOven"
                                    name="accomodationHasOven"
                                    <?php if(isset($postData['accomodationHasOven'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasOven">Four</label>
                            </div>
                        </div>
                        <!-- Micro-ondes -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasMicrowaveOven"
                                    name="accomodationHasMicrowaveOven"
                                    <?php if(isset($postData['accomodationHasMicrowaveOven'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasMicrowaveOven">Four
                                    micro-ondes</label>
                            </div>
                        </div>
                        <!-- Cafetière -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasCoffeeMachine"
                                    name="accomodationHasCoffeeMachine"
                                    <?php if(isset($postData['accomodationHasCoffeeMachine'])){echo "checked";}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasCoffeeMachine">Cafetière</label>
                            </div>
                        </div>
                        <!-- Machine à café dosette -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasPodCoffeeMachine"
                                    name="accomodationHasPodCoffeeMachine"
                                    <?php if(isset($postData['accomodationHasPodCoffeeMachine'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasPodCoffeeMachine">Machine à
                                    café avec dosette</label>
                            </div>
                        </div>
                        <!-- Bouilloire -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasKettle"
                                    name="accomodationHasKettle"
                                    <?php if(isset($postData['accomodationHasKettle'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasKettle">Bouilloire</label>
                            </div>
                        </div>
                        <!-- Grille pain -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasToaster"
                                    name="accomodationHasToaster"
                                    <?php if(isset($postData['accomodationHasToaster'])){echo "checked";}?>>
                                <label class="custom-control-label " for="accomodationHasToaster">Grille pain</label>
                            </div>
                        </div>
                        <!-- Visites autorisées -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="authorizedVisit"
                                    name="authorizedVisit"
                                    <?php if(isset($postData['authorizedVisit'])){echo "checked";}?>>
                                <label class="custom-control-label " for="authorizedVisit">Visites autorisées</label>
                            </div>
                        </div>
                        <!-- Animaux autorisés -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="animalsAllowed"
                                    name="animalsAllowed"
                                    <?php if(isset($postData['animalsAllowed'])){echo "checked";}?>>
                                <label class="custom-control-label " for="animalsAllowed">Animaux autorisés</label>
                            </div>
                        </div>
                        <!-- Fumer autorisé -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="smokingIsAllowed"
                                    name="smokingIsAllowed"
                                    <?php if(isset($postData['smokingIsAllowed'])){echo "checked";}?>>
                                <label class="custom-control-label " for="smokingIsAllowed">Fumer est autorisé</label>
                            </div>
                        </div>
                        <!-- Fêtes autorisées -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="authorizedParty"
                                    name="authorizedParty"
                                    <?php if(isset($postData['authorizedParty'])){echo "checked";}?>>
                                <label class="custom-control-label " for="authorizedParty">Fêtes autorisées</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ---------- CHAMBRE ---------- -->
            <div class="container py-3 px-0 px-md-3 border-bottom border-dark">
                <h2>Chambre</h2>
                <div class="container">
                    <div class="row">
                        <!-- Surface habitable -->
                        <div class="form-group col-lg-4">
                            <label class="font-weight-bold" for="bedroomSize">Surface habitable de la chambre</label>
                            <div id="bedroomSizeDiv" class="input-group">
                                <input id="bedroomSize" type="number" min="1" name="bedroomSize" class="form-control"
                                    placeholder="0" aria-describedby="basic-addon2" value="<?php if(isset($postData)){
                                echo $postData['bedroomSize'];
                            }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m²</span>
                                </div>
                                <?php
                                if (isset($fillingError['bedroomSize'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['bedroomSize'];?></p>
                            <?php } ?>
                            </div>
                        </div>
                        <!-- Type de chambre -->
                        <div class="form-group col-6 col-lg-4">
                            <label for="bedroomType" class="font-weight-bold">Type de chambre</label>
                            <select id="bedroomType" name="bedroomType" class="custom-select">
                                <option value="Simple"
                                    <?php if (isset($postData) && $postData['bedroomType'] == 'Simple'){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Simple</option>
                                <option value="Double"
                                    <?php if (isset($postData) && $postData['bedroomType'] == 'Double'){echo "selected";}?>>
                                    Double</option>
                                <option value="Partagée"
                                    <?php if (isset($postData) && $postData['bedroomType'] == 'Partagée'){echo "selected";}?>>
                                    Partagée</option>
                            </select>
                        </div>
                        <!-- Type de lit -->
                        <div class="form-group col-6 col-lg-4">
                            <label for="bedType" class="font-weight-bold">Type de lit</label>
                            <select id="bedType" name="bedType" class="custom-select">
                                <option value="Simple"
                                    <?php if (isset($postData) && $postData['bedType'] == 'Simple'){echo "selected";}else if(!isset($postData)){echo "selected";}?>>
                                    Simple</option>
                                <option value="Double"
                                    <?php if (isset($postData) && $postData['bedType'] == 'Double'){echo "selected";}?>>
                                    Double</option>
                                <option value="Canapé-lit"
                                    <?php if (isset($postData) && $postData['bedType'] == 'Canapé-lit'){echo "selected";}?>>
                                    Canapé-lit</option>
                            </select>
                        </div>
                    </div>
                    <h3>La chambre comprend:</h3>
                    <div class="row">
                        <!-- Bureau -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasDesk"
                                    name="bedroomHasDesk"
                                    <?php if(isset($postData['bedroomHasDesk'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasDesk">Bureau</label>
                            </div>
                        </div>
                        <!-- Chaise -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasChair"
                                    name="bedroomHasChair"
                                    <?php if(isset($postData['bedroomHasChair'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasChair">Chaise</label>
                            </div>
                        </div>
                        <!-- Tv -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasTv"
                                    name="bedroomHasTv"
                                    <?php if(isset($postData['bedroomHasTv'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasTv">Télévision</label>
                            </div>
                        </div>
                        <!-- Fauteuil -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasArmchair"
                                    name="bedroomHasArmchair"
                                    <?php if(isset($postData['bedroomHasArmchair'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasArmchair">Fauteuil</label>
                            </div>
                        </div>
                        <!-- Table basse -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasCoffeeTable"
                                    name="bedroomHasCoffeeTable"
                                    <?php if(isset($postData['bedroomHasCoffeeTable'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasCoffeeTable">Table basse</label>
                            </div>
                        </div>
                        <!-- Chevet -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasBedside"
                                    name="bedroomHasBedside"
                                    <?php if(isset($postData['bedroomHasBedside'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasBedside">Chevet</label>
                            </div>
                        </div>
                        <!-- Lampe -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasLamp"
                                    name="bedroomHasLamp"
                                    <?php if(isset($postData['bedroomHasLamp'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasLamp">Lampe</label>
                            </div>
                        </div>
                        <!-- Etagères -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasShelf"
                                    name="bedroomHasShelf"
                                    <?php if(isset($postData['bedroomHasShelf'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasShelf">Etagère(s)</label>
                            </div>
                        </div>
                        <!-- Armoire -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasWardrobe"
                                    name="bedroomHasWardrobe"
                                    <?php if(isset($postData['bedroomHasWardrobe'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasWardrobe">Armoire</label>
                            </div>
                        </div>
                        <!-- Penderie -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasCloset"
                                    name="bedroomHasCloset"
                                    <?php if(isset($postData['bedroomHasCloset'])){echo "checked";}?>>
                                <label class="custom-control-label " for="bedroomHasCloset">Penderie</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Photos -->
            <div class="container py-3 px-0 px-md-3 border-bottom border-dark">
                <h2>Photos</h2>
                <div class="container py-3">
                    <p>Sélectionner <span id="nbPicturesAvailable">10</span> photos maximum</p>
                    <div id="inputDiv">
                        <input type="file" onchange="handleFiles(files,id)" id="upload" multiple name="file[]" required>
                    </div>
                    <?php 
                    if (isset($error)) {
                        foreach($error as $key => $value){?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?=$error[$key]?></p><?php }
                    }else if(isset($fillingError['file'])){?>
                            <p class="text-danger font-weight-bold pb-1" type="error" type="error"><?=$fillingError['file']?></p><?php } ?>
                    <div>
                        <span id="preview" class="row"></span>
                    </div>
                </div>
            </div>
            <!-- Bouton submit -->
            <div class="container pt-3 text-center">
                <button id="submitButton" type="submit" class="btn btn-primary col-6 col-sm-4 col-lg-3">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<script src="public/js/redBorder.js"></script>
<script src="public/js/autocompleteAddress.js"></script>
<script src="public/js/spinnerSubmitButton.js"></script>
<script src="public/js/hiddenInput.js"></script>
<script src="public/js/caractersCount.js"></script>
<script src="public/js/energyAdvertisement.js"></script>
<script src="public/js/advertisementUploadFilePreviewOk.js"></script>
<?php
$content = ob_get_clean();
require('view/includes/template.php');