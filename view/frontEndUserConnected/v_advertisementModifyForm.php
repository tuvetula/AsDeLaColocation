<?php
$title = "Modifier une annonce";
ob_start();
?>
<div class="screen container px-1 px-md-3">
    <div class="jumbotron">
        <h1 class="pb-3 text-center">Modifier votre annonce</h1>
        <form method="post"
            action="index.php?page=saveModificationAdvertisement&id=<?=$advertisementData[0]['advertisement_id']?>"
            enctype="multipart/form-data">
            <!-- ----------Annonce---------- -->
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <p class="text-center"><?php if (isset($confirm) && $confirm==1){
                echo 'Votre annonce a bien été modifée';
            }?></p>
                <h2>Annonce</h2>
                <!-- IsActive, Titre, Description -->
                <div class="container">
                    <!-- isActive -->
                    <div class=" custom-control custom-checkbox ">
                        <input type="checkbox" class="custom-control-input" id="isActive" name="isActive"
                            <?php if($advertisementData[0]['advertisement_isActive']){echo 'checked';}?>>
                        <label class="custom-control-label font-weight-bold" for="isActive">Activation annonce</label>
                    </div>
                    <!--Titre-->
                    <div class="form-group"
                        title="Le titre doit être unique si vous avez plusieurs annonces. Soyez précis et concis.">
                        <label class="font-weight-bold" for="title">Titre</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Titre de l'annonce"
                            maxlength="255" value="<?=$advertisementData[0]['advertisement_title']?>" required>
                    </div>
                    <!--Description-->
                    <div class="form-group">
                        <label class="font-weight-bold" for="description">Description</label>
                        <textarea class="form-control" id="description" rows="6" name="description"
                            placeholder="maximum 3000 charactères" maxlength="3000"
                            required><?=$advertisementData[0]['advertisement_description']?></textarea>
                    </div>
                    <!-- Type, catégorie, disponible le, location sans visite -->
                    <div class="row">
                        <!--Type de logement-->
                        <div class="form-group col-md-3" title="Sélectionner le type de bien">
                            <label class="font-weight-bold">Type de logement</label>
                            <div class="form-check">
                                <input id="radioType1" class="form-check-input" type="radio" name="type" value="Maison"
                                    <?php if ($advertisementData[0]['advertisement_type'] == 'Maison'){echo 'checked';}?>>
                                <label class="form-check-label" for="radioType1">
                                    Maison
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="radioType2" class="form-check-input" type="radio" name="type"
                                    value="Appartement"
                                    <?php if ($advertisementData[0]['advertisement_type'] == 'Appartement'){echo 'checked';}?>>
                                <label class="form-check-label" for="radioType2">
                                    Appartement
                                </label>
                            </div>
                        </div>
                        <!--Catégorie du logement-->
                        <div class="form-group col-md-3" title="Sélectionner la catégorie correspondante">
                            <label class="font-weight-bold">Catégorie</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory1" value="Location"
                                    <?php if ($advertisementData[0]['advertisement_category'] == 'Location'){echo 'checked';}?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory1">
                                    Location
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory2" value="Colocation"
                                    <?php if ($advertisementData[0]['advertisement_category'] == 'Colocation'){echo 'checked';}?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory2">
                                    Colocation
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory3" value="Sous-location"
                                    <?php if ($advertisementData[0]['advertisement_category'] == 'Sous-location'){echo 'checked';}?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory3">
                                    Sous-location
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory4" value="Courte-durée"
                                    <?php if ($advertisementData[0]['advertisement_category'] == 'Courte-durée'){echo 'checked';}?>>
                                <label class="form-check-label" for="radioButtonAccomodationCategory4">
                                    Courte-durée
                                </label>
                            </div>
                        </div>
                        <!-- Disponible le -->
                        <div class="form-group col-md-3" title="Donner la date à laquelle le locataire pourra entrer">
                            <label for="availableDate" class="font-weight-bold">Disponible le</label>
                            <input class="form-control" type="date" id="availableDate" name="availableDate"
                                value="<?=$advertisementData[0]['advertisement_availableDate']?>" required>
                        </div>
                        <!-- Location sans visite + meublé -->
                        <div class="form-group col-md-3">
                            <!-- Meublé -->
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="isFurnished" name="isFurnished"
                                    <?php if($advertisementData[0]['advertisement_isFurnished']){echo 'checked';}?>>
                                <label class="custom-control-label font-weight-bold" for="isFurnished">Meublé</label>
                            </div>
                            <!-- Location sans visite -->
                            <div class="custom-control custom-checkbox"
                                title="J'accepte le dossier d'un candidat qui n'a pas visité">
                                <input type="checkbox" class="custom-control-input" id="rentWithoutVisit"
                                    name="rentWithoutVisit"
                                    <?php if($advertisementData[0]['advertisement_rentWithoutVisit']){echo 'checked';}?>>
                                <label class="custom-control-label font-weight-bold" for="rentWithoutVisit">Location
                                    sans
                                    visite</label>
                            </div>
                        </div>
                    </div>
                    <!-- Nom, Telephone, Mail pour les visites-->
                    <div class="row">
                        <!-- Nom du contact pour les visites -->
                        <div class="form-group col-md-4">
                            <label for="contactNameForVisit" class="font-weight-bold">Nom du contact pour les
                                visites</label>
                            <input id="contactNameForVisit" type="text" name="contactNameForVisit" class="form-control"
                                placeholder="Nom"
                                value="<?=$advertisementData[0]['advertisement_contactNameForVisit']?>" maxlength="125"
                                required>
                        </div>
                        <!-- Telephone du contact pour les visites -->
                        <div class="form-group col-md-4">
                            <label for="contactPhoneNumberForVisit" class="font-weight-bold">Telephone du contact
                                pour
                                les visites</label>
                            <input id="contactPhoneNumberForVisit" type="tel" name="contactPhoneNumberForVisit"
                                class="form-control" placeholder="Téléphone"
                                value="<?=$advertisementData[0]['advertisement_contactPhoneNumberForVisit']?>"
                                maxlength="20" required>
                        </div>
                        <!-- Mail du contact pour les visites -->
                        <div class="form-group col-md-4">
                            <label for="contactMailForVisit" class="font-weight-bold">Mail du contact pour les
                                visites</label>
                            <input id="contactMailForVisit" type="email" name="contactMailForVisit" class="form-control"
                                placeholder="Mail"
                                value="<?=$advertisementData[0]['advertisement_contactMailForVisit']?>" maxlength="255"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Situation du loueur -->
                        <div class="form-group col-md-4">
                            <label for="renterSituation" class="font-weight-bold">Situation du loueur </label>
                            <select id="renterSituation" name="renterSituation" class="custom-select">
                                <option value="Propriétaire" <?php if($advertisementData[0]['advertisement_renterSituation'] == "Propriétaire"){
                                    echo 'selected';
                                }?>>Propriétaire</option>
                                <option value="Locataire" <?php if($advertisementData[0]['advertisement_renterSituation'] == "Locataire"){
                                    echo 'selected';
                                }?>>Locataire</option>
                            </select>
                        </div>
                        <!-- Durée minimum de séjour -->
                        <div class="form-group col-md-4">
                            <label for="locationMinDuration" class="font-weight-bold">Durée minimum de
                                séjour</label>
                            <select id="locationMinDuration" name="locationMinDuration" class="custom-select">
                                <option value="1 mois" <?php if($advertisementData[0]['advertisement_locationMinDuration'] == "1 mois"){
                                    echo 'selected';
                                }?>>1 mois</option>
                                <option value="3 mois" <?php if($advertisementData[0]['advertisement_locationMinDuration'] == "3 mois"){
                                    echo 'selected';
                                }?>>3 mois</option>
                                <option value="6 mois" <?php if($advertisementData[0]['advertisement_locationMinDuration'] == "6 mois"){
                                    echo 'selected';
                                }?>>6 mois</option>
                                <option value="9 mois" <?php if($advertisementData[0]['advertisement_locationMinDuration'] == "9 mois"){
                                    echo 'selected';
                                }?>>9 mois</option>
                                <option value="12 mois" <?php if($advertisementData[0]['advertisement_locationMinDuration'] == "12 mois"){
                                    echo 'selected';
                                }?>>12 mois</option>
                            </select>
                        </div>
                        <!-- Nombre de colocataires déja présent -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="nbOfOtherRoommatePresent">Nombre de
                                colocataires
                                déjà
                                présents</label>
                            <select id="nbOfOtherRoommatePresent" name="nbOfOtherRoommatePresent" class="custom-select">
                                <option value="0" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "0"){
                                    echo 'selected';
                                }?>>0</option>
                                <option value="1" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "1"){
                                    echo 'selected';
                                }?>>1</option>
                                <option value="2" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "2"){
                                    echo 'selected';
                                }?>>2</option>
                                <option value="3" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "3"){
                                    echo 'selected';
                                }?>>3</option>
                                <option value="4" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "4"){
                                    echo 'selected';
                                }?>>4</option>
                                <option value="5" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "5"){
                                    echo 'selected';
                                }?>>5</option>
                                <option value="6" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "6"){
                                    echo 'selected';
                                }?>>6</option>
                                <option value="7" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "7"){
                                    echo 'selected';
                                }?>>7</option>
                                <option value="8" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "8"){
                                    echo 'selected';
                                }?>>8</option>
                                <option value="9" <?php if($advertisementData[0]['advertisement_nbOfOtherRoommatePresent'] == "9"){
                                    echo 'selected';
                                }?>>9</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Colocataire idéal (sexe) -->
                        <div class="form-group col-md-4">
                            <label for="idealRoommateSex" class="font-weight-bold">Colocataire idéal
                                (sexe)</label>
                            <select id="idealRoommateSex" name="idealRoommateSex" class="custom-select">
                                <option value="PeuImporte" <?php if($advertisementData[0]['advertisement_idealRoommateSex'] == "PeuImporte"){
                                    echo 'selected';
                                }?>>Peu importe</option>
                                <option value="Femme" <?php if($advertisementData[0]['advertisement_idealRoommateSex'] == "Femme"){
                                    echo 'selected';
                                }?>>Femme</option>
                                <option value="Homme" <?php if($advertisementData[0]['advertisement_idealRoommateSex'] == "Homme"){
                                    echo 'selected';
                                }?>>Homme</option>
                            </select>
                        </div>
                        <!-- Colocataire idéal (situation) -->
                        <div class="form-group col-md-4">
                            <label for="idealRoommateSituation" class="font-weight-bold">Colocataire idéal
                                (situation)</label>
                            <select id="idealRoommateSituation" name="idealRoommateSituation" class="custom-select">
                                <option value="PeuImporte" <?php if($advertisementData[0]['advertisement_idealRoommateSituation'] == "PeuImporte"){
                                    echo 'selected';
                                }?>>Peu importe</option>
                                <option value="Etudiant" <?php if($advertisementData[0]['advertisement_idealRoommateSituation'] == "Etudiant"){
                                    echo 'selected';
                                }?>>Etudiant(e)</option>
                                <option value="Salarié" <?php if($advertisementData[0]['advertisement_idealRoommateSituation'] == "Salarié"){
                                    echo 'selected';
                                }?>>Salarié(e)</option>
                            </select>
                        </div>
                        <!-- Age minimum -->
                        <div class="form-group col-md-2">
                            <label class="font-weight-bold" for="idealRoommateMinAge">Age minimum</label>
                            <select id="idealRoommateMinAge" name="idealRoommateMinAge" class="custom-select">
                                <option value="18" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "18"){
                                    echo 'selected';
                                }?>>18</option>
                                <option value="19" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "19"){
                                    echo 'selected';
                                }?>>19</option>
                                <option value="20" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "20"){
                                    echo 'selected';
                                }?>>20</option>
                                <option value="21" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "21"){
                                    echo 'selected';
                                }?>>21</option>
                                <option value="22" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "22"){
                                    echo 'selected';
                                }?>>22</option>
                                <option value="23" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "23"){
                                    echo 'selected';
                                }?>>23</option>
                                <option value="24" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "24"){
                                    echo 'selected';
                                }?>>24</option>
                                <option value="25" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "25"){
                                    echo 'selected';
                                }?>>25</option>
                                <option value="26" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "26"){
                                    echo 'selected';
                                }?>>26</option>
                                <option value="27" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "27"){
                                    echo 'selected';
                                }?>>27</option>
                                <option value="28" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "28"){
                                    echo 'selected';
                                }?>>28</option>
                                <option value="29" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "29"){
                                    echo 'selected';
                                }?>>29</option>
                                <option value="30" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "30"){
                                    echo 'selected';
                                }?>>30</option>
                                <option value="31" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "31"){
                                    echo 'selected';
                                }?>>31</option>
                                <option value="32" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "32"){
                                    echo 'selected';
                                }?>>32</option>
                                <option value="33" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "33"){
                                    echo 'selected';
                                }?>>33</option>
                                <option value="34" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "34"){
                                    echo 'selected';
                                }?>>34</option>
                                <option value="35" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "35"){
                                    echo 'selected';
                                }?>>35</option>
                                <option value="36" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "36"){
                                    echo 'selected';
                                }?>>36</option>
                                <option value="37" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "37"){
                                    echo 'selected';
                                }?>>37</option>
                                <option value="38" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "38"){
                                    echo 'selected';
                                }?>>38</option>
                                <option value="39" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "39"){
                                    echo 'selected';
                                }?>>39</option>
                                <option value="40" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "40"){
                                    echo 'selected';
                                }?>>40</option>
                                <option value="41" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "41"){
                                    echo 'selected';
                                }?>>41</option>
                                <option value="42" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "42"){
                                    echo 'selected';
                                }?>>42</option>
                                <option value="43" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "43"){
                                    echo 'selected';
                                }?>>43</option>
                                <option value="44" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "44"){
                                    echo 'selected';
                                }?>>44</option>
                                <option value="45" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "45"){
                                    echo 'selected';
                                }?>>45</option>
                                <option value="46" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "46"){
                                    echo 'selected';
                                }?>>46</option>
                                <option value="47" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "47"){
                                    echo 'selected';
                                }?>>47</option>
                                <option value="48" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "48"){
                                    echo 'selected';
                                }?>>48</option>
                                <option value="49" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "49"){
                                    echo 'selected';
                                }?>>49</option>
                                <option value="50" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "50"){
                                    echo 'selected';
                                }?>>50</option>
                                <option value="51" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "51"){
                                    echo 'selected';
                                }?>>51</option>
                                <option value="52" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "52"){
                                    echo 'selected';
                                }?>>52</option>
                                <option value="53" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "53"){
                                    echo 'selected';
                                }?>>53</option>
                                <option value="54" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "54"){
                                    echo 'selected';
                                }?>>54</option>
                                <option value="55" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "55"){
                                    echo 'selected';
                                }?>>55</option>
                                <option value="56" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "56"){
                                    echo 'selected';
                                }?>>56</option>
                                <option value="57" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "57"){
                                    echo 'selected';
                                }?>>57</option>
                                <option value="58" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "58"){
                                    echo 'selected';
                                }?>>58</option>
                                <option value="59" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "59"){
                                    echo 'selected';
                                }?>>59</option>
                                <option value="60" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "60"){
                                    echo 'selected';
                                }?>>60</option>
                                <option value="61" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "61"){
                                    echo 'selected';
                                }?>>61</option>
                                <option value="62" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "62"){
                                    echo 'selected';
                                }?>>62</option>
                                <option value="63" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "63"){
                                    echo 'selected';
                                }?>>63</option>
                                <option value="64" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "64"){
                                    echo 'selected';
                                }?>>64</option>
                                <option value="65" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "65"){
                                    echo 'selected';
                                }?>>65</option>
                                <option value="66" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "66"){
                                    echo 'selected';
                                }?>>66</option>
                                <option value="67" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "67"){
                                    echo 'selected';
                                }?>>67</option>
                                <option value="68" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "68"){
                                    echo 'selected';
                                }?>>68</option>
                                <option value="69" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "69"){
                                    echo 'selected';
                                }?>>69</option>
                                <option value="70" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "70"){
                                    echo 'selected';
                                }?>>70</option>
                                <option value="71" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "71"){
                                    echo 'selected';
                                }?>>71</option>
                                <option value="72" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "72"){
                                    echo 'selected';
                                }?>>72</option>
                                <option value="73" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "73"){
                                    echo 'selected';
                                }?>>73</option>
                                <option value="74" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "74"){
                                    echo 'selected';
                                }?>>74</option>
                                <option value="75" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "75"){
                                    echo 'selected';
                                }?>>75</option>
                                <option value="76" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "76"){
                                    echo 'selected';
                                }?>>76</option>
                                <option value="77" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "77"){
                                    echo 'selected';
                                }?>>77</option>
                                <option value="78" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "78"){
                                    echo 'selected';
                                }?>>78</option>
                                <option value="79" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "79"){
                                    echo 'selected';
                                }?>>79</option>
                                <option value="80" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "80"){
                                    echo 'selected';
                                }?>>80</option>
                                <option value="81" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "81"){
                                    echo 'selected';
                                }?>>81</option>
                                <option value="82" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "82"){
                                    echo 'selected';
                                }?>>82</option>
                                <option value="83" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "83"){
                                    echo 'selected';
                                }?>>83</option>
                                <option value="84" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "84"){
                                    echo 'selected';
                                }?>>84</option>
                                <option value="85" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "85"){
                                    echo 'selected';
                                }?>>85</option>
                                <option value="86" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "86"){
                                    echo 'selected';
                                }?>>86</option>
                                <option value="87" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "87"){
                                    echo 'selected';
                                }?>>87</option>
                                <option value="88" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "88"){
                                    echo 'selected';
                                }?>>88</option>
                                <option value="89" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "89"){
                                    echo 'selected';
                                }?>>89</option>
                                <option value="90" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "90"){
                                    echo 'selected';
                                }?>>90</option>
                                <option value="91" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "91"){
                                    echo 'selected';
                                }?>>91</option>
                                <option value="92" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "92"){
                                    echo 'selected';
                                }?>>92</option>
                                <option value="93" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "93"){
                                    echo 'selected';
                                }?>>93</option>
                                <option value="94" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "94"){
                                    echo 'selected';
                                }?>>94</option>
                                <option value="95" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "95"){
                                    echo 'selected';
                                }?>>95</option>
                                <option value="96" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "96"){
                                    echo 'selected';
                                }?>>96</option>
                                <option value="97" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "97"){
                                    echo 'selected';
                                }?>>97</option>
                                <option value="98" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "98"){
                                    echo 'selected';
                                }?>>98</option>
                                <option value="99" <?php if($advertisementData[0]['advertisement_idealRoommateMinAge'] == "99"){
                                    echo 'selected';
                                }?>>99</option>
                            </select>
                        </div>
                        <!-- Age maximum -->
                        <div class="form-group col-md-2">
                            <label class="font-weight-bold" for="idealRoommateMaxAge">Age maximum</label>
                            <select id="idealRoommateMaxAge" name="idealRoommateMaxAge" class="custom-select">
                                <option value="18" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "18"){
                                    echo 'selected';
                                }?>>18</option>
                                <option value="19" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "19"){
                                    echo 'selected';
                                }?>>19</option>
                                <option value="20" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "20"){
                                    echo 'selected';
                                }?>>20</option>
                                <option value="21" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "21"){
                                    echo 'selected';
                                }?>>21</option>
                                <option value="22" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "22"){
                                    echo 'selected';
                                }?>>22</option>
                                <option value="23" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "23"){
                                    echo 'selected';
                                }?>>23</option>
                                <option value="24" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "24"){
                                    echo 'selected';
                                }?>>24</option>
                                <option value="25" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "25"){
                                    echo 'selected';
                                }?>>25</option>
                                <option value="26" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "26"){
                                    echo 'selected';
                                }?>>26</option>
                                <option value="27" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "27"){
                                    echo 'selected';
                                }?>>27</option>
                                <option value="28" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "28"){
                                    echo 'selected';
                                }?>>28</option>
                                <option value="29" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "29"){
                                    echo 'selected';
                                }?>>29</option>
                                <option value="30" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "30"){
                                    echo 'selected';
                                }?>>30</option>
                                <option value="31" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "31"){
                                    echo 'selected';
                                }?>>31</option>
                                <option value="32" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "32"){
                                    echo 'selected';
                                }?>>32</option>
                                <option value="33" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "33"){
                                    echo 'selected';
                                }?>>33</option>
                                <option value="34" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "34"){
                                    echo 'selected';
                                }?>>34</option>
                                <option value="35" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "35"){
                                    echo 'selected';
                                }?>>35</option>
                                <option value="36" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "36"){
                                    echo 'selected';
                                }?>>36</option>
                                <option value="37" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "37"){
                                    echo 'selected';
                                }?>>37</option>
                                <option value="38" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "38"){
                                    echo 'selected';
                                }?>>38</option>
                                <option value="39" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "39"){
                                    echo 'selected';
                                }?>>39</option>
                                <option value="40" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "40"){
                                    echo 'selected';
                                }?>>40</option>
                                <option value="41" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "41"){
                                    echo 'selected';
                                }?>>41</option>
                                <option value="42" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "42"){
                                    echo 'selected';
                                }?>>42</option>
                                <option value="43" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "43"){
                                    echo 'selected';
                                }?>>43</option>
                                <option value="44" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "44"){
                                    echo 'selected';
                                }?>>44</option>
                                <option value="45" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "45"){
                                    echo 'selected';
                                }?>>45</option>
                                <option value="46" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "46"){
                                    echo 'selected';
                                }?>>46</option>
                                <option value="47" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "47"){
                                    echo 'selected';
                                }?>>47</option>
                                <option value="48" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "48"){
                                    echo 'selected';
                                }?>>48</option>
                                <option value="49" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "49"){
                                    echo 'selected';
                                }?>>49</option>
                                <option value="50" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "50"){
                                    echo 'selected';
                                }?>>50</option>
                                <option value="51" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "51"){
                                    echo 'selected';
                                }?>>51</option>
                                <option value="52" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "52"){
                                    echo 'selected';
                                }?>>52</option>
                                <option value="53" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "53"){
                                    echo 'selected';
                                }?>>53</option>
                                <option value="54" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "54"){
                                    echo 'selected';
                                }?>>54</option>
                                <option value="55" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "55"){
                                    echo 'selected';
                                }?>>55</option>
                                <option value="56" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "56"){
                                    echo 'selected';
                                }?>>56</option>
                                <option value="57" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "57"){
                                    echo 'selected';
                                }?>>57</option>
                                <option value="58" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "58"){
                                    echo 'selected';
                                }?>>58</option>
                                <option value="59" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "59"){
                                    echo 'selected';
                                }?>>59</option>
                                <option value="60" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "60"){
                                    echo 'selected';
                                }?>>60</option>
                                <option value="61" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "61"){
                                    echo 'selected';
                                }?>>61</option>
                                <option value="62" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "62"){
                                    echo 'selected';
                                }?>>62</option>
                                <option value="63" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "63"){
                                    echo 'selected';
                                }?>>63</option>
                                <option value="64" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "64"){
                                    echo 'selected';
                                }?>>64</option>
                                <option value="65" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "65"){
                                    echo 'selected';
                                }?>>65</option>
                                <option value="66" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "66"){
                                    echo 'selected';
                                }?>>66</option>
                                <option value="67" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "67"){
                                    echo 'selected';
                                }?>>67</option>
                                <option value="68" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "68"){
                                    echo 'selected';
                                }?>>68</option>
                                <option value="69" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "69"){
                                    echo 'selected';
                                }?>>69</option>
                                <option value="70" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "70"){
                                    echo 'selected';
                                }?>>70</option>
                                <option value="71" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "71"){
                                    echo 'selected';
                                }?>>71</option>
                                <option value="72" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "72"){
                                    echo 'selected';
                                }?>>72</option>
                                <option value="73" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "73"){
                                    echo 'selected';
                                }?>>73</option>
                                <option value="74" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "74"){
                                    echo 'selected';
                                }?>>74</option>
                                <option value="75" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "75"){
                                    echo 'selected';
                                }?>>75</option>
                                <option value="76" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "76"){
                                    echo 'selected';
                                }?>>76</option>
                                <option value="77" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "77"){
                                    echo 'selected';
                                }?>>77</option>
                                <option value="78" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "78"){
                                    echo 'selected';
                                }?>>78</option>
                                <option value="79" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "79"){
                                    echo 'selected';
                                }?>>79</option>
                                <option value="80" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "80"){
                                    echo 'selected';
                                }?>>80</option>
                                <option value="81" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "81"){
                                    echo 'selected';
                                }?>>81</option>
                                <option value="82" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "82"){
                                    echo 'selected';
                                }?>>82</option>
                                <option value="83" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "83"){
                                    echo 'selected';
                                }?>>83</option>
                                <option value="84" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "84"){
                                    echo 'selected';
                                }?>>84</option>
                                <option value="85" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "85"){
                                    echo 'selected';
                                }?>>85</option>
                                <option value="86" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "86"){
                                    echo 'selected';
                                }?>>86</option>
                                <option value="87" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "87"){
                                    echo 'selected';
                                }?>>87</option>
                                <option value="88" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "88"){
                                    echo 'selected';
                                }?>>88</option>
                                <option value="89" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "89"){
                                    echo 'selected';
                                }?>>89</option>
                                <option value="90" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "90"){
                                    echo 'selected';
                                }?>>90</option>
                                <option value="91" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "91"){
                                    echo 'selected';
                                }?>>91</option>
                                <option value="92" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "92"){
                                    echo 'selected';
                                }?>>92</option>
                                <option value="93" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "93"){
                                    echo 'selected';
                                }?>>93</option>
                                <option value="94" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "94"){
                                    echo 'selected';
                                }?>>94</option>
                                <option value="95" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "95"){
                                    echo 'selected';
                                }?>>95</option>
                                <option value="96" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "96"){
                                    echo 'selected';
                                }?>>96</option>
                                <option value="97" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "97"){
                                    echo 'selected';
                                }?>>97</option>
                                <option value="98" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "98"){
                                    echo 'selected';
                                }?>>98</option>
                                <option value="99" <?php if($advertisementData[0]['advertisement_idealRoommateMaxAge'] == "99"){
                                    echo 'selected';
                                }?>>99</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ----------LOYER---------- -->
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Loyer</h2>
                <div class="container">
                    <div class="row">
                        <!-- Montant HC -->
                        <div class="form-group col-md-4" title="Loyer Hors Charges">
                            <label class="font-weight-bold" for="monthlyRentExcludingCharges">Loyer mensuel HC</label>
                            <div id="monthlyRentExcludingChargesDiv" class="input-group mb-3">
                                <input id="monthlyRentExcludingCharges" type="number" min="0"
                                    name="monthlyRentExcludingCharges" class="form-control"
                                    aria-describedby="basic-addon2"
                                    value="<?=$advertisementData[0]['advertisement_monthlyRentExcludingCharges']?>"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                            </div>
                        </div>
                        <!-- Montant des charges -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="charges">Montant des charges</label>
                            <div id="chargesDiv" class="input-group mb-3">
                                <input id="charges" type="number" min="0" name="charges" class="form-control"
                                    aria-describedby="basic-addon2"
                                    value="<?=$advertisementData[0]['advertisement_charges']?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                            </div>
                        </div>
                        <!-- Montant de la caution -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="suretyBond">Montant de la caution</label>
                            <div id="suretyBondDiv" class="input-group mb-3">
                                <input id="suretyBond" type="number" min="0" name="suretyBond" class="form-control"
                                    aria-describedby="basic-addon2"
                                    value="<?=$advertisementData[0]['advertisement_suretyBond']?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">&#8364</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Le garant doit résider -->
                        <div class="form-group col-md-4">
                            <label for="guarantorLiving" class="font-weight-bold">Le garant doit résider</label>
                            <select id="guarantorLiving" name="guarantorLiving" class="custom-select">
                                <option value="France"
                                    <?php if($advertisementData[0]['advertisement_guarantorLiving'] == "France"){echo 'selected';}?>>
                                    France</option>
                                <option value="Europe"
                                    <?php if($advertisementData[0]['advertisement_guarantorLiving'] == "Europe"){echo 'selected';}?>>
                                    Europe</option>
                                <option value="PeuImporte"
                                    <?php if($advertisementData[0]['advertisement_guarantorLiving'] == "PeuImporte"){echo 'selected';}?>>
                                    Peu importe</option>
                            </select>
                        </div>
                        <!-- Ratio de solvabilité -->
                        <div class="form-group col-md-4" title="A combien de loyers le revenu doit-il être supérieur?">
                            <label for="solvencyRatio" class="font-weight-bold">Ratio de solvabilité</label>
                            <select id="solvencyRatio" name="solvencyRatio" class="custom-select">
                                <option value="PeuImporte" selected>Peu importe</option>
                                <option value="1X"
                                    <?php if($advertisementData[0]['advertisement_solvencyRatio'] == "1X"){echo 'selected';}?>>
                                    1X</option>
                                <option value="1.5X"
                                    <?php if($advertisementData[0]['advertisement_solvencyRatio'] == "1.5X"){echo 'selected';}?>>
                                    1.5X</option>
                                <option value="2X"
                                    <?php if($advertisementData[0]['advertisement_solvencyRatio'] == "2X"){echo 'selected';}?>>
                                    2X</option>
                                <option value="2.5X"
                                    <?php if($advertisementData[0]['advertisement_solvencyRatio'] == "2.5X"){echo 'selected';}?>>
                                    2.5X</option>
                                <option value="3X"
                                    <?php if($advertisementData[0]['advertisement_solvencyRatio'] == "3X"){echo 'selected';}?>>
                                    3X</option>
                                <option value="4X"
                                    <?php if($advertisementData[0]['advertisement_solvencyRatio'] == "4X"){echo 'selected';}?>>
                                    4X</option>
                                <option value="5X"
                                    <?php if($advertisementData[0]['advertisement_solvencyRatio'] == "5X"){echo 'selected';}?>>
                                    5X</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Exigences financières -->
                        <div class="form-group col-md-4" title="J'ai des exigences financières pour le candidat">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="financialRequirements"
                                    name="financialRequirements"
                                    <?php if($advertisementData[0]['advertisement_financialRequirements']){echo 'checked';}?>>
                                <label class="custom-control-label font-weight-bold"
                                    for="financialRequirements">Exigences financières</label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="eligibleForAids"
                                    name="eligibleForAids"
                                    <?php if($advertisementData[0]['advertisement_eligibleForAids']){echo 'checked';}?>>
                                <label class="custom-control-label font-weight-bold" for="eligibleForAids">Eligible aux
                                    aides (apl,...)</label>
                            </div>
                        </div>
                    </div>
                    <h3 class="pt-3">Inclus dans les charges:</h3>
                    <div class="row">
                        <!-- Electricité -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeElectricity"
                                    name="chargesIncludeElectricity"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeElectricity']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeElectricity">Electricité</label>
                            </div>
                        </div>
                        <!-- Eau chaude -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHotWater"
                                    name="chargesIncludeHotWater"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeHotWater']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeHotWater">Eau
                                    chaude</label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHeating"
                                    name="chargesIncludeHeating"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeHeating']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeHeating">Chauffage</label>
                            </div>
                        </div>
                        <!-- Internet -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeInternet"
                                    name="chargesIncludeInternet"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeInternet']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeInternet">Internet</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Charges de co-propriété -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="chargesIncludeCoOwnershipCharges" name="chargesIncludeCoOwnershipCharges"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeCoOwnershipCharges']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeCoOwnershipCharges">Charges de
                                    co-propriété</label>
                            </div>
                        </div>
                        <!-- Assurance habitation -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHomeInsurance"
                                    name="chargesIncludeHomeInsurance"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeHomeInsurance']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeHomeInsurance">Assurance
                                    habitation</label>
                            </div>
                        </div>
                        <!-- Révision chaudière -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeBoilerInspection"
                                    name="chargesIncludeBoilerInspection"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeBoilerInspection']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeBoilerInspection">Révision
                                    chaudière</label>
                            </div>
                        </div>
                        <!-- Taxe d'ordures ménagères -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="chargesIncludeHouseholdGarbageTaxes" name="chargesIncludeHouseholdGarbageTaxes"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeHouseholdGarbageTaxes']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeHouseholdGarbageTaxes">Taxe
                                    d'ordures ménagères</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Service de nettoyage -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeCleaningService"
                                    name="chargesIncludeCleaningService"
                                    <?php if($advertisementData[0]['advertisement_chargesIncludeCleaningService']){echo 'checked';}?>>
                                <label class="custom-control-label" for="chargesIncludeCleaningService">Service de
                                    nettoyage</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ---------- LOGEMENT ---------- -->
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Logement</h2>
                <div class="container">
                    <!-- Adresse -->
                    <div class="form-group" title="Numéro, nom de rue">
                        <label for="street" class="font-weight-bold">Numéro et nom de rue</label>
                        <input id="street" type="text" name="street" class="form-control"
                            placeholder="Saisir l'adresse du logement"
                            value="<?=$advertisementData[0]['address_street']?>" maxlength="255" required>
                    </div>
                    <!-- Code postal, ville, pays -->
                    <div class="row">
                        <!-- Code postal -->
                        <div class="form-group col-md-2" title="Code postal">
                            <label for="zipcode" class="font-weight-bold">Code postal</label>
                            <input id="zipcode" type="text" name="zipcode" class="form-control"
                                placeholder="Code postal" value="<?=$advertisementData[0]['address_zipcode']?>"
                                maxlength="20" required>
                        </div>
                        <!-- Ville -->
                        <div class="form-group col-md-6" title="Ville">
                            <label for="city" class="font-weight-bold">Ville</label>
                            <input id="city" type="text" name="city" class="form-control" placeholder="Ville"
                                value="<?=$advertisementData[0]['address_city']?>" maxlength="60" required>
                        </div>
                        <!-- Pays -->
                        <div class="form-group col-md-4" title="Pays">
                            <label for="country" class="font-weight-bold">Pays</label>
                            <input id="country" type="text" name="country" class="form-control" placeholder="Pays"
                                value="<?=$advertisementData[0]['address_country']?>" maxlength="60" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Surface habitable -->
                        <div class="form-group col-md-4" title="Surface totale du logement">
                            <label class="font-weight-bold" for="accomodationLivingAreaSize">Surface habitable du
                                logement</label>
                            <div id="accomodationLivingAreaSizeDiv" class="input-group mb-3">
                                <input id="accomodationLivingAreaSize" type="number" min="1"
                                    name="accomodationLivingAreaSize" class="form-control"
                                    aria-describedby="basic-addon2"
                                    value="<?=$advertisementData[0]['advertisement_accomodationLivingAreaSize']?>"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m²</span>
                                </div>
                            </div>
                        </div>
                        <!-- Etage du logement -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="accomodationFloor">Etage du logement</label>
                            <select id="accomodationFloor" name="accomodationFloor" class="custom-select">
                                <option value="0" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "0"){
                                    echo 'selected';
                                }?>>0</option>
                                <option value="1" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "1"){
                                    echo 'selected';
                                }?>>1</option>
                                <option value="2" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "2"){
                                    echo 'selected';
                                }?>>2</option>
                                <option value="3" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "3"){
                                    echo 'selected';
                                }?>>3</option>
                                <option value="4" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "4"){
                                    echo 'selected';
                                }?>>4</option>
                                <option value="5" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "5"){
                                    echo 'selected';
                                }?>>5</option>
                                <option value="6" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "6"){
                                    echo 'selected';
                                }?>>6</option>
                                <option value="7" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "7"){
                                    echo 'selected';
                                }?>>7</option>
                                <option value="8" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "8"){
                                    echo 'selected';
                                }?>>8</option>
                                <option value="9" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "9"){
                                    echo 'selected';
                                }?>>9</option>
                                <option value="10" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "10"){
                                    echo 'selected';
                                }?>>10</option>
                                <option value="11" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "11"){
                                    echo 'selected';
                                }?>>11</option>
                                <option value="12" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "12"){
                                    echo 'selected';
                                }?>>12</option>
                                <option value="13" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "13"){
                                    echo 'selected';
                                }?>>13</option>
                                <option value="14" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "14"){
                                    echo 'selected';
                                }?>>14</option>
                                <option value="15" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "15"){
                                    echo 'selected';
                                }?>>15</option>
                                <option value="16" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "16"){
                                    echo 'selected';
                                }?>>16</option>
                                <option value="17" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "17"){
                                    echo 'selected';
                                }?>>17</option>
                                <option value="18" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "18"){
                                    echo 'selected';
                                }?>>18</option>
                                <option value="19" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "19"){
                                    echo 'selected';
                                }?>>19</option>
                                <option value="20" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "20"){
                                    echo 'selected';
                                }?>>20</option>
                                <option value="21" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "21"){
                                    echo 'selected';
                                }?>>21</option>
                                <option value="22" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "22"){
                                    echo 'selected';
                                }?>>22</option>
                                <option value="23" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "23"){
                                    echo 'selected';
                                }?>>23</option>
                                <option value="24" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "24"){
                                    echo 'selected';
                                }?>>24</option>
                                <option value="25" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "25"){
                                    echo 'selected';
                                }?>>25</option>
                                <option value="26" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "26"){
                                    echo 'selected';
                                }?>>26</option>
                                <option value="27" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "27"){
                                    echo 'selected';
                                }?>>27</option>
                                <option value="28" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "28"){
                                    echo 'selected';
                                }?>>28</option>
                                <option value="29" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "29"){
                                    echo 'selected';
                                }?>>29</option>
                                <option value="30" <?php if($advertisementData[0]['advertisement_accomodationFloor'] == "30"){
                                    echo 'selected';
                                }?>>30</option>
                            </select>
                        </div>
                        <!-- Nombre d'étages -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="buildingNbOfFloors">Nombre d'etages (immeuble)</label>
                            <select id="buildingNbOfFloors" name="buildingNbOfFloors" class="custom-select">
                                <option value="0" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "0"){
                                    echo 'selected';
                                }?>>0</option>
                                <option value="1" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "1"){
                                    echo 'selected';
                                }?>>1</option>
                                <option value="2" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "2"){
                                    echo 'selected';
                                }?>>2</option>
                                <option value="3" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "3"){
                                    echo 'selected';
                                }?>>3</option>
                                <option value="4" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "4"){
                                    echo 'selected';
                                }?>>4</option>
                                <option value="5" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "5"){
                                    echo 'selected';
                                }?>>5</option>
                                <option value="6" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "6"){
                                    echo 'selected';
                                }?>>6</option>
                                <option value="7" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "7"){
                                    echo 'selected';
                                }?>>7</option>
                                <option value="8" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "8"){
                                    echo 'selected';
                                }?>>8</option>
                                <option value="9" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "9"){
                                    echo 'selected';
                                }?>>9</option>
                                <option value="10" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "10"){
                                    echo 'selected';
                                }?>>10</option>
                                <option value="11" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "11"){
                                    echo 'selected';
                                }?>>11</option>
                                <option value="12" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "12"){
                                    echo 'selected';
                                }?>>12</option>
                                <option value="13" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "13"){
                                    echo 'selected';
                                }?>>13</option>
                                <option value="14" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "14"){
                                    echo 'selected';
                                }?>>14</option>
                                <option value="15" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "15"){
                                    echo 'selected';
                                }?>>15</option>
                                <option value="16" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "16"){
                                    echo 'selected';
                                }?>>16</option>
                                <option value="17" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "17"){
                                    echo 'selected';
                                }?>>17</option>
                                <option value="18" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "18"){
                                    echo 'selected';
                                }?>>18</option>
                                <option value="19" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "19"){
                                    echo 'selected';
                                }?>>19</option>
                                <option value="20" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "20"){
                                    echo 'selected';
                                }?>>20</option>
                                <option value="21" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "21"){
                                    echo 'selected';
                                }?>>21</option>
                                <option value="22" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "22"){
                                    echo 'selected';
                                }?>>22</option>
                                <option value="23" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "23"){
                                    echo 'selected';
                                }?>>23</option>
                                <option value="24" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "24"){
                                    echo 'selected';
                                }?>>24</option>
                                <option value="25" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "25"){
                                    echo 'selected';
                                }?>>25</option>
                                <option value="26" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "26"){
                                    echo 'selected';
                                }?>>26</option>
                                <option value="27" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "27"){
                                    echo 'selected';
                                }?>>27</option>
                                <option value="28" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "28"){
                                    echo 'selected';
                                }?>>28</option>
                                <option value="29" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "29"){
                                    echo 'selected';
                                }?>>29</option>
                                <option value="30" <?php if($advertisementData[0]['advertisement_buildingNbOfFloors'] == "30"){
                                    echo 'selected';
                                }?>>30</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Nombre de pièces -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="accomodationNbOfRooms">Nombre de pièces</label>
                            <select id="accomodationNbOfRooms" name="accomodationNbOfRooms" class="custom-select">
                                <option value="0" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "0"){
                                    echo 'selected';
                                }?>>0</option>
                                <option value="1" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "1"){
                                    echo 'selected';
                                }?>>1</option>
                                <option value="2" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "2"){
                                    echo 'selected';
                                }?>>2</option>
                                <option value="3" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "3"){
                                    echo 'selected';
                                }?>>3</option>
                                <option value="4" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "4"){
                                    echo 'selected';
                                }?>>4</option>
                                <option value="5" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "5"){
                                    echo 'selected';
                                }?>>5</option>
                                <option value="6" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "6"){
                                    echo 'selected';
                                }?>>6</option>
                                <option value="7" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "7"){
                                    echo 'selected';
                                }?>>7</option>
                                <option value="8" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "8"){
                                    echo 'selected';
                                }?>>8</option>
                                <option value="9" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "9"){
                                    echo 'selected';
                                }?>>9</option>
                                <option value="10" <?php if($advertisementData[0]['advertisement_accomodationNbOfRooms'] == "10"){
                                    echo 'selected';
                                }?>>10</option>
                            </select>
                        </div>
                        <!-- Nombre de chambres -->
                        <div class="form-group col-md-4" title="Nombre de chambres que contient au total le logement">
                            <label class="font-weight-bold" for="accomodationNbOfBedrooms">Nombre de chambres</label>
                            <select id="accomodationNbOfBedrooms" name="accomodationNbOfBedrooms" class="custom-select">
                                <option value="0" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "0"){
                                    echo 'selected';
                                }?>>0</option>
                                <option value="1" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "1"){
                                    echo 'selected';
                                }?>>1</option>
                                <option value="2" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "2"){
                                    echo 'selected';
                                }?>>2</option>
                                <option value="3" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "3"){
                                    echo 'selected';
                                }?>>3</option>
                                <option value="4" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "4"){
                                    echo 'selected';
                                }?>>4</option>
                                <option value="5" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "5"){
                                    echo 'selected';
                                }?>>5</option>
                                <option value="6" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "6"){
                                    echo 'selected';
                                }?>>6</option>
                                <option value="7" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "7"){
                                    echo 'selected';
                                }?>>7</option>
                                <option value="8" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "8"){
                                    echo 'selected';
                                }?>>8</option>
                                <option value="9" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "9"){
                                    echo 'selected';
                                }?>>9</option>
                                <option value="10" <?php if($advertisementData[0]['advertisement_accomodationNbOfBedrooms'] == "10"){
                                    echo 'selected';
                                }?>>10</option>
                            </select>
                        </div>
                        <!-- Nombre de salles de bains -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="accomodationNbOfBathrooms">Nombre de salles de
                                bain</label>
                            <select id="accomodationNbOfBathrooms" name="accomodationNbOfBathrooms"
                                class="custom-select">
                                <option value="0" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "0"){
                                    echo 'selected';
                                }?>>0</option>
                                <option value="1" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "1"){
                                    echo 'selected';
                                }?>>1</option>
                                <option value="2" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "2"){
                                    echo 'selected';
                                }?>>2</option>
                                <option value="3" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "3"){
                                    echo 'selected';
                                }?>>3</option>
                                <option value="4" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "4"){
                                    echo 'selected';
                                }?>>4</option>
                                <option value="5" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "5"){
                                    echo 'selected';
                                }?>>5</option>
                                <option value="6" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "6"){
                                    echo 'selected';
                                }?>>6</option>
                                <option value="7" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "7"){
                                    echo 'selected';
                                }?>>7</option>
                                <option value="8" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "8"){
                                    echo 'selected';
                                }?>>8</option>
                                <option value="9" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "9"){
                                    echo 'selected';
                                }?>>9</option>
                                <option value="10" <?php if($advertisementData[0]['advertisement_accomodationNbOfBathrooms'] == "10"){
                                    echo 'selected';
                                }?>>10</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Nombre de chambres à louer-->
                        <div class="form-group col-md-4" title="Nombre de chambres disponibles">
                            <label class="font-weight-bold" for="nbOfBedroomsToRent">Nombre de chambres à louer</label>
                            <select id="nbOfBedroomsToRent" name="nbOfBedroomsToRent" class="custom-select">
                                <option value="0" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "0"){
                                    echo 'selected';
                                }?>>0</option>
                                <option value="1" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "1"){
                                    echo 'selected';
                                }?>>1</option>
                                <option value="2" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "2"){
                                    echo 'selected';
                                }?>>2</option>
                                <option value="3" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "3"){
                                    echo 'selected';
                                }?>>3</option>
                                <option value="4" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "4"){
                                    echo 'selected';
                                }?>>4</option>
                                <option value="5" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "5"){
                                    echo 'selected';
                                }?>>5</option>
                                <option value="6" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "6"){
                                    echo 'selected';
                                }?>>6</option>
                                <option value="7" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "7"){
                                    echo 'selected';
                                }?>>7</option>
                                <option value="8" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "8"){
                                    echo 'selected';
                                }?>>8</option>
                                <option value="9" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "9"){
                                    echo 'selected';
                                }?>>9</option>
                                <option value="10" <?php if($advertisementData[0]['advertisement_nbOfBedroomsToRent'] == "10"){
                                    echo 'selected';
                                }?>>10</option>
                            </select>
                        </div>
                        <!-- Utilisation de la cuisine -->
                        <div class="form-group col-md-4">
                            <label for="kitchenUse" class="font-weight-bold">Utilisation de la cuisine</label>
                            <select id="kitchenUse" name="kitchenUse" class="custom-select">
                                <option value="Commun"
                                    <?php if($advertisementData[0]['advertisement_kitchenUse'] == "Commun"){echo 'selected';}?>>
                                    Commun</option>
                                <option value="Privée"
                                    <?php if($advertisementData[0]['advertisement_kitchenUse'] == "Privée"){echo 'selected';}?>>
                                    Privée</option>
                            </select>
                        </div>
                        <!-- Utilisation du salon -->
                        <div class="form-group col-md-4">
                            <label for="livingRoomUse" class="font-weight-bold">Utilisation du salon</label>
                            <select id="livingRoomUse" name="livingRoomUse" class="custom-select">
                                <option value="Commun"
                                    <?php if($advertisementData[0]['advertisement_livingRoomUse'] == "Commun"){echo 'selected';}?>>
                                    Commun</option>
                                <option value="Privée"
                                    <?php if($advertisementData[0]['advertisement_livingRoomUse'] == "Privée"){echo 'selected';}?>>
                                    Privée</option>
                                <option value="Aucun"
                                    <?php if($advertisementData[0]['advertisement_livingRoomUse'] == "Aucun"){echo 'selected';}?>>
                                    Aucun</option>
                            </select>
                        </div>
                    </div>
                    <!-- Classe Energie -->
                    <div class="row">
                        <!--Performance energetique -->
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold" for="EnergeticPerformance">Diagnostic de performance
                                énergétique</label>
                            <div id="EnergeticPerformance" class="input-group mb-3">
                                <input id="energyClassNumber" type="number" min="1" name="energyClassNumber"
                                    class="form-control" placeholder="0" aria-describedby="basic-addon2"
                                    value="<?=$advertisementData[0]['advertisement_energyClassNumber']?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">kWhEp/m²/an</span>
                                </div>
                                <div class="input-group-append  ">
                                    <span id="energyClassLetterView" class="input-group-text"
                                        id="basic-addon2"><?=$advertisementData[0]['advertisement_energyClassLetter']?></span>
                                </div>
                                <input id="energyClassLetterInput" type="hidden" name="energyClassLetter"
                                    class="form-control"
                                    value="<?=$advertisementData[0]['advertisement_energyClassLetter']?>">
                            </div>
                        </div>
                        <!-- Ges -->
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold" for="EnergeticGes">Emissions de gaz à effet de serre</label>
                            <div id="EnergeticGes" class="input-group mb-3">
                                <input id="gesNumber" type="number" min="1" name="gesNumber" class="form-control"
                                    placeholder="0" aria-describedby="basic-addon2"
                                    value="<?=$advertisementData[0]['advertisement_gesNumber']?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">kgeqCO2/m²/an</span>
                                </div>
                                <div class="input-group-append">
                                    <span id="gesLetterView" class="input-group-text"
                                        id="basic-addon2"><?=$advertisementData[0]['advertisement_gesLetter']?></span>
                                </div>
                                <input id="gesLetterInput" type="hidden" name="gesLetter" class="form-control"
                                    value="<?=$advertisementData[0]['advertisement_gesLetter']?>">
                            </div>
                        </div>
                    </div>
                    <h3>Le logement comprend:</h3>
                    <div class="row">
                        <!-- Accès handicapé -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="handicapedAccessibility"
                                    name="handicapedAccessibility"
                                    <?php if($advertisementData[0]['advertisement_handicapedAccessibility']){echo 'checked';}?>>
                                <label class="custom-control-label " for="handicapedAccessibility">Accès
                                    handicapé</label>
                            </div>
                        </div>
                        <!-- Ascenceur -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasElevator"
                                    name="accomodationHasElevator"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasElevator']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasElevator">Ascenceur</label>
                            </div>
                        </div>
                        <!-- Parking commun -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasCommonParkingLot"
                                    name="accomodationHasCommonParkingLot"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasCommonParkingLot']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasCommonParkingLot">Parking
                                    commun</label>
                            </div>
                        </div>
                        <!-- Place de parking privée -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasPrivateParkingPlace" name="accomodationHasPrivateParkingPlace"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasPrivateParkingPlace']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasPrivateParkingPlace">Place de
                                    parking privée</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Jardin -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasGarden"
                                    name="accomodationHasGarden"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasGarden']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasGarden">Jardin</label>
                            </div>
                        </div>
                        <!-- Balcon -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasBalcony"
                                    name="accomodationHasBalcony"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasBalcony']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasBalcony">Balcon</label>
                            </div>
                        </div>
                        <!-- Terrasse -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasTerrace"
                                    name="accomodationHasTerrace"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasTerrace']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasTerrace">Terrasse</label>
                            </div>
                        </div>
                        <!-- Piscine -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasSwimmingPool"
                                    name="accomodationHasSwimmingPool"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasSwimmingPool']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasSwimmingPool">Piscine</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Internet -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasInternet"
                                    name="accomodationHasInternet"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasInternet']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasInternet">Internet</label>
                            </div>
                        </div>
                        <!-- Wifi -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasWifi"
                                    name="accomodationHasWifi"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasWifi']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasWifi">Wifi</label>
                            </div>
                        </div>
                        <!-- Fibre optique -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasFiberOpticInternet" name="accomodationHasFiberOpticInternet"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasFiberOpticInternet']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasFiberOpticInternet">Fibre
                                    optique</label>
                            </div>
                        </div>
                        <!-- Netflix -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasNetflix"
                                    name="accomodationHasNetflix"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasNetflix']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasNetflix">Netflix</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Télévision -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasTv"
                                    name="accomodationHasTv"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasTv']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasTv">Télévision</label>
                            </div>
                        </div>
                        <!-- Double vitrage -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasDoubleGlazing"
                                    name="accomodationHasDoubleGlazing"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasDoubleGlazing']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasDoubleGlazing">Double
                                    vitrage</label>
                            </div>
                        </div>
                        <!-- Chauffe eau gaz -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasGasWaterHeater"
                                    name="accomodationHasGasWaterHeater"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasGasWaterHeater']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasGasWaterHeater">Chauffe eau
                                    gaz</label>
                            </div>
                        </div>
                        <!-- Ballon d'eau chaude -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasHotWaterTank"
                                    name="accomodationHasHotWaterTank"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasHotWaterTank']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasHotWaterTank">Ballon d'eau
                                    chaude</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Climatisation -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasAirConditioning"
                                    name="accomodationHasAirConditioning"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasAirConditioning']){echo 'checked';}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasAirConditioning">Climatisation</label>
                            </div>
                        </div>
                        <!-- Chauffage éléctrique -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasElectricHeating"
                                    name="accomodationHasElectricHeating"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasElectricHeating']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasElectricHeating">Chauffage
                                    électrique</label>
                            </div>
                        </div>
                        <!-- Chauffage individuel gaz -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasIndividualGasHeating" name="accomodationHasIndividualGasHeating"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasIndividualGasHeating']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasIndividualGasHeating">Chauffage
                                    individuel gaz</label>
                            </div>
                        </div>
                        <!-- Chauffage collectif gaz -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasCollectiveGasHeating" name="accomodationHasCollectiveGasHeating"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasCollectiveGasHeating']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasCollectiveGasHeating">Chauffage
                                    collectif gaz</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Lave linge -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasWashingMachine"
                                    name="accomodationHasWashingMachine"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasWashingMachine']){echo 'checked';}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasWashingMachine">Lave-linge</label>
                            </div>
                        </div>
                        <!-- Lave vaisselle -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasDishwasher"
                                    name="accomodationHasDishwasher"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasDishwasher']){echo 'checked';}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasDishwasher">Lave-vaisselle</label>
                            </div>
                        </div>
                        <!-- Réfrigérateur -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasFridge"
                                    name="accomodationHasFridge"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasFridge']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasFridge">Réfrigérateur</label>
                            </div>
                        </div>
                        <!-- Congélateur -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasFreezer"
                                    name="accomodationHasFreezer"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasFreezer']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasFreezer">Congélateur</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Plaques de cuisson -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasBakingTray"
                                    name="accomodationHasBakingTray"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasBakingTray']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasBakingTray">Plaques de
                                    cuisson</label>
                            </div>
                        </div>
                        <!-- Hotte aspirante -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasExtractorHood"
                                    name="accomodationHasExtractorHood"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasExtractorHood']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasExtractorHood">Hotte
                                    aspirante</label>
                            </div>
                        </div>
                        <!-- Four -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasOven"
                                    name="accomodationHasOven"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasOven']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasOven">Four</label>
                            </div>
                        </div>
                        <!-- Micro-ondes -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasMicrowaveOven"
                                    name="accomodationHasMicrowaveOven"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasMicrowaveOven']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasMicrowaveOven">Four
                                    micro-ondes</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Cafetière -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasCoffeeMachine"
                                    name="accomodationHasCoffeeMachine"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasCoffeeMachine']){echo 'checked';}?>>
                                <label class="custom-control-label "
                                    for="accomodationHasCoffeeMachine">Cafetière</label>
                            </div>
                        </div>
                        <!-- Machine à café dosette -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasPodCoffeeMachine"
                                    name="accomodationHasPodCoffeeMachine"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasPodCoffeeMachine']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasPodCoffeeMachine">Machine à
                                    café avec dosette</label>
                            </div>
                        </div>
                        <!-- Bouilloire -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasKettle"
                                    name="accomodationHasKettle"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasKettle']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasKettle">Bouilloire</label>
                            </div>
                        </div>
                        <!-- Grille pain -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasToaster"
                                    name="accomodationHasToaster"
                                    <?php if($advertisementData[0]['advertisement_accomodationHasToaster']){echo 'checked';}?>>
                                <label class="custom-control-label " for="accomodationHasToaster">Grille pain</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Visites autorisées -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="authorizedVisit"
                                    name="authorizedVisit"
                                    <?php if($advertisementData[0]['advertisement_authorizedVisit']){echo 'checked';}?>>
                                <label class="custom-control-label " for="authorizedVisit">Visites autorisées</label>
                            </div>
                        </div>
                        <!-- Animaux autorisés -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="animalsAllowed"
                                    name="animalsAllowed"
                                    <?php if($advertisementData[0]['advertisement_animalsAllowed']){echo 'checked';}?>>
                                <label class="custom-control-label " for="animalsAllowed">Animaux autorisés</label>
                            </div>
                        </div>
                        <!-- Fumer autorisé -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="smokingIsAllowed"
                                    name="smokingIsAllowed"
                                    <?php if($advertisementData[0]['advertisement_smokingIsAllowed']){echo 'checked';}?>>
                                <label class="custom-control-label " for="smokingIsAllowed">Fumer est autorisé</label>
                            </div>
                        </div>
                        <!-- Fêtes autorisées -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="authorizedParty"
                                    name="authorizedParty"
                                    <?php if($advertisementData[0]['advertisement_authorizedParty']){echo 'checked';}?>>
                                <label class="custom-control-label " for="authorizedParty">Fêtes autorisées</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ---------- CHAMBRE ---------- -->
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Chambre</h2>
                <div class="container">
                    <div class="row">
                        <!-- Surface habitable -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="bedroomSize">Surface habitable de la chambre</label>
                            <div id="bedroomSizeDiv" class="input-group mb-3">
                                <input id="bedroomSize" type="number" min="1" name="bedroomSize" class="form-control"
                                    placeholder="0" aria-describedby="basic-addon2"
                                    value="<?=$advertisementData[0]['advertisement_bedroomSize']?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m²</span>
                                </div>
                            </div>
                        </div>
                        <!-- Type de chambre -->
                        <div class="form-group col-md-4">
                            <label for="bedroomType" class="font-weight-bold">Type de chambre</label>
                            <select id="bedroomType" name="bedroomType" class="custom-select">
                                <option value="Simple"
                                    <?php if($advertisementData[0]['advertisement_bedroomType'] == "Simple"){echo 'selected';}?>>
                                    Simple</option>
                                <option value="Double"
                                    <?php if($advertisementData[0]['advertisement_bedroomType'] == "Double"){echo 'selected';}?>>
                                    Double</option>
                                <option value="Partagée"
                                    <?php if($advertisementData[0]['advertisement_bedroomType'] == "Partagée"){echo 'selected';}?>>
                                    Partagée</option>
                            </select>
                        </div>
                        <!-- Type de lit -->
                        <div class="form-group col-md-4">
                            <label for="bedType" class="font-weight-bold">Type de lit</label>
                            <select id="bedType" name="bedType" class="custom-select">
                                <option value="Simple"
                                    <?php if($advertisementData[0]['advertisement_bedroomType'] == "Simple"){echo 'selected';}?>>
                                    Simple</option>
                                <option value="Double"
                                    <?php if($advertisementData[0]['advertisement_bedroomType'] == "Double"){echo 'selected';}?>>
                                    Double</option>
                                <option value="Canapé-lit"
                                    <?php if($advertisementData[0]['advertisement_bedroomType'] == "Canapé-lit"){echo 'selected';}?>>
                                    Canapé-lit</option>
                            </select>
                        </div>
                    </div>
                    <h3>La chambre comprend:</h3>
                    <div class="row">
                        <!-- Bureau -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasDesk"
                                    name="bedroomHasDesk"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasDesk']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasDesk">Bureau</label>
                            </div>
                        </div>
                        <!-- Chaise -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasChair"
                                    name="bedroomHasChair"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasChair']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasChair">Chaise</label>
                            </div>
                        </div>
                        <!-- Tv -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasTv"
                                    name="bedroomHasTv"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasTv']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasTv">Télévision</label>
                            </div>
                        </div>
                        <!-- Fauteuil -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasArmchair"
                                    name="bedroomHasArmchair"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasArmchair']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasArmchair">Fauteuil</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Table basse -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasCoffeeTable"
                                    name="bedroomHasCoffeeTable"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasCoffeeTable']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasCoffeeTable">Table basse</label>
                            </div>
                        </div>
                        <!-- Chevet -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasBedside"
                                    name="bedroomHasBedside"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasBedside']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasBedside">Chevet</label>
                            </div>
                        </div>
                        <!-- Lampe -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasLamp"
                                    name="bedroomHasLamp"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasLamp']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasLamp">Lampe</label>
                            </div>
                        </div>
                        <!-- Etagères -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasShelf"
                                    name="bedroomHasShelf"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasShelf']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasShelf">Etagère(s)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Armoire -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasWardrobe"
                                    name="bedroomHasWardrobe"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasWardrobe']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasWardrobe">Armoire</label>
                            </div>
                        </div>
                        <!-- Penderie -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasCloset"
                                    name="bedroomHasCloset"
                                    <?php if($advertisementData[0]['advertisement_bedroomHasCloset']){echo 'checked';}?>>
                                <label class="custom-control-label " for="bedroomHasCloset">Penderie</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Photos -->
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Photos</h2>
                <div class="row">
                    <?php
                    foreach($advertisementPicture as $key => $value){
                        ?>
                    <div id="test" class="col-md-4 text-center">
                        <label class="image-checkbox">
                            <img class="img-responsive img-thumbnail"
                                src="<?=$picturePath.$advertisementPicture[$key]['picture_fileName']?>"
                                alt="Photo de l'annonce">
                            <input type="checkbox" name=picture[]
                                value="<?=$advertisementPicture[$key]['picture_fileName']?>">     
                        </label>
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
            <div class="container">
                <div><input type="file" onchange="handleFiles(files)" id="upload" multiple name="file[]"></div>
                <div><label for="upload"><span id="preview"></span></label></div>
            </div>
    </div>

    <!-- Bouton submit -->
    <div class="container pt-3">
        <button type="submit" class="btn btn-primary offset-md-5 col-md-2">Enregistrer</button>
    </div>

    </form>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
<script src="public/js/pictureCheckbox.js"></script>
<script src="public/js/modifyAdvertisement.js"></script>
<script src="public/js/uploadFilePreview.js"></script>
<?php
$content = ob_get_clean();
require('view/includes/template.php');