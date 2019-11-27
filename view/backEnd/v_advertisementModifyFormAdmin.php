<?php
$title = "Modifier une annonce";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron px-1 px-md-3">
        <h1 class="pb-3 text-center">
            <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] && $_SESSION['id']!=$userId){echo 'Modifier l\'annonce de '.$advertisementData[0]['user_name'].' '.$advertisementData[0]['user_firstName'].'';}else{echo 'Modifier votre annonce';}?>
        </h1>
        <form method="post" action="index.php?page=saveModificationAdvertisement" enctype="multipart/form-data"
            onsubmit="spinnerSubmitButton()">
            <!-- ----------Annonce---------- -->
            <div class="container py-3 px-0 px-md-3 border-bottom border-dark">
                <?php if (isset($fillingError)){ ?>
                <p class="text-danger font-weight-bold pb-1">Veuillez corriger les erreurs</p> <?php } ?>
                <h2>Annonce</h2>
                <!-- IsActive, Titre, Description -->
                <input type="hidden" name="id" value="<?php if(isset($advertisementData[0]['advertisement_id'])){
                    echo $advertisementData[0]['advertisement_id'];
                }else if (isset($postData['id'])){
                    echo $postData['id'];
                }?>">
                <div class="container">
                    <!-- isActive -->
                    <div class=" custom-control custom-checkbox pb-3">
                        <input type="checkbox" class="custom-control-input" id="isActive" name="isActive" <?php if (isset($advertisementData[0]['advertisement_isActive']) && $advertisementData[0]['advertisement_isActive'] == 1) {
                        echo 'checked';}?>>
                        <label class="custom-control-label font-weight-bold" for="isActive">Activation annonce</label>
                    </div>
                    <!--Titre-->
                    <div class="form-group">
                        <label class="font-weight-bold" for="title">Titre</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Titre de l'annonce"
                            title="Le titre doit être unique si vous avez plusieurs annonces. Soyez précis et concis."
                            maxlength="80" value="<?php
                            if(isset($postData['title'])){
                                echo $postData['title'];}else if (isset($advertisementData[0]['advertisement_title'])){
                                    echo $advertisementData[0]['advertisement_title'];
                                }?>" required>
                        <div class="float-right" id="countTitle"></div>
                        <?php if (isset($fillingError['title'])){?>
                        <p class="text-danger font-weight-bold pb-1" type="error"><?=$fillingError['title']?></p>
                        <?php } ?>
                    </div>
                    <!--Description-->
                    <div class="form-group pb-3">
                        <label class="font-weight-bold" for="description">Description</label>
                        <textarea class="form-control" id="description" rows="6" name="description"
                            placeholder="maximum 2000 charactères" maxlength="2000" required><?php if(isset($postData['description'])){
                                echo $postData['description'];
                            }else if (isset($advertisementData[0]['advertisement_description'])){
                                echo $advertisementData[0]['advertisement_description'];
                            }?></textarea>
                        <div class="float-right" id="countDescription"></div>
                    </div>
                    <!-- Type, catégorie, disponible le, location sans visite -->
                    <div class="row">
                        <!--Type de logement-->
                        <div class="form-group col-6 col-md-4 col-xl-3" title="Sélectionner le type de bien">
                            <label class="font-weight-bold">Type de logement</label>
                            <div class="form-check">
                                <input id="radioType1" class="form-check-input" type="radio" name="type" value="Maison" <?php if ((isset($advertisementData[0]['advertisement_type']) && $advertisementData[0]['advertisement_type'] == 'Maison') || (isset($postData['type']) && $postData['type'] == 'Maison')){
                                    echo 'checked'; }?>>
                                <label class="form-check-label" for="radioType1">Maison</label>
                            </div>
                            <div class="form-check">
                                <input id="radioType2" class="form-check-input" type="radio" name="type"
                                    value="Appartement" <?php if ((isset($advertisementData[0]['advertisement_type']) && $advertisementData[0]['advertisement_type'] == 'Appartement') || (isset($postData['type']) && $postData['type'] == 'Appartement')) {
                                    echo 'checked'; }?>>
                                <label class="form-check-label" for="radioType2">Appartement</label>
                            </div>
                        </div>
                        <!--Catégorie du logement-->
                        <div class="form-group col-6 col-md-4 col-xl-3"
                            title="Sélectionner la catégorie correspondante">
                            <label class="font-weight-bold">Catégorie</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory1" value="Location" <?php if ((isset($advertisementData[0]['advertisement_category']) && $advertisementData[0]['advertisement_category'] == 'Location') || (isset($postData['category']) && $postData['category'] == 'Location')) {
                                    echo 'checked'; }?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory1">Location</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory2" value="Colocation" <?php if ((isset($advertisementData[0]['advertisement_category']) && $advertisementData[0]['advertisement_category'] == 'Colocation') || (isset($postData['category']) && $postData['category'] == 'Colocation')) {
                                    echo 'checked'; }?>>
                                <label class="form-check-label"
                                    for="radioButtonAccomodationCategory2">Colocation</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory3" value="Sous-location" <?php if ((isset($advertisementData[0]['advertisement_category']) && $advertisementData[0]['advertisement_category'] == 'Sous-location') || (isset($postData['category']) && $postData['category'] == 'Sous-location')) {
                                    echo 'checked'; }?>>
                                <label class="form-check-label"
                                    for="radioButtonAccomodationCategory3">Sous-location</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory4" value="Courte-durée" <?php if ((isset($advertisementData[0]['advertisement_category']) && $advertisementData[0]['advertisement_category'] == 'Courte-durée') || (isset($postData['category']) && $postData['category'] == 'Courte-durée')) {
                                    echo 'checked'; }?>>
                                <label class="form-check-label"
                                    for="radioButtonAccomodationCategory4">Courte-durée</label>
                            </div>
                        </div>
                        <!-- Disponible le -->
                        <div class="form-group col-md-4 col-xl-3"
                            title="Donner la date à laquelle le locataire pourra entrer">
                            <label for="availableDate" class="font-weight-bold">Disponible le</label>
                            <input class="form-control" type="date" id="availableDate" name="availableDate" value="<?php if(isset($postData['availableDate'])){
                                    echo $postData['availableDate'];
                                }else if (isset($advertisementData[0]['advertisement_availableDate'])){
                                    echo $advertisementData[0]['advertisement_availableDate'];
                                }?>" required>
                        </div>
                        <!-- Location sans visite + meublé -->
                        <div class="form-group col-md-6 col-xl-3">
                            <!-- Meublé -->
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="isFurnished" name="isFurnished" <?php if ((isset($advertisementData[0]['advertisement_isFurnished']) && $advertisementData[0]['advertisement_isFurnished']) || isset($postData['isFurnished'])) {
                                    echo 'checked'; }?>>
                                <label class="custom-control-label font-weight-bold" for="isFurnished">Meublé</label>
                            </div>
                            <!-- Location sans visite -->
                            <div class="custom-control custom-checkbox"
                                title="J'accepte le dossier d'un candidat qui n'a pas visité">
                                <input type="checkbox" class="custom-control-input" id="rentWithoutVisit"
                                    name="rentWithoutVisit" <?php if ((isset($advertisementData[0]['advertisement_rentWithoutVisit']) && $advertisementData[0]['advertisement_rentWithoutVisit']) || isset($postData['rentWithoutVisit'])) {
                                    echo 'checked'; }?>>
                                <label class="custom-control-label font-weight-bold" for="rentWithoutVisit">Location
                                    sans visite</label>
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
                                placeholder="Nom" value="<?php if (isset($postData['contactNameForVisit'])){
                                    echo $postData['contactNameForVisit'];
                                }else if (isset($advertisementData[0]['advertisement_contactNameForVisit'])){
                                    echo $advertisementData[0]['advertisement_contactNameForVisit'];
                                }?>" maxlength="125" required>
                            <?php
                                if (isset($fillingError['contactNameForVisit'])) {?>
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
                                class="form-control" placeholder="Téléphone" value="<?php if (isset($postData['contactPhoneNumberForVisit'])){
                                    echo $postData['contactPhoneNumberForVisit'];
                                }else if (isset($advertisementData[0]['advertisement_contactPhoneNumberForVisit'])){
                                    echo $advertisementData[0]['advertisement_contactPhoneNumberForVisit'];
                                }?>" maxlength="20" required>
                            <?php
                                if (isset($fillingError['contactPhoneNumberForVisit'])) {?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['contactPhoneNumberForVisit'];?></p>
                            <?php } ?>
                        </div>
                        <!-- Mail du contact pour les visites -->
                        <div class="form-group col-lg-12 col-xl-4">
                            <label for="contactMailForVisit" class="font-weight-bold">Mail du contact pour les
                                visites</label>
                            <input id="contactMailForVisit" type="email" name="contactMailForVisit" class="form-control"
                                placeholder="Mail" value="<?php if (isset($postData['contactMailForVisit'])){
                                    echo $postData['contactMailForVisit'];
                                }else if (isset($advertisementData[0]['advertisement_contactMailForVisit'])){
                                    echo $advertisementData[0]['advertisement_contactMailForVisit'];
                                }?>" maxlength="255" required>
                            <?php
                                if (isset($fillingError['contactMailForVisit'])) {?>
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
                                <option value="Propriétaire" <?php if ((isset($advertisementData[0]['advertisement_renterSituation']) && $advertisementData[0]['advertisement_renterSituation'] == "Propriétaire") || (isset($postData['renterSituation']) && $postData['renterSituation'] == "Propriétaire")) {
                                echo 'selected';
                            }?>>Propriétaire</option>
                                <option value="Locataire" <?php if ((isset($advertisementData[0]['advertisement_renterSituation']) && $advertisementData[0]['advertisement_renterSituation'] == "Locataire") || (isset($postData['renterSituation']) && $postData['renterSituation'] == "Locataire")) {
                                echo 'selected';
                            }?>>Locataire</option>
                            </select>
                        </div>
                        <!-- Durée minimum de séjour -->
                        <div class="form-group col-md-6 col-xl-4">
                            <label for="locationMinDuration" class="font-weight-bold">Durée minimum de
                                séjour</label>
                            <select id="locationMinDuration" name="locationMinDuration" class="custom-select">
                                <option value="1 mois" <?php if ((isset($advertisementData[0]['advertisement_locationMinDuration']) && $advertisementData[0]['advertisement_locationMinDuration'] == "1 mois") || (isset($postData['locationMinDuration']) && $postData['locationMinDuration'] == "1 mois")) {
                                echo 'selected';
                            }?>>1 mois</option>
                                <option value="3 mois" <?php if ((isset($advertisementData[0]['advertisement_locationMinDuration']) && $advertisementData[0]['advertisement_locationMinDuration'] == "3 mois") || (isset($postData['locationMinDuration']) && $postData['locationMinDuration'] == "3 mois")) {
                                echo 'selected';
                            }?>>3 mois</option>
                                <option value="6 mois" <?php if ((isset($advertisementData[0]['advertisement_locationMinDuration']) && $advertisementData[0]['advertisement_locationMinDuration'] == "6 mois") || (isset($postData['locationMinDuration']) && $postData['locationMinDuration'] == "6 mois")) {
                                echo 'selected';
                            }?>>6 mois</option>
                                <option value="9 mois" <?php if ((isset($advertisementData[0]['advertisement_locationMinDuration']) && $advertisementData[0]['advertisement_locationMinDuration'] == "9 mois") || (isset($postData['locationMinDuration']) && $postData['locationMinDuration'] == "9 mois")) {
                                echo 'selected';
                            }?>>9 mois</option>
                                <option value="12 mois" <?php if ((isset($advertisementData[0]['advertisement_locationMinDuration']) && $advertisementData[0]['advertisement_locationMinDuration'] == "12 mois") || (isset($postData['locationMinDuration']) && $postData['locationMinDuration'] == "12 mois")) {
                                echo 'selected';
                            }?>>12 mois</option>
                            </select>
                        </div>
                        <!-- Nombre de colocataires déja présent -->
                        <div class="form-group col-lg-6 col-xl-4">
                            <label class="font-weight-bold" for="nbOfOtherRoommatePresent">Nombre de colocataire(s) déjà
                                présent(s)</label>
                            <select id="nbOfOtherRoommatePresent" name="nbOfOtherRoommatePresent" class="custom-select">
                                <option value="0" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "0") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "0")) {
                                echo 'selected';
                            }?>>0</option>
                                <option value="1" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "1") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "1")) {
                                echo 'selected';
                            }?>>1</option>
                                <option value="2" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "2") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "2")) {
                                echo 'selected';
                            }?>>2</option>
                                <option value="3" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "3") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "3")) {
                                echo 'selected';
                            }?>>3</option>
                                <option value="4" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "4") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "4")) {
                                echo 'selected';
                            }?>>4</option>
                                <option value="5" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "5") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "5")) {
                                echo 'selected';
                            }?>>5</option>
                                <option value="6" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "6") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "6")) {
                                echo 'selected';
                            }?>>6</option>
                                <option value="7" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "7") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "7")) {
                                echo 'selected';
                            }?>>7</option>
                                <option value="8" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "8") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "8")) {
                                echo 'selected';
                            }?>>8</option>
                                <option value="9" <?php if ((isset($advertisementData[0]['advertisement_nbOfOtherRoommatePresent']) && $advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "9") || (isset($_POST['nbOfOtherRoommatePresent']) && $_POST['nbOfOtherRoommatePresent'] == "9")) {
                                echo 'selected';
                            }?>>9</option>
                            </select>
                        </div>
                    </div>
                    <!-- Sex colocataires déja présents -->
                    <div class="row">
                        <div class="form-group col-lg-6 offset-xl-8 col-xl-4" id="otherRoommateSex">
                            <label for="roommateSex" class="font-weight-bold">Colocataire(s) déja présent(s)
                                (sexe)</label>
                            <select id="roommateSex" name="roommateSex" class="custom-select">
                                <option id="otherRoommateSexWomenValue" value="Femme" <?php if ((isset($advertisementData[0]['advertisement_otherRoommateSex']) && $advertisementData[0]['advertisement_otherRoommateSex'] == "Femme") || (isset($postData['otherRoommateSex']) && $postData['otherRoommateSex'] == "Femme")) {
                                echo 'selected';
                            }?>>Femme</option>
                                <option id="otherRoommateSexMenValue" value="Homme" <?php if ((isset($advertisementData[0]['advertisement_otherRoommateSex']) && $advertisementData[0]['advertisement_otherRoommateSex'] == "Homme") || (isset($postData['otherRoommateSex']) && $postData['otherRoommateSex'] == "Homme"))  {
                                echo 'selected';
                            }?>>Homme</option>
                                <option id="otherRoommateSexMixteValue" value="Mixte" <?php if ((isset($advertisementData[0]['advertisement_otherRoommateSex']) && $advertisementData[0]['advertisement_otherRoommateSex'] == "Mixte") || (isset($postData['otherRoommateSex']) && $postData['otherRoommateSex'] == "Mixte"))  {
                                echo 'selected';
                            }?>>Mixte</option>
                                <option id="otherRoommateSexNullValue" value="null" <?php if ((isset($advertisementData[0]['advertisement_otherRoommateSex']) && $advertisementData[0]['advertisement_otherRoommateSex'] == "null") || (isset($postData['otherRoommateSex']) && $postData['otherRoommateSex'] == "null"))  {
                                echo 'selected';
                            }?>>Null</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Colocataire idéal (sexe) -->
                        <div class="form-group col-md-6 col-xl-4">
                            <label for="idealRoommateSex" class="font-weight-bold">Colocataire idéal
                                (sexe)</label>
                            <select id="idealRoommateSex" name="idealRoommateSex" class="custom-select">
                                <option value="PeuImporte" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateSex']) && $advertisementData[0]['advertisement_idealRoommateSex'] == "PeuImporte") || (isset($postData['idealRoommateSex']) && $postData['idealRoommateSex'] == "PeuImporte")) {
                                echo 'selected';
                            }?>>Peu importe</option>
                                <option value="Femme" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateSex']) && $advertisementData[0]['advertisement_idealRoommateSex'] == "Femme") || (isset($postData['idealRoommateSex']) && $postData['idealRoommateSex'] == "Femme")) {
                                echo 'selected';
                            }?>>Femme</option>
                                <option value="Homme" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateSex']) && $advertisementData[0]['advertisement_idealRoommateSex'] == "Homme") || (isset($postData['idealRoommateSex']) && $postData['idealRoommateSex'] == "Homme")) {
                                echo 'selected';
                            }?>>Homme</option>
                            </select>
                        </div>
                        <!-- Colocataire idéal (situation) -->
                        <div class="form-group col-md-6 col-xl-4">
                            <label for="idealRoommateSituation" class="font-weight-bold">Colocataire idéal
                                (situation)</label>
                            <select id="idealRoommateSituation" name="idealRoommateSituation" class="custom-select">
                                <option value="PeuImporte" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateSituation']) && $advertisementData[0]['advertisement_idealRoommateSituation'] == "PeuImporte") || (isset($postData['idealRoommateSituation']) && $postData['idealRoommateSituation'] == "PeuImporte"))  {
                                echo 'selected';
                            }?>>Peu importe</option>
                                <option value="Etudiant" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateSituation']) && $advertisementData[0]['advertisement_idealRoommateSituation'] == "Etudiant") || (isset($postData['idealRoommateSituation']) && $postData['idealRoommateSituation'] == "Etudiant")) {
                                echo 'selected';
                            }?>>Etudiant(e)</option>
                                <option value="Salarié" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateSituation']) && $advertisementData[0]['advertisement_idealRoommateSituation'] == "Salarié") || (isset($postData['idealRoommateSituation']) && $postData['idealRoommateSituation'] == "Salarié")) {
                                echo 'selected';
                            }?>>Salarié(e)</option>
                            </select>
                        </div>
                        <!-- Age minimum -->
                        <div class="form-group col-6 col-xl-2">
                            <label class="font-weight-bold" for="idealRoommateMinAge">Age minimum</label>
                            <select id="idealRoommateMinAge" name="idealRoommateMinAge" class="custom-select">
                                <option value="18" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "18") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "18")) {
                                echo 'selected';
                            }?>>18</option>
                                <option value="19" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "19") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "19")) {
                                echo 'selected';
                            }?>>19</option>
                                <option value="20" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "20") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "20")) {
                                echo 'selected';
                            }?>>20</option>
                                <option value="21" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "21") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "21")) {
                                echo 'selected';
                            }?>>21</option>
                                <option value="22" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "22") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "22")) {
                                echo 'selected';
                            }?>>22</option>
                                <option value="23" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "23") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "23")) {
                                echo 'selected';
                            }?>>23</option>
                                <option value="24" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "24") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "24")) {
                                echo 'selected';
                            }?>>24</option>
                                <option value="25" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "25") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "25")) {
                                echo 'selected';
                            }?>>25</option>
                                <option value="26" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "26") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "26")) {
                                echo 'selected';
                            }?>>26</option>
                                <option value="27" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "27") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "27")) {
                                echo 'selected';
                            }?>>27</option>
                                <option value="28" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "28") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "28")) {
                                echo 'selected';
                            }?>>28</option>
                                <option value="29" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "29") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "29")) {
                                echo 'selected';
                            }?>>29</option>
                                <option value="30" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "30") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "30")) {
                                echo 'selected';
                            }?>>30</option>
                                <option value="31" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "31") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "31")) {
                                echo 'selected';
                            }?>>31</option>
                                <option value="32" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "32") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "32")) {
                                echo 'selected';
                            }?>>32</option>
                                <option value="33" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "33") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "33")) {
                                echo 'selected';
                            }?>>33</option>
                                <option value="34" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "34") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "34")) {
                                echo 'selected';
                            }?>>34</option>
                                <option value="35" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "35") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "35")) {
                                echo 'selected';
                            }?>>35</option>
                                <option value="36" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "36") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "36")) {
                                echo 'selected';
                            }?>>36</option>
                                <option value="37" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "37") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "37")) {
                                echo 'selected';
                            }?>>37</option>
                                <option value="38" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "38") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "38")) {
                                echo 'selected';
                            }?>>38</option>
                                <option value="39" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "39") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "39")) {
                                echo 'selected';
                            }?>>39</option>
                                <option value="40" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "40") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "40")) {
                                echo 'selected';
                            }?>>40</option>
                                <option value="41" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "41") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "41")) {
                                echo 'selected';
                            }?>>41</option>
                                <option value="42" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "42") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "42")) {
                                echo 'selected';
                            }?>>42</option>
                                <option value="43" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "43") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "43")) {
                                echo 'selected';
                            }?>>43</option>
                                <option value="44" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "44") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "44")) {
                                echo 'selected';
                            }?>>44</option>
                                <option value="45" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "45") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "45")) {
                                echo 'selected';
                            }?>>45</option>
                                <option value="46" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "46") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "46")) {
                                echo 'selected';
                            }?>>46</option>
                                <option value="47" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "47") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "47")) {
                                echo 'selected';
                            }?>>47</option>
                                <option value="48" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "48") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "48")) {
                                echo 'selected';
                            }?>>48</option>
                                <option value="49" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "49") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "49")) {
                                echo 'selected';
                            }?>>49</option>
                                <option value="50" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "50") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "50")) {
                                echo 'selected';
                            }?>>50</option>
                                <option value="51" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "51") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "51")) {
                                echo 'selected';
                            }?>>51</option>
                                <option value="52" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "52") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "52")) {
                                echo 'selected';
                            }?>>52</option>
                                <option value="53" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "53") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "53")) {
                                echo 'selected';
                            }?>>53</option>
                                <option value="54" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "54") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "54")) {
                                echo 'selected';
                            }?>>54</option>
                                <option value="55" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "55") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "55")) {
                                echo 'selected';
                            }?>>55</option>
                                <option value="56" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "56") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "56")) {
                                echo 'selected';
                            }?>>56</option>
                                <option value="57" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "57") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "57")) {
                                echo 'selected';
                            }?>>57</option>
                                <option value="58" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "58") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "58")) {
                                echo 'selected';
                            }?>>58</option>
                                <option value="59" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "59") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "59")) {
                                echo 'selected';
                            }?>>59</option>
                                <option value="60" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "60") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "60")) {
                                echo 'selected';
                            }?>>60</option>
                                <option value="61" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "61") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "61")) {
                                echo 'selected';
                            }?>>61</option>
                                <option value="62" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "62") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "62")) {
                                echo 'selected';
                            }?>>62</option>
                                <option value="63" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "63") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "63")) {
                                echo 'selected';
                            }?>>63</option>
                                <option value="64" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "64") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "64")) {
                                echo 'selected';
                            }?>>64</option>
                                <option value="65" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "65") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "65")) {
                                echo 'selected';
                            }?>>65</option>
                                <option value="66" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "66") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "66")) {
                                echo 'selected';
                            }?>>66</option>
                                <option value="67" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "67") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "67")) {
                                echo 'selected';
                            }?>>67</option>
                                <option value="68" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "68") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "68")) {
                                echo 'selected';
                            }?>>68</option>
                                <option value="69" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "69") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "69")) {
                                echo 'selected';
                            }?>>69</option>
                                <option value="70" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "70") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "70")) {
                                echo 'selected';
                            }?>>70</option>
                                <option value="71" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "71") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "71")) {
                                echo 'selected';
                            }?>>71</option>
                                <option value="72" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "72") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "72")) {
                                echo 'selected';
                            }?>>72</option>
                                <option value="73" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "73") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "73")) {
                                echo 'selected';
                            }?>>73</option>
                                <option value="74" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "74") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "74")) {
                                echo 'selected';
                            }?>>74</option>
                                <option value="75" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "75") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "75")) {
                                echo 'selected';
                            }?>>75</option>
                                <option value="76" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "76") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "76")) {
                                echo 'selected';
                            }?>>76</option>
                                <option value="77" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "77") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "77")) {
                                echo 'selected';
                            }?>>77</option>
                                <option value="78" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "78") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "78")) {
                                echo 'selected';
                            }?>>78</option>
                                <option value="79" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "79") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "79")) {
                                echo 'selected';
                            }?>>79</option>
                                <option value="80" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "80") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "80")) {
                                echo 'selected';
                            }?>>80</option>
                                <option value="81" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "81") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "81")) {
                                echo 'selected';
                            }?>>81</option>
                                <option value="82" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "82") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "82")) {
                                echo 'selected';
                            }?>>82</option>
                                <option value="83" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "83") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "83")) {
                                echo 'selected';
                            }?>>83</option>
                                <option value="84" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "84") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "84")) {
                                echo 'selected';
                            }?>>84</option>
                                <option value="85" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "85") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "85")) {
                                echo 'selected';
                            }?>>85</option>
                                <option value="86" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "86") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "86")) {
                                echo 'selected';
                            }?>>86</option>
                                <option value="87" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "87") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "87")) {
                                echo 'selected';
                            }?>>87</option>
                                <option value="88" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "88") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "88")) {
                                echo 'selected';
                            }?>>88</option>
                                <option value="89" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "89") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "89")) {
                                echo 'selected';
                            }?>>89</option>
                                <option value="90" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "90") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "90")) {
                                echo 'selected';
                            }?>>90</option>
                                <option value="91" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "91") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "91")) {
                                echo 'selected';
                            }?>>91</option>
                                <option value="92" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "92") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "92")) {
                                echo 'selected';
                            }?>>92</option>
                                <option value="93" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "93") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "93")) {
                                echo 'selected';
                            }?>>93</option>
                                <option value="94" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "94") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "94")) {
                                echo 'selected';
                            }?>>94</option>
                                <option value="95" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "95") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "95")) {
                                echo 'selected';
                            }?>>95</option>
                                <option value="96" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "96") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "96")) {
                                echo 'selected';
                            }?>>96</option>
                                <option value="97" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "97") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "97")) {
                                echo 'selected';
                            }?>>97</option>
                                <option value="98" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "98") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "98")) {
                                echo 'selected';
                            }?>>98</option>
                                <option value="99" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMinAge']) && $advertisementData[0]['advertisement_idealRoommateMinAge'] == "99") || (isset($postData['idealRoommateMinAge']) && $postData['idealRoommateMinAge'] == "99")) {
                                echo 'selected';
                            }?>>99</option>
                            </select>
                        </div>
                        <!-- Age maximum -->
                        <div class="form-group col-6 col-xl-2">
                            <label class="font-weight-bold" for="idealRoommateMaxAge">Age maximum</label>
                            <select id="idealRoommateMaxAge" name="idealRoommateMaxAge" class="custom-select">
                                <option value="18" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "18") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "18")) {
                                echo 'selected';
                            }?>>18</option>
                                <option value="19" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "19") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "19")) {
                                echo 'selected';
                            }?>>19</option>
                                <option value="20" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "20") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "20")) {
                                echo 'selected';
                            }?>>20</option>
                                <option value="21" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "21") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "21")) {
                                echo 'selected';
                            }?>>21</option>
                                <option value="22" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "22") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "22")) {
                                echo 'selected';
                            }?>>22</option>
                                <option value="23" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "23") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "23")) {
                                echo 'selected';
                            }?>>23</option>
                                <option value="24" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "24") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "24")) {
                                echo 'selected';
                            }?>>24</option>
                                <option value="25" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "25") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "25")) {
                                echo 'selected';
                            }?>>25</option>
                                <option value="26" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "26") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "26")) {
                                echo 'selected';
                            }?>>26</option>
                                <option value="27" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "27") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "27")) {
                                echo 'selected';
                            }?>>27</option>
                                <option value="28" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "28") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "28")) {
                                echo 'selected';
                            }?>>28</option>
                                <option value="29" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "29") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "29")) {
                                echo 'selected';
                            }?>>29</option>
                                <option value="30" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "30") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "30")) {
                                echo 'selected';
                            }?>>30</option>
                                <option value="31" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "31") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "31")) {
                                echo 'selected';
                            }?>>31</option>
                                <option value="32" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "32") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "32")) {
                                echo 'selected';
                            }?>>32</option>
                                <option value="33" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "33") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "33")) {
                                echo 'selected';
                            }?>>33</option>
                                <option value="34" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "34") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "34")) {
                                echo 'selected';
                            }?>>34</option>
                                <option value="35" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "35") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "35")) {
                                echo 'selected';
                            }?>>35</option>
                                <option value="36" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "36") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "36")) {
                                echo 'selected';
                            }?>>36</option>
                                <option value="37" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "37") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "37")) {
                                echo 'selected';
                            }?>>37</option>
                                <option value="38" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "38") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "38")) {
                                echo 'selected';
                            }?>>38</option>
                                <option value="39" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "39") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "39")) {
                                echo 'selected';
                            }?>>39</option>
                                <option value="40" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "40") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "40")) {
                                echo 'selected';
                            }?>>40</option>
                                <option value="41" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "41") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "41")) {
                                echo 'selected';
                            }?>>41</option>
                                <option value="42" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "42") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "42")) {
                                echo 'selected';
                            }?>>42</option>
                                <option value="43" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "43") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "43")) {
                                echo 'selected';
                            }?>>43</option>
                                <option value="44" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "44") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "44")) {
                                echo 'selected';
                            }?>>44</option>
                                <option value="45" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "45") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "45")) {
                                echo 'selected';
                            }?>>45</option>
                                <option value="46" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "46") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "46")) {
                                echo 'selected';
                            }?>>46</option>
                                <option value="47" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "47") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "47")) {
                                echo 'selected';
                            }?>>47</option>
                                <option value="48" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "48") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "48")) {
                                echo 'selected';
                            }?>>48</option>
                                <option value="49" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "49") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "49")) {
                                echo 'selected';
                            }?>>49</option>
                                <option value="50" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "50") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "50")) {
                                echo 'selected';
                            }?>>50</option>
                                <option value="51" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "51") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "51")) {
                                echo 'selected';
                            }?>>51</option>
                                <option value="52" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "52") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "52")) {
                                echo 'selected';
                            }?>>52</option>
                                <option value="53" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "53") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "53")) {
                                echo 'selected';
                            }?>>53</option>
                                <option value="54" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "54") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "54")) {
                                echo 'selected';
                            }?>>54</option>
                                <option value="55" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "55") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "55")) {
                                echo 'selected';
                            }?>>55</option>
                                <option value="56" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "56") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "56")) {
                                echo 'selected';
                            }?>>56</option>
                                <option value="57" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "57") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "57")) {
                                echo 'selected';
                            }?>>57</option>
                                <option value="58" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "58") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "58")) {
                                echo 'selected';
                            }?>>58</option>
                                <option value="59" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "59") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "59")) {
                                echo 'selected';
                            }?>>59</option>
                                <option value="60" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "60") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "60")) {
                                echo 'selected';
                            }?>>60</option>
                                <option value="61" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "61") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "61")) {
                                echo 'selected';
                            }?>>61</option>
                                <option value="62" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "62") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "62")) {
                                echo 'selected';
                            }?>>62</option>
                                <option value="63" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "63") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "63")) {
                                echo 'selected';
                            }?>>63</option>
                                <option value="64" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "64") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "64")) {
                                echo 'selected';
                            }?>>64</option>
                                <option value="65" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "65") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "65")) {
                                echo 'selected';
                            }?>>65</option>
                                <option value="66" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "66") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "66")) {
                                echo 'selected';
                            }?>>66</option>
                                <option value="67" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "67") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "67")) {
                                echo 'selected';
                            }?>>67</option>
                                <option value="68" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "68") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "68")) {
                                echo 'selected';
                            }?>>68</option>
                                <option value="69" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "69") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "69")) {
                                echo 'selected';
                            }?>>69</option>
                                <option value="70" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "70") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "70")) {
                                echo 'selected';
                            }?>>70</option>
                                <option value="71" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "71") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "71")) {
                                echo 'selected';
                            }?>>71</option>
                                <option value="72" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "72") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "72")) {
                                echo 'selected';
                            }?>>72</option>
                                <option value="73" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "73") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "73")) {
                                echo 'selected';
                            }?>>73</option>
                                <option value="74" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "74") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "74")) {
                                echo 'selected';
                            }?>>74</option>
                                <option value="75" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "75") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "75")) {
                                echo 'selected';
                            }?>>75</option>
                                <option value="76" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "76") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "76")) {
                                echo 'selected';
                            }?>>76</option>
                                <option value="77" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "77") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "77")) {
                                echo 'selected';
                            }?>>77</option>
                                <option value="78" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "78") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "78")) {
                                echo 'selected';
                            }?>>78</option>
                                <option value="79" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "79") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "79")) {
                                echo 'selected';
                            }?>>79</option>
                                <option value="80" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "80") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "80")) {
                                echo 'selected';
                            }?>>80</option>
                                <option value="81" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "81") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "81")) {
                                echo 'selected';
                            }?>>81</option>
                                <option value="82" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "82") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "82")) {
                                echo 'selected';
                            }?>>82</option>
                                <option value="83" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "83") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "83")) {
                                echo 'selected';
                            }?>>83</option>
                                <option value="84" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "84") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "84")) {
                                echo 'selected';
                            }?>>84</option>
                                <option value="85" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "85") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "85")) {
                                echo 'selected';
                            }?>>85</option>
                                <option value="86" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "86") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "86")) {
                                echo 'selected';
                            }?>>86</option>
                                <option value="87" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "87") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "87")) {
                                echo 'selected';
                            }?>>87</option>
                                <option value="88" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "88") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "88")) {
                                echo 'selected';
                            }?>>88</option>
                                <option value="89" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "89") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "89")) {
                                echo 'selected';
                            }?>>89</option>
                                <option value="90" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "90") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "90")) {
                                echo 'selected';
                            }?>>90</option>
                                <option value="91" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "91") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "91")) {
                                echo 'selected';
                            }?>>91</option>
                                <option value="92" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "92") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "92")) {
                                echo 'selected';
                            }?>>92</option>
                                <option value="93" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "93") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "93")) {
                                echo 'selected';
                            }?>>93</option>
                                <option value="94" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "94") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "94")) {
                                echo 'selected';
                            }?>>94</option>
                                <option value="95" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "95") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "95")) {
                                echo 'selected';
                            }?>>95</option>
                                <option value="96" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "96") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "96")) {
                                echo 'selected';
                            }?>>96</option>
                                <option value="97" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "97") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "97")) {
                                echo 'selected';
                            }?>>97</option>
                                <option value="98" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "98") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "98")) {
                                echo 'selected';
                            }?>>98</option>
                                <option value="99" <?php if ((isset($advertisementData[0]['advertisement_idealRoommateMaxAge']) && $advertisementData[0]['advertisement_idealRoommateMaxAge'] == "99") || (isset($postData['idealRoommateMaxAge']) && $postData['idealRoommateMaxAge'] == "99")) {
                                echo 'selected';
                            }?>>99</option>
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
                                    aria-describedby="basic-addon2" value="<?php if (isset($advertisementData[0]['advertisement_monthlyRentExcludingCharges'])){
                                        echo $advertisementData[0]['advertisement_monthlyRentExcludingCharges'];
                                    }else if (isset($postData['monthlyRentExcludingCharges'])){
                                        echo $postData['monthlyRentExcludingCharges'];} ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                                <?php
                                if (isset($fillingError['monthlyRentExcludingCharges'])) {?>
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
                                    aria-describedby="basic-addon2" value="<?php if (isset($advertisementData[0]['advertisement_charges'])){
                                        echo $advertisementData[0]['advertisement_charges'];
                                    }else if (isset($postData['charges'])){
                                        echo $postData['charges'];} ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                                <?php
                                if (isset($fillingError['charges'])) {?>
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
                                    aria-describedby="basic-addon2" value="<?php if (isset($advertisementData[0]['advertisement_suretyBond'])){
                                        echo $advertisementData[0]['advertisement_suretyBond'];
                                    }else if (isset($postData['suretyBond'])){
                                        echo $postData['suretyBond'];} ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                                <?php
                                if (isset($fillingError['suretyBond'])) {?>
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
                                <option value="France" <?php if ((isset($advertisementData[0]['advertisement_guarantorLiving']) && $advertisementData[0]['advertisement_guarantorLiving'] == "France") || (isset($postData['guarantorLiving']) && $postData['guarantorLiving'] == "France")) {
                                echo 'selected';
                            }?>>
                                    France</option>
                                <option value="Europe" <?php if ((isset($advertisementData[0]['advertisement_guarantorLiving']) && $advertisementData[0]['advertisement_guarantorLiving'] == "Europe") || (isset($postData['guarantorLiving']) && $postData['guarantorLiving'] == "Europe")) {
                                echo 'selected';
                            }?>>
                                    Europe</option>
                                <option value="PeuImporte" <?php if ((isset($advertisementData[0]['advertisement_guarantorLiving']) && $advertisementData[0]['advertisement_guarantorLiving'] == "PeuImporte") || (isset($postData['guarantorLiving']) && $postData['guarantorLiving'] == "PeuImporte")) {
                                echo 'selected';
                            }?>>
                                    Peu importe</option>
                            </select>
                        </div>
                        <!-- Ratio de solvabilité -->
                        <div class="form-group col-md-6 col-lg-4"
                            title="A combien de loyers le revenu doit-il être supérieur?">
                            <label for="solvencyRatio" class="font-weight-bold">Ratio de solvabilité</label>
                            <select id="solvencyRatio" name="solvencyRatio" class="custom-select">
                                <option value="PeuImporte" selected>Peu importe</option>
                                <option value="1X" <?php if ((isset($advertisementData[0]['advertisement_solvencyRatio']) && $advertisementData[0]['advertisement_solvencyRatio'] == "1X") || (isset($postData['solvencyRatio']) && $postData['solvencyRatio'] == "1X")){
                                echo 'selected';
                            }?>>
                                    1X</option>
                                <option value="1.5X" <?php if ((isset($advertisementData[0]['advertisement_solvencyRatio']) && $advertisementData[0]['advertisement_solvencyRatio'] == "1.5X") || (isset($postData['solvencyRatio']) && $postData['solvencyRatio'] == "1.5X")){
                                echo 'selected';
                            }?>>
                                    1.5X</option>
                                <option value="2X" <?php if ((isset($advertisementData[0]['advertisement_solvencyRatio']) && $advertisementData[0]['advertisement_solvencyRatio'] == "2X") || (isset($postData['solvencyRatio']) && $postData['solvencyRatio'] == "2X")){
                                echo 'selected';
                            }?>>
                                    2X</option>
                                <option value="2.5X" <?php if ((isset($advertisementData[0]['advertisement_solvencyRatio']) && $advertisementData[0]['advertisement_solvencyRatio'] == "2.5X") || (isset($postData['solvencyRatio']) && $postData['solvencyRatio'] == "2.5X")){
                                echo 'selected';
                            }?>>
                                    2.5X</option>
                                <option value="3X" <?php if ((isset($advertisementData[0]['advertisement_solvencyRatio']) && $advertisementData[0]['advertisement_solvencyRatio'] == "3X") || (isset($postData['solvencyRatio']) && $postData['solvencyRatio'] == "3X")){
                                echo 'selected';
                            }?>>
                                    3X</option>
                                <option value="4X" <?php if ((isset($advertisementData[0]['advertisement_solvencyRatio']) && $advertisementData[0]['advertisement_solvencyRatio'] == "4X") || (isset($postData['solvencyRatio']) && $postData['solvencyRatio'] == "4X")){
                                echo 'selected';
                            }?>>
                                    4X</option>
                                <option value="5X" <?php if ((isset($advertisementData[0]['advertisement_solvencyRatio']) && $advertisementData[0]['advertisement_solvencyRatio'] == "5X") || (isset($postData['solvencyRatio']) && $postData['solvencyRatio'] == "5X")){
                                echo 'selected';
                            }?>>
                                    5X</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pt-md-2">
                        <!-- Exigences financières -->
                        <div class="form-group col-sm-6 col-lg-4"
                            title="J'ai des exigences financières pour le candidat">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="financialRequirements"
                                    name="financialRequirements" <?php if ((isset($advertisementData[0]['advertisement_financialRequirements']) && $advertisementData[0]['advertisement_financialRequirements']) || isset($postData['financialRequirements'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label font-weight-bold"
                                    for="financialRequirements">Exigences financières</label>
                            </div>
                        </div>
                        <!-- Eligible aux aides -->
                        <div class="form-group col-sm-6 col-lg-4">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="eligibleForAids"
                                    name="eligibleForAids" <?php if ((isset($advertisementData[0]['advertisement_eligibleForAids']) && $advertisementData[0]['advertisement_eligibleForAids']) || isset($postData['eligibleForAids'])) {
                                echo 'checked';
                            }?>>
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
                                    name="chargesIncludeElectricity" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeElectricity']) && $advertisementData[0]['advertisement_chargesIncludeElectricity']) || isset($postData['advertisement_chargesIncludeElectricity'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label" for="chargesIncludeElectricity">Electricité</label>
                            </div>
                        </div>
                        <!-- Eau chaude -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHotWater"
                                    name="chargesIncludeHotWater" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeHotWater']) && $advertisementData[0]['advertisement_chargesIncludeHotWater']) || isset($postData['advertisement_chargesIncludeHotWater'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label" for="chargesIncludeHotWater">Eau
                                    chaude</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHeating"
                                    name="chargesIncludeHeating" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeHeating']) && $advertisementData[0]['advertisement_chargesIncludeHeating']) || isset($postData['advertisement_chargesIncludeHeating'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label" for="chargesIncludeHeating">Chauffage</label>
                            </div>
                        </div>
                        <!-- Internet -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeInternet"
                                    name="chargesIncludeInternet" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeInternet']) && $advertisementData[0]['advertisement_chargesIncludeInternet']) || isset($postData['advertisement_chargesIncludeInternet'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label" for="chargesIncludeInternet">Internet</label>
                            </div>
                        </div>
                        <!-- Charges de co-propriété -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="chargesIncludeCoOwnershipCharges" name="chargesIncludeCoOwnershipCharges" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeCoOwnershipCharges']) && $advertisementData[0]['advertisement_chargesIncludeCoOwnershipCharges']) || isset($postData['advertisement_chargesIncludeCoOwnershipCharges'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label" for="chargesIncludeCoOwnershipCharges">Charges de
                                    co-propriété</label>
                            </div>
                        </div>
                        <!-- Assurance habitation -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHomeInsurance"
                                    name="chargesIncludeHomeInsurance" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeHomeInsurance']) && $advertisementData[0]['advertisement_chargesIncludeHomeInsurance']) || isset($postData['advertisement_chargesIncludeHomeInsurance'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label" for="chargesIncludeHomeInsurance">Assurance
                                    habitation</label>
                            </div>
                        </div>
                        <!-- Révision chaudière -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeBoilerInspection"
                                    name="chargesIncludeBoilerInspection" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeBoilerInspection']) && $advertisementData[0]['advertisement_chargesIncludeBoilerInspection']) || isset($postData['advertisement_chargesIncludeBoilerInspection'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label" for="chargesIncludeBoilerInspection">Révision
                                    chaudière</label>
                            </div>
                        </div>
                        <!-- Taxe d'ordures ménagères -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="chargesIncludeHouseholdGarbageTaxes" name="chargesIncludeHouseholdGarbageTaxes" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeHouseholdGarbageTaxes']) && $advertisementData[0]['advertisement_chargesIncludeHouseholdGarbageTaxes']) || isset($postData['advertisement_chargesIncludeHouseholdGarbageTaxes'])) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label" for="chargesIncludeHouseholdGarbageTaxes">Taxe
                                    d'ordures ménagères</label>
                            </div>
                        </div>
                        <!-- Service de nettoyage -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeCleaningService"
                                    name="chargesIncludeCleaningService" <?php if ((isset($advertisementData[0]['advertisement_chargesIncludeCleaningService']) && $advertisementData[0]['advertisement_chargesIncludeCleaningService']) || isset($postData['advertisement_chargesIncludeCleaningService'])) {
                                echo 'checked';
                            }?>>
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
                    <?php if (isset($fillingError['street']) || isset($fillingError['zipcode']) || isset($fillingError['city']) || isset($fillingError['country'])) { ?>
                    <p class="text-danger font-weight-bold pb-1" type="error" id="errorAddressPhp">
                        <?php echo 'Veuillez renseigner une adresse valide';?></p>
                    <?php } ?>
                    <!-- Adresse -->
                    <div id="streetDiv" class="form-group">
                        <label for="street" class="font-weight-bold">Numéro et nom de rue</label>
                        <input id="street" type="text" name="street" title="Numéro, nom de rue" class="form-control"
                            placeholder="Saisir l'adresse du logement" value="<?php if(isset($advertisementData[0]['address_street'])){echo $advertisementData[0]['address_street'];
                            } else if (isset($postData['street'])){echo $postData['street'];}?>" maxlength="255">
                        <?php
                                if (isset($fillingError['street'])) {?>
                        <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['street'];?></p>
                        <?php } ?>
                    </div>
                    <!-- Code postal, ville, pays -->
                    <div class="row">
                        <!-- Code postal -->
                        <div id="zipcodeDiv" class="form-group col-md-2">
                            <label for="zipcode" class="font-weight-bold">Code postal</label>
                            <input id="zipcode" type="text" name="zipcode" title="Code postal" class="form-control"
                                placeholder="Code postal" value="<?php if(isset($advertisementData[0]['address_zipcode'])){echo $advertisementData[0]['address_zipcode'];
                                } else if (isset($postData['zipcode'])){echo $postData['zipcode'];}?>" maxlength="20">
                            <?php
                                if (isset($fillingError['zipcode'])) {?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['zipcode'];?></p>
                            <?php } ?>
                        </div>
                        <!-- Ville -->
                        <div id="cityDiv" class="form-group col-md-6">
                            <label for="city" class="font-weight-bold">Ville</label>
                            <input id="city" type="text" name="city" title="Ville" class="form-control"
                                placeholder="Ville" value="<?php if(isset($advertisementData[0]['address_city'])){echo $advertisementData[0]['address_city'];
                                }else if (isset($postData['city'])){echo $postData['city'];}?>" maxlength="60">
                            <?php
                                if (isset($fillingError['city'])) {?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['city'];?></p>
                            <?php } ?>
                        </div>
                        <!-- Pays -->
                        <div id="countryDiv" class="form-group col-md-4">
                            <label for="country" class="font-weight-bold">Pays</label>
                            <input id="country" type="text" name="country" title="Pays" class="form-control"
                                placeholder="Pays" value="<?php if(isset($advertisementData[0]['address_country'])){echo $advertisementData[0]['address_country'];
                                }else if (isset($postData['country'])){
                                    echo $postData['country'];}?>" maxlength="60">
                            <?php
                                if (isset($fillingError['country'])) {?>
                            <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['country'];?></p>
                            <?php } ?>
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
                                    aria-describedby="basic-addon2" value="<?php if(isset($advertisementData[0]['advertisement_accomodationLivingAreaSize'])){echo $advertisementData[0]['advertisement_accomodationLivingAreaSize'];
                                    }else if (isset($postData['accomodationLivingAreaSize'])){
                                        echo $postData['accomodationLivingAreaSize'];}?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m²</span>
                                </div>
                                <?php
                                if (isset($fillingError['accomodationLivingAreaSize'])) {?>
                                <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['accomodationLivingAreaSize'];?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Etage du logement -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label class="font-weight-bold" for="accomodationFloor">Etage du logement</label>
                            <select id="accomodationFloor" name="accomodationFloor" class="custom-select">
                                <option value="0" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "0") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "0" )) {
                                echo 'selected';
                            }?>>0</option>
                                <option value="1" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "1") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "1" )) {
                                echo 'selected';
                            }?>>1</option>
                                <option value="2" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "2") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "2" )) {
                                echo 'selected';
                            }?>>2</option>
                                <option value="3" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "3") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "3" )) {
                                echo 'selected';
                            }?>>3</option>
                                <option value="4" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "4") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "4" )) {
                                echo 'selected';
                            }?>>4</option>
                                <option value="5" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "5") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "5" )) {
                                echo 'selected';
                            }?>>5</option>
                                <option value="6" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "6") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "6" )) {
                                echo 'selected';
                            }?>>6</option>
                                <option value="7" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "7") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "7" )) {
                                echo 'selected';
                            }?>>7</option>
                                <option value="8" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "8") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "8" )) {
                                echo 'selected';
                            }?>>8</option>
                                <option value="9" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "9") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "9" )) {
                                echo 'selected';
                            }?>>9</option>
                                <option value="10" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "10") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "10" )) {
                                echo 'selected';
                            }?>>10</option>
                                <option value="11" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "11") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "11" )) {
                                echo 'selected';
                            }?>>11</option>
                                <option value="12" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "12") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "12" )) {
                                echo 'selected';
                            }?>>12</option>
                                <option value="13" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "13") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "13" )) {
                                echo 'selected';
                            }?>>13</option>
                                <option value="14" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "14") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "14" )) {
                                echo 'selected';
                            }?>>14</option>
                                <option value="15" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "15") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "15" )) {
                                echo 'selected';
                            }?>>15</option>
                                <option value="16" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "16") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "16" )) {
                                echo 'selected';
                            }?>>16</option>
                                <option value="17" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "17") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "17" )) {
                                echo 'selected';
                            }?>>17</option>
                                <option value="18" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "18") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "18" )) {
                                echo 'selected';
                            }?>>18</option>
                                <option value="19" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "19") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "19" )) {
                                echo 'selected';
                            }?>>19</option>
                                <option value="20" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "20") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "20" )) {
                                echo 'selected';
                            }?>>20</option>
                                <option value="21" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "21") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "21" )) {
                                echo 'selected';
                            }?>>21</option>
                                <option value="22" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "22") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "22" )) {
                                echo 'selected';
                            }?>>22</option>
                                <option value="23" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "23") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "23" )) {
                                echo 'selected';
                            }?>>23</option>
                                <option value="24" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "24") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "24" )) {
                                echo 'selected';
                            }?>>24</option>
                                <option value="25" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "25") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "25" )) {
                                echo 'selected';
                            }?>>25</option>
                                <option value="26" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "26") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "26" )) {
                                echo 'selected';
                            }?>>26</option>
                                <option value="27" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "27") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "27" )) {
                                echo 'selected';
                            }?>>27</option>
                                <option value="28" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "28") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "28" )) {
                                echo 'selected';
                            }?>>28</option>
                                <option value="29" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "29") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "29" )) {
                                echo 'selected';
                            }?>>29</option>
                                <option value="30" <?php if ((isset($advertisementData[0]['advertisement_accomodationFloor']) && $advertisementData[0]['advertisement_accomodationFloor'] == "30") || (isset($postData['accomodationFloor']) && $postData['accomodationFloor'] == "30" )) {
                                echo 'selected';
                            }?>>30</option>
                            </select>
                        </div>
                        <!-- Nombre d'étages -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label class="font-weight-bold" for="buildingNbOfFloors">Nombre d'etages (immeuble)</label>
                            <select id="buildingNbOfFloors" name="buildingNbOfFloors" class="custom-select">
                                <option value="0" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "0") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "0")) {
                                echo 'selected';
                            }?>>0</option>
                                <option value="1" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "1") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "1")) {
                                echo 'selected';
                            }?>>1</option>
                                <option value="2" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "2") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "2")) {
                                echo 'selected';
                            }?>>2</option>
                                <option value="3" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "3") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "3")) {
                                echo 'selected';
                            }?>>3</option>
                                <option value="4" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "4") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "4")) {
                                echo 'selected';
                            }?>>4</option>
                                <option value="5" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "5") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "5")) {
                                echo 'selected';
                            }?>>5</option>
                                <option value="6" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "6") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "6")) {
                                echo 'selected';
                            }?>>6</option>
                                <option value="7" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "7") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "7")) {
                                echo 'selected';
                            }?>>7</option>
                                <option value="8" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "8") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "8")) {
                                echo 'selected';
                            }?>>8</option>
                                <option value="9" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "9") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "9")) {
                                echo 'selected';
                            }?>>9</option>
                                <option value="10" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "10") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "10")) {
                                echo 'selected';
                            }?>>10</option>
                                <option value="11" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "11") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "11")) {
                                echo 'selected';
                            }?>>11</option>
                                <option value="12" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "12") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "12")) {
                                echo 'selected';
                            }?>>12</option>
                                <option value="13" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "13") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "13")) {
                                echo 'selected';
                            }?>>13</option>
                                <option value="14" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "14") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "14")) {
                                echo 'selected';
                            }?>>14</option>
                                <option value="15" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "15") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "15")) {
                                echo 'selected';
                            }?>>15</option>
                                <option value="16" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "16") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "16")) {
                                echo 'selected';
                            }?>>16</option>
                                <option value="17" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "17") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "17")) {
                                echo 'selected';
                            }?>>17</option>
                                <option value="18" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "18") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "18")) {
                                echo 'selected';
                            }?>>18</option>
                                <option value="19" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "19") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "19")) {
                                echo 'selected';
                            }?>>19</option>
                                <option value="20" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "20") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "20")) {
                                echo 'selected';
                            }?>>20</option>
                                <option value="21" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "21") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "21")) {
                                echo 'selected';
                            }?>>21</option>
                                <option value="22" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "22") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "22")) {
                                echo 'selected';
                            }?>>22</option>
                                <option value="23" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "23") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "23")) {
                                echo 'selected';
                            }?>>23</option>
                                <option value="24" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "24") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "24")) {
                                echo 'selected';
                            }?>>24</option>
                                <option value="25" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "25") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "25")) {
                                echo 'selected';
                            }?>>25</option>
                                <option value="26" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "26") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "26")) {
                                echo 'selected';
                            }?>>26</option>
                                <option value="27" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "27") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "27")) {
                                echo 'selected';
                            }?>>27</option>
                                <option value="28" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "28") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "28")) {
                                echo 'selected';
                            }?>>28</option>
                                <option value="29" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "29") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "29")) {
                                echo 'selected';
                            }?>>29</option>
                                <option value="30" <?php if ((isset($advertisementData[0]['advertisement_buildingNbOfFloors']) && $advertisementData[0]['advertisement_buildingNbOfFloors'] == "30") || (isset($postData['buildingNbOfFloors']) && $postData['buildingNbOfFloors'] == "30")) {
                                echo 'selected';
                            }?>>30</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Nombre de pièces -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label class="font-weight-bold" for="accomodationNbOfRooms">Nombre de pièces</label>
                            <select id="accomodationNbOfRooms" name="accomodationNbOfRooms" class="custom-select">
                                <option value="0" <?php if ($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "0") {
                                echo 'selected';
                            }?>>0</option>
                                <option value="1" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "1") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "1")) {
                                echo 'selected';
                            }?>>1</option>
                                <option value="2" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "2") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "2")) {
                                echo 'selected';
                            }?>>2</option>
                                <option value="3" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "3") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "3")) {
                                echo 'selected';
                            }?>>3</option>
                                <option value="4" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "4") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "4")) {
                                echo 'selected';
                            }?>>4</option>
                                <option value="5" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "5") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "5")) {
                                echo 'selected';
                            }?>>5</option>
                                <option value="6" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "6") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "6")) {
                                echo 'selected';
                            }?>>6</option>
                                <option value="7" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "7") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "7")) {
                                echo 'selected';
                            }?>>7</option>
                                <option value="8" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "8") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "8")) {
                                echo 'selected';
                            }?>>8</option>
                                <option value="9" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "9") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "9")) {
                                echo 'selected';
                            }?>>9</option>
                                <option value="10" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfRooms']) && $advertisementData[0]['advertisement_accomodationNbOfRooms'] == "10") || (isset($postData['accomodationNbOfRooms']) && $postData['accomodationNbOfRooms'] == "10")) {
                                echo 'selected';
                            }?>>10</option>
                            </select>
                        </div>
                        <!-- Nombre de salles de bains -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label class="font-weight-bold" for="accomodationNbOfBathrooms">Nombre de salles de
                                bain</label>
                            <select id="accomodationNbOfBathrooms" name="accomodationNbOfBathrooms"
                                class="custom-select">
                                <option value="0" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "0") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "0")) {
                                echo 'selected';
                            }?>>0</option>
                                <option value="1" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "1") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "1")) {
                                echo 'selected';
                            }?>>1</option>
                                <option value="2" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "2") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "2")) {
                                echo 'selected';
                            }?>>2</option>
                                <option value="3" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "3") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "3")) {
                                echo 'selected';
                            }?>>3</option>
                                <option value="4" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "4") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "4")) {
                                echo 'selected';
                            }?>>4</option>
                                <option value="5" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "5") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "5")) {
                                echo 'selected';
                            }?>>5</option>
                                <option value="6" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "6") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "6")) {
                                echo 'selected';
                            }?>>6</option>
                                <option value="7" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "7") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "7")) {
                                echo 'selected';
                            }?>>7</option>
                                <option value="8" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "8") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "8")) {
                                echo 'selected';
                            }?>>8</option>
                                <option value="9" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "9") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "9")) {
                                echo 'selected';
                            }?>>9</option>
                                <option value="10" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBathrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "10") || (isset($postData['accomodationNbOfBathrooms']) && $postData['accomodationNbOfBathrooms'] == "10")) {
                                echo 'selected';
                            }?>>10</option>
                            </select>
                        </div>
                        <!-- Nombre de chambres -->
                        <div class="form-group col-md-6 col-lg-4"
                            title="Nombre de chambres que contient au total le logement">
                            <label class="font-weight-bold" for="accomodationNbOfBedrooms">Nombre de chambres</label>
                            <select id="accomodationNbOfBedrooms" name="accomodationNbOfBedrooms" class="custom-select">
                                <option value="0" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "0") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "0")) {
                                echo 'selected';
                            }?>>0</option>
                                <option value="1" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "1") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "1")) {
                                echo 'selected';
                            }?>>1</option>
                                <option value="2" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "2") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "2")) {
                                echo 'selected';
                            }?>>2</option>
                                <option value="3" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "3") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "3")) {
                                echo 'selected';
                            }?>>3</option>
                                <option value="4" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "4") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "4")) {
                                echo 'selected';
                            }?>>4</option>
                                <option value="5" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "5") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "5")) {
                                echo 'selected';
                            }?>>5</option>
                                <option value="6" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "6") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "6")) {
                                echo 'selected';
                            }?>>6</option>
                                <option value="7" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "7") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "7")) {
                                echo 'selected';
                            }?>>7</option>
                                <option value="8" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "8") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "8")) {
                                echo 'selected';
                            }?>>8</option>
                                <option value="9" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "9") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "9")) {
                                echo 'selected';
                            }?>>9</option>
                                <option value="10" <?php if ((isset($advertisementData[0]['advertisement_accomodationNbOfBedrooms']) && $advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "10") || (isset($postData['accomodationNbOfBedrooms']) && $postData['accomodationNbOfBedrooms'] == "10")) {
                                echo 'selected';
                            }?>>10</option>
                            </select>
                        </div>
                        <!-- Nombre de chambres à louer-->
                        <div class="form-group col-md-6 col-lg-4" title="Nombre de chambres disponibles">
                            <label class="font-weight-bold" for="nbOfBedroomsToRent">Nombre de chambres à louer</label>
                            <select id="nbOfBedroomsToRent" name="nbOfBedroomsToRent" class="custom-select">
                                <option value="1" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "1") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "1")) {
                                echo 'selected';
                            }?>>1</option>
                                <option value="2" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "2") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "2")) {
                                echo 'selected';
                            }?>>2</option>
                                <option value="3" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "3") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "3")) {
                                echo 'selected';
                            }?>>3</option>
                                <option value="4" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "4") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "4")) {
                                echo 'selected';
                            }?>>4</option>
                                <option value="5" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "5") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "5")) {
                                echo 'selected';
                            }?>>5</option>
                                <option value="6" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "6") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "6")) {
                                echo 'selected';
                            }?>>6</option>
                                <option value="7" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "7") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "7")) {
                                echo 'selected';
                            }?>>7</option>
                                <option value="8" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "8") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "8")) {
                                echo 'selected';
                            }?>>8</option>
                                <option value="9" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "9") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "9")) {
                                echo 'selected';
                            }?>>9</option>
                                <option value="10" <?php if ((isset($advertisementData[0]['advertisement_nbOfBedroomsToRent']) && $advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "10") || (isset($postData['nbOfBedroomsToRent']) && $postData['nbOfBedroomsToRent'] == "10")) {
                                echo 'selected';
                            }?>>10</option>
                            </select>
                        </div>
                        <!-- Utilisation de la cuisine -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label for="kitchenUse" class="font-weight-bold">Utilisation de la cuisine</label>
                            <select id="kitchenUse" name="kitchenUse" class="custom-select">
                                <option value="Commun" <?php if ((isset($advertisementData[0]['advertisement_kitchenUse']) && $advertisementData[0]['advertisement_kitchenUse'] == "Commun") || (isset($postData['kitchenUse']) && $postData['kitchenUse'] == "Commun")) {
                                echo 'selected';
                            }?>>
                                    Commun</option>
                                <option value="Privée" <?php if ((isset($advertisementData[0]['advertisement_kitchenUse']) && $advertisementData[0]['advertisement_kitchenUse'] == "Privée") || (isset($postData['kitchenUse']) && $postData['kitchenUse'] == "Privée")) {
                                echo 'selected';
                            }?>>
                                    Privée</option>
                            </select>
                        </div>
                        <!-- Utilisation du salon -->
                        <div class="form-group col-md-6 col-lg-4">
                            <label for="livingRoomUse" class="font-weight-bold">Utilisation du salon</label>
                            <select id="livingRoomUse" name="livingRoomUse" class="custom-select">
                                <option value="Commun" <?php if ((isset($advertisementData[0]['advertisement_livingRoomUse']) && $advertisementData[0]['advertisement_livingRoomUse'] == "Commun") || (isset($postData['livingRoomUse']) && $postData['livingRoomUse'] == "Commun")) {
                                echo 'selected';
                            }?>>
                                    Commun</option>
                                <option value="Privée" <?php if ((isset($advertisementData[0]['advertisement_livingRoomUse']) && $advertisementData[0]['advertisement_livingRoomUse'] == "Privée") || (isset($postData['livingRoomUse']) && $postData['livingRoomUse'] == "Privée")) {
                                echo 'selected';
                            }?>>
                                    Privée</option>
                                <option value="Aucun" <?php if ((isset($advertisementData[0]['advertisement_livingRoomUse']) && $advertisementData[0]['advertisement_livingRoomUse'] == "Aucun") || (isset($postData['livingRoomUse']) && $postData['livingRoomUse'] == "Aucun")) {
                                echo 'selected';
                            }?>>
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
                                    class="form-control" placeholder="0" aria-describedby="basic-addon2" value="<?php if (isset($advertisementData[0]['advertisement_energyClassNumber'])){echo $advertisementData[0]['advertisement_energyClassNumber'];}else if(isset($postData['energyClassNumber'])){
                                        echo $postData['energyClassNumber'];
                                    }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">kWhEp/m²/an</span>
                                </div>
                                <div class="input-group-append  ">
                                    <span id="energyClassLetterView" class="input-group-text"
                                        id="basic-addon2"><?php if (isset($advertisementData[0]['advertisement_energyClassLetter'])){echo $advertisementData[0]['advertisement_energyClassLetter'];}else if(isset($postData['energyClassLetter'])){echo $postData['energyClassLetter'];}?></span>
                                </div>
                                <input id="energyClassLetterInput" type="hidden" name="energyClassLetter"
                                    class="form-control"
                                    value="<?php if (isset($advertisementData[0]['advertisement_energyClassLetter'])){echo $advertisementData[0]['advertisement_energyClassLetter'];}else if(isset($postData['energyClassLetter'])){echo $postData['energyClassLetter'];}?>">
                                <?php
                                if (isset($fillingError['energyClassNumber'])) {?>
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
                                    placeholder="0" aria-describedby="basic-addon2"
                                    value="<?php if (isset($advertisementData[0]['advertisement_gesNumber'])){echo $advertisementData[0]['advertisement_gesNumber'];}else if(isset($postData['gesNumber'])){echo $postData['gesNumber'];}?>"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">kgeqCO2/m²/an</span>
                                </div>
                                <div class="input-group-append">
                                    <span id="gesLetterView" class="input-group-text"
                                        id="basic-addon2"><?php if (isset($advertisementData[0]['advertisement_gesLetter'])){echo $advertisementData[0]['advertisement_gesLetter'];}else if(isset($postData['gesLetter'])){echo $postData['gesLetter'];}?></span>
                                </div>
                                <input id="gesLetterInput" type="hidden" name="gesLetter" class="form-control"
                                    value="<?php if (isset($advertisementData[0]['advertisement_gesLetter'])){echo $advertisementData[0]['advertisement_gesLetter'];}else if(isset($postData['gesLetter'])){echo $postData['gesLetter'];}?>">
                                <?php
                                if (isset($fillingError['gesNumber'])) {?>
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
                                    name="handicapedAccessibility" <?php if ((isset($advertisementData[0]['advertisement_handicapedAccessibility']) && $advertisementData[0]['advertisement_handicapedAccessibility'] == 1) || (isset($postData['advertisement_handicapedAccessibility']) && $postData['advertisement_handicapedAccessibility'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="handicapedAccessibility">Accès
                                    handicapé</label>
                            </div>
                        </div>
                        <!-- Ascenceur -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasElevator"
                                    name="accomodationHasElevator" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasElevator']) && $advertisementData[0]['advertisement_accomodationHasElevator'] == 1) || (isset($postData['advertisement_accomodationHasElevator']) && $postData['advertisement_accomodationHasElevator'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasElevator">Ascenceur</label>
                            </div>
                        </div>
                        <!-- Parking commun -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasCommonParkingLot"
                                    name="accomodationHasCommonParkingLot" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasCommonParkingLot']) && $advertisementData[0]['advertisement_accomodationHasCommonParkingLot'] == 1) || (isset($postData['advertisement_accomodationHasCommonParkingLot']) && $postData['advertisement_accomodationHasCommonParkingLot'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasCommonParkingLot">Parking
                                    commun</label>
                            </div>
                        </div>
                        <!-- Place de parking privée -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasPrivateParkingPlace" name="accomodationHasPrivateParkingPlace" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasPrivateParkingPlace']) && $advertisementData[0]['advertisement_accomodationHasPrivateParkingPlace'] == 1) || (isset($postData['advertisement_accomodationHasPrivateParkingPlace']) && $postData['advertisement_accomodationHasPrivateParkingPlace'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasPrivateParkingPlace">Place de
                                    parking privée</label>
                            </div>
                        </div>
                        <!-- Jardin -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasGarden"
                                    name="accomodationHasGarden" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasGarden']) && $advertisementData[0]['advertisement_accomodationHasGarden'] == 1) || (isset($postData['advertisement_accomodationHasGarden']) && $postData['advertisement_accomodationHasGarden'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasGarden">Jardin</label>
                            </div>
                        </div>
                        <!-- Balcon -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasBalcony"
                                    name="accomodationHasBalcony" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasBalcony']) && $advertisementData[0]['advertisement_accomodationHasBalcony'] == 1) || (isset($postData['advertisement_accomodationHasBalcony']) && $postData['advertisement_accomodationHasBalcony'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasBalcony">Balcon</label>
                            </div>
                        </div>
                        <!-- Terrasse -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasTerrace"
                                    name="accomodationHasTerrace" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasTerrace']) && $advertisementData[0]['advertisement_accomodationHasTerrace'] == 1) || (isset($postData['advertisement_accomodationHasTerrace']) && $postData['advertisement_accomodationHasTerrace'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasTerrace">Terrasse</label>
                            </div>
                        </div>
                        <!-- Piscine -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasSwimmingPool"
                                    name="accomodationHasSwimmingPool" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasSwimmingPool']) && $advertisementData[0]['advertisement_accomodationHasSwimmingPool'] == 1) || (isset($postData['advertisement_accomodationHasSwimmingPool']) && $postData['advertisement_accomodationHasSwimmingPool'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasSwimmingPool">Piscine</label>
                            </div>
                        </div>
                        <!-- Internet -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasInternet"
                                    name="accomodationHasInternet" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasInternet']) && $advertisementData[0]['advertisement_accomodationHasInternet'] == 1) || (isset($postData['advertisement_accomodationHasInternet']) && $postData['advertisement_accomodationHasInternet'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasInternet">Internet</label>
                            </div>
                        </div>
                        <!-- Wifi -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasWifi"
                                    name="accomodationHasWifi" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasWifi']) && $advertisementData[0]['advertisement_accomodationHasWifi'] == 1) || (isset($postData['advertisement_accomodationHasWifi']) && $postData['advertisement_accomodationHasWifi'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasWifi">Wifi</label>
                            </div>
                        </div>
                        <!-- Fibre optique -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasFiberOpticInternet" name="accomodationHasFiberOpticInternet" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasFiberOpticInternet']) && $advertisementData[0]['advertisement_accomodationHasFiberOpticInternet'] == 1) || (isset($postData['advertisement_accomodationHasFiberOpticInternet']) && $postData['advertisement_accomodationHasFiberOpticInternet'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasFiberOpticInternet">Fibre
                                    optique</label>
                            </div>
                        </div>
                        <!-- Netflix -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasNetflix"
                                    name="accomodationHasNetflix" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasNetflix']) && $advertisementData[0]['advertisement_accomodationHasNetflix'] == 1) || (isset($postData['advertisement_accomodationHasNetflix']) && $postData['advertisement_accomodationHasNetflix'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasNetflix">Netflix</label>
                            </div>
                        </div>
                        <!-- Télévision -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasTv"
                                    name="accomodationHasTv" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasTv']) && $advertisementData[0]['advertisement_accomodationHasTv'] == 1) || (isset($postData['advertisement_accomodationHasTv']) && $postData['advertisement_accomodationHasTv'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasTv">Télévision</label>
                            </div>
                        </div>
                        <!-- Double vitrage -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasDoubleGlazing"
                                    name="accomodationHasDoubleGlazing" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasDoubleGlazing']) && $advertisementData[0]['advertisement_accomodationHasDoubleGlazing'] == 1) || (isset($postData['advertisement_accomodationHasDoubleGlazing']) && $postData['advertisement_accomodationHasDoubleGlazing'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasDoubleGlazing">Double
                                    vitrage</label>
                            </div>
                        </div>
                        <!-- Chauffe eau gaz -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasGasWaterHeater"
                                    name="accomodationHasGasWaterHeater" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasGasWaterHeater']) && $advertisementData[0]['advertisement_accomodationHasGasWaterHeater'] == 1) || (isset($postData['advertisement_accomodationHasGasWaterHeater']) && $postData['advertisement_accomodationHasGasWaterHeater'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasGasWaterHeater">Chauffe eau
                                    gaz</label>
                            </div>
                        </div>
                        <!-- Ballon d'eau chaude -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasHotWaterTank"
                                    name="accomodationHasHotWaterTank" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasHotWaterTank']) && $advertisementData[0]['advertisement_accomodationHasHotWaterTank'] == 1) || (isset($postData['advertisement_accomodationHasHotWaterTank']) && $postData['advertisement_accomodationHasHotWaterTank'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasHotWaterTank">Ballon d'eau
                                    chaude</label>
                            </div>
                        </div>
                        <!-- Climatisation -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasAirConditioning"
                                    name="accomodationHasAirConditioning" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasAirConditioning']) && $advertisementData[0]['advertisement_accomodationHasAirConditioning'] == 1) || (isset($postData['advertisement_accomodationHasAirConditioning']) && $postData['advertisement_accomodationHasAirConditioning'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label "
                                    for="accomodationHasAirConditioning">Climatisation</label>
                            </div>
                        </div>
                        <!-- Chauffage éléctrique -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasElectricHeating"
                                    name="accomodationHasElectricHeating" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasElectricHeating']) && $advertisementData[0]['advertisement_accomodationHasElectricHeating'] == 1) || (isset($postData['advertisement_accomodationHasElectricHeating']) && $postData['advertisement_accomodationHasElectricHeating'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="accomodationHasElectricHeating">Chauffage
                                    électrique</label>
                            </div>
                        </div>
                        <!-- Chauffage individuel gaz -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasIndividualGasHeating" name="accomodationHasIndividualGasHeating" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasIndividualGasHeating']) && $advertisementData[0]['advertisement_accomodationHasIndividualGasHeating'] == 1) || (isset($postData['advertisement_accomodationHasIndividualGasHeating']) && $postData['advertisement_accomodationHasIndividualGasHeating'] == 1)) {
                                echo 'checked';
                            }
?>>
                                <label class="custom-control-label " for="accomodationHasIndividualGasHeating">Chauffage
                                    individuel gaz</label>
                            </div>
                        </div>
                        <!-- Chauffage collectif gaz -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasCollectiveGasHeating" name="accomodationHasCollectiveGasHeating" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasCollectiveGasHeating']) && $advertisementData[0]['advertisement_accomodationHasCollectiveGasHeating'] == 1) || (isset($postData['advertisement_accomodationHasCollectiveGasHeating']) && $postData['advertisement_accomodationHasCollectiveGasHeating'] == 1)) {
    echo 'checked';
}
?>>
                                <label class="custom-control-label " for="accomodationHasCollectiveGasHeating">Chauffage
                                    collectif gaz</label>
                            </div>
                        </div>
                        <!-- Lave linge -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasWashingMachine"
                                    name="accomodationHasWashingMachine" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasWashingMachine']) && $advertisementData[0]['advertisement_accomodationHasWashingMachine'] == 1) || (isset($postData['advertisement_accomodationHasWashingMachine']) && $postData['advertisement_accomodationHasWashingMachine'] == 1)) {
    echo 'checked';
}
?>>
                                <label class="custom-control-label "
                                    for="accomodationHasWashingMachine">Lave-linge</label>
                            </div>
                        </div>
                        <!-- Lave vaisselle -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasDishwasher"
                                    name="accomodationHasDishwasher" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasDishwasher']) && $advertisementData[0]['advertisement_accomodationHasDishwasher'] == 1) || (isset($postData['advertisement_accomodationHasDishwasher']) && $postData['advertisement_accomodationHasDishwasher'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasDishwasher">Lave-vaisselle</label>
                            </div>
                        </div>
                        <!-- Réfrigérateur -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasFridge"
                                    name="accomodationHasFridge" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasFridge']) && $advertisementData[0]['advertisement_accomodationHasFridge'] == 1) || (isset($postData['advertisement_accomodationHasFridge']) && $postData['advertisement_accomodationHasFridge'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasFridge">Réfrigérateur</label>
                            </div>
                        </div>
                        <!-- Congélateur -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasFreezer"
                                    name="accomodationHasFreezer" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasFreezer']) && $advertisementData[0]['advertisement_accomodationHasFreezer'] == 1) || (isset($postData['advertisement_accomodationHasFreezer']) && $postData['advertisement_accomodationHasFreezer'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasFreezer">Congélateur</label>
                            </div>
                        </div>
                        <!-- Plaques de cuisson -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasBakingTray"
                                    name="accomodationHasBakingTray" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasBakingTray']) && $advertisementData[0]['advertisement_accomodationHasBakingTray'] == 1) || (isset($postData['advertisement_accomodationHasBakingTray']) && $postData['advertisement_accomodationHasBakingTray'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasBakingTray">Plaques de
                                    cuisson</label>
                            </div>
                        </div>
                        <!-- Hotte aspirante -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasExtractorHood"
                                    name="accomodationHasExtractorHood" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasExtractorHood']) && $advertisementData[0]['advertisement_accomodationHasExtractorHood'] == 1) || (isset($postData['advertisement_accomodationHasExtractorHood']) && $postData['advertisement_accomodationHasExtractorHood'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasExtractorHood">Hotte
                                    aspirante</label>
                            </div>
                        </div>
                        <!-- Four -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasOven"
                                    name="accomodationHasOven" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasOven']) && $advertisementData[0]['advertisement_accomodationHasOven'] == 1) || (isset($postData['advertisement_accomodationHasOven']) && $postData['advertisement_accomodationHasOven'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasOven">Four</label>
                            </div>
                        </div>
                        <!-- Micro-ondes -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasMicrowaveOven"
                                    name="accomodationHasMicrowaveOven" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasMicrowaveOven']) && $advertisementData[0]['advertisement_accomodationHasMicrowaveOven'] == 1) || (isset($postData['advertisement_accomodationHasMicrowaveOven']) && $postData['advertisement_accomodationHasMicrowaveOven'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasMicrowaveOven">Four
                                    micro-ondes</label>
                            </div>
                        </div>
                        <!-- Cafetière -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasCoffeeMachine"
                                    name="accomodationHasCoffeeMachine" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasCoffeeMachine']) && $advertisementData[0]['advertisement_accomodationHasCoffeeMachine'] == 1) || (isset($postData['advertisement_accomodationHasCoffeeMachine']) && $postData['advertisement_accomodationHasCoffeeMachine'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasCoffeeMachine">Cafetière</label>
                            </div>
                        </div>
                        <!-- Machine à café dosette -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasPodCoffeeMachine"
                                    name="accomodationHasPodCoffeeMachine" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasPodCoffeeMachine']) && $advertisementData[0]['advertisement_accomodationHasPodCoffeeMachine'] == 1) || (isset($postData['advertisement_accomodationHasPodCoffeeMachine']) && $postData['advertisement_accomodationHasPodCoffeeMachine'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasPodCoffeeMachine">Machine à
                                    café avec dosette</label>
                            </div>
                        </div>
                        <!-- Bouilloire -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasKettle"
                                    name="accomodationHasKettle" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasKettle']) && $advertisementData[0]['advertisement_accomodationHasKettle'] == 1) || (isset($postData['advertisement_accomodationHasKettle']) && $postData['advertisement_accomodationHasKettle'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasKettle">Bouilloire</label>
                            </div>
                        </div>
                        <!-- Grille pain -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasToaster"
                                    name="accomodationHasToaster" <?php if ((isset($advertisementData[0]['advertisement_accomodationHasToaster']) && $advertisementData[0]['advertisement_accomodationHasToaster'] == 1) || (isset($postData['advertisement_accomodationHasToaster']) && $postData['advertisement_accomodationHasToaster'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="accomodationHasToaster">Grille pain</label>
                            </div>
                        </div>
                        <!-- Visites autorisées -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="authorizedVisit"
                                    name="authorizedVisit" <?php if ((isset($advertisementData[0]['advertisement_authorizedVisit']) && $advertisementData[0]['advertisement_authorizedVisit'] == 1) || (isset($postData['advertisement_authorizedVisit']) && $postData['advertisement_authorizedVisit'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="authorizedVisit">Visites autorisées</label>
                            </div>
                        </div>
                        <!-- Animaux autorisés -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="animalsAllowed"
                                    name="animalsAllowed" <?php if ((isset($advertisementData[0]['advertisement_animalsAllowed']) && $advertisementData[0]['advertisement_animalsAllowed'] == 1) || (isset($postData['advertisement_animalsAllowed']) && $postData['advertisement_animalsAllowed'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="animalsAllowed">Animaux autorisés</label>
                            </div>
                        </div>
                        <!-- Fumer autorisé -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="smokingIsAllowed"
                                    name="smokingIsAllowed" <?php if ((isset($advertisementData[0]['advertisement_smokingIsAllowed']) && $advertisementData[0]['advertisement_smokingIsAllowed'] == 1) || (isset($postData['advertisement_smokingIsAllowed']) && $postData['advertisement_smokingIsAllowed'] == 1)) {
    echo 'checked';
}?>>
                                <label class="custom-control-label " for="smokingIsAllowed">Fumer est autorisé</label>
                            </div>
                        </div>
                        <!-- Fêtes autorisées -->
                        <div class="form-group col-md-6 col-lg-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="authorizedParty"
                                    name="authorizedParty" <?php if ((isset($advertisementData[0]['advertisement_authorizedParty']) && $advertisementData[0]['advertisement_authorizedParty'] == 1) || (isset($postData['advertisement_authorizedParty']) && $postData['advertisement_authorizedParty'] == 1)) {
    echo 'checked';
}?>>
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
                                    placeholder="0" aria-describedby="basic-addon2" value="<?php if (isset($advertisementData[0]['advertisement_bedroomSize'])){echo $advertisementData[0]['advertisement_bedroomSize'];}
                                    else if (isset($postData['bedroomSize'])){
                                        echo $postData['bedroomSize'];
                                    }?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m²</span>
                                </div>
                                <?php
                                if (isset($fillingError['bedroomSize'])) {?>
                                <p class="text-danger font-weight-bold pb-1" type="error"><?php
                            echo $fillingError['bedroomSize'];?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Type de chambre -->
                        <div class="form-group col-sm-6 col-lg-4">
                            <label for="bedroomType" class="font-weight-bold">Type de chambre</label>
                            <select id="bedroomType" name="bedroomType" class="custom-select">
                                <option value="Simple" <?php if ((isset($advertisementData[0]['advertisement_bedroomType']) && $advertisementData[0]['advertisement_bedroomType']  == "Simple") || (isset($postData['bedroomType']) && $postData['bedroomType'] == 'Simple')) {
                                echo 'selected';
                            }?>>
                                    Simple</option>
                                <option value="Double" <?php if ((isset($advertisementData[0]['advertisement_bedroomType']) && $advertisementData[0]['advertisement_bedroomType']  == "Double") || (isset($postData['bedroomType']) && $postData['bedroomType'] == 'Double')) {
                                echo 'selected';
                            }?>>
                                    Double</option>
                                <option value="Partagée" <?php if ((isset($advertisementData[0]['advertisement_bedroomType']) && $advertisementData[0]['advertisement_bedroomType']  == "Partagée") || (isset($postData['bedroomType']) && $postData['bedroomType'] == 'Partagée')) {
                                echo 'selected';
                            }?>>
                                    Partagée</option>
                            </select>
                        </div>
                        <!-- Type de lit -->
                        <div class="form-group col-sm-6 col-lg-4">
                            <label for="bedType" class="font-weight-bold">Type de lit</label>
                            <select id="bedType" name="bedType" class="custom-select">
                                <option value="Simple" <?php if ((isset($advertisementData[0]['advertisement_bedType']) && $advertisementData[0]['advertisement_bedType']  == "Simple") || (isset($postData['bedType']) && $postData['bedType'] == 'Simple')) {
                                echo 'selected';
                            }?>>
                                    Simple</option>
                                <option value="Double" <?php if ((isset($advertisementData[0]['advertisement_bedType']) && $advertisementData[0]['advertisement_bedType']  == "Double") || (isset($postData['bedType']) && $postData['bedType'] == 'Double')) {
                                echo 'selected';
                            }?>>
                                    Double</option>
                                <option value="Canapé-lit" <?php if ((isset($advertisementData[0]['advertisement_bedType']) && $advertisementData[0]['advertisement_bedType']  == "Canapé-lit") || (isset($postData['bedType']) && $postData['bedType'] == 'Canapé-lit')) {
                                    echo 'selected';
                            }?>>
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
                                    name="bedroomHasDesk" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasDesk']) && $advertisementData[0]['advertisement_bedroomHasDesk'] == 1) || (isset($postData['bedroomHasDesk']) && $postData['bedroomHasDesk'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasDesk">Bureau</label>
                            </div>
                        </div>
                        <!-- Chaise -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasChair"
                                    name="bedroomHasChair" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasChair']) && $advertisementData[0]['advertisement_bedroomHasChair'] == 1) || (isset($postData['bedroomHasChair']) && $postData['bedroomHasChair'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasChair">Chaise</label>
                            </div>
                        </div>
                        <!-- Tv -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasTv"
                                    name="bedroomHasTv" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasTv']) && $advertisementData[0]['advertisement_bedroomHasTv'] == 1) || (isset($postData['bedroomHasTv']) && $postData['bedroomHasTv'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasTv">Télévision</label>
                            </div>
                        </div>
                        <!-- Fauteuil -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasArmchair"
                                    name="bedroomHasArmchair" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasArmchair']) && $advertisementData[0]['advertisement_bedroomHasArmchair'] == 1) || (isset($postData['bedroomHasArmchair']) && $postData['bedroomHasArmchair'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasArmchair">Fauteuil</label>
                            </div>
                        </div>
                        <!-- Table basse -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasCoffeeTable"
                                    name="bedroomHasCoffeeTable" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasCoffeeTable']) && $advertisementData[0]['advertisement_bedroomHasCoffeeTable'] == 1) || (isset($postData['bedroomHasCoffeeTable']) && $postData['bedroomHasCoffeeTable'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasCoffeeTable">Table basse</label>
                            </div>
                        </div>
                        <!-- Chevet -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasBedside"
                                    name="bedroomHasBedside" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasBedside']) && $advertisementData[0]['advertisement_bedroomHasBedside'] == 1) || (isset($postData['bedroomHasBedside']) && $postData['bedroomHasBedside'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasBedside">Chevet</label>
                            </div>
                        </div>
                        <!-- Lampe -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasLamp"
                                    name="bedroomHasLamp" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasLamp']) && $advertisementData[0]['advertisement_bedroomHasLamp'] == 1) || (isset($postData['bedroomHasLamp']) && $postData['bedroomHasLamp'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasLamp">Lampe</label>
                            </div>
                        </div>
                        <!-- Etagères -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasShelf"
                                    name="bedroomHasShelf" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasShelf']) && $advertisementData[0]['advertisement_bedroomHasShelf'] == 1) || (isset($postData['bedroomHasShelf']) && $postData['bedroomHasShelf'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasShelf">Etagère(s)</label>
                            </div>
                        </div>
                        <!-- Armoire -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasWardrobe"
                                    name="bedroomHasWardrobe" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasWardrobe']) && $advertisementData[0]['advertisement_bedroomHasWardrobe'] == 1) || (isset($postData['bedroomHasWardrobe']) && $postData['bedroomHasWardrobe'] == 1)) {
                                echo 'checked';
                            }?>>
                                <label class="custom-control-label " for="bedroomHasWardrobe">Armoire</label>
                            </div>
                        </div>
                        <!-- Penderie -->
                        <div class="form-group col-6 col-md-4 col-xl-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasCloset"
                                    name="bedroomHasCloset" <?php if ((isset($advertisementData[0]['advertisement_bedroomHasCloset']) && $advertisementData[0]['advertisement_bedroomHasCloset'] == 1) || (isset($postData['bedroomHasCloset']) && $postData['bedroomHasCloset'] == 1)) {
                                echo 'checked';
                            } ?>>
                                <label class="custom-control-label " for="bedroomHasCloset">Penderie</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Photos -->
            <div class="container py-3 px-0 px-md-3 border-bottom border-dark">
                <h2 class=>Photos</h2>
                <!-- Suppression photos -->
                <?php if ($advertisementPicture) { ?>
                <div class="container pt-3">
                    <h4>Supprimer des photos</h4>
                    <p>Cocher les photos que vous voulez supprimer</p>
                    <div id="previewImageCheckbox" class="row p-2">
                        <?php foreach ($advertisementPicture as $key => $value) { ?>
                        <div class="col-md-6 col-lg-4 p-0 m-0">
                            <label id="<?='labelImageToDelete'.$key?>" class="image-checkbox"
                                onclick="changeStatue(id,event)">
                                <img class="img-responsive img-thumbnail"
                                    src="<?=$picturePath.$advertisementPicture[$key]['picture_fileName']?>"
                                    alt="Photo de l'annonce">
                                <input class="PictureCheckbox" type="checkbox" name=pictureToDelete[]
                                    value="<?=$advertisementPicture[$key]['picture_fileName']?>">
                            </label>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
                <!-- Ajout photos -->
                <div class="container pt-3">
                    <h4>Ajouter des photos</h4>
                    <div id="inputDiv" class="container">
                        <input type="file" onchange="handleFiles(files,id)" id="upload" multiple name="file[]">
                        <?php if (isset($fillingError['file'])) {?>
                        <p class="text-danger font-weight-bold pb-1" type="error" type="error">
                            <?=$fillingError['file']?>
                        </p><?php } ?>
                    </div>
                    <div>
                        <label for="upload"><span id="preview" class="row p-2"></span></label>
                    </div>
                </div>
            </div>
            <!-- Bouton submit -->
            <div class="container py-3">
                <button id="submitButton" type="submit"
                    class="btn btn-primary offset-2 col-8 offset-lg-4 col-lg-4">Enregistrer mes
                    modifications</button>
            </div>
        </form>
    </div>
</div>
<script src="public/js/autocompleteAddress.js"></script>
<script src="public/js/spinnerSubmitButton.js"></script>
<script src="public/js/hiddenInput.js"></script>
<script src="public/js/caractersCount.js"></script>
<script src="public/js/selectPictureToDeleteModifyAdvertisement.js"></script>
<script src="public/js/energyAdvertisement.js"></script>
<script src="public/js/advertisementUploadFilePreviewOk.js"></script>
<script src="public/js/redBorder.js"></script>
<?php
$content = ob_get_clean();
require('view/includes/template.php');