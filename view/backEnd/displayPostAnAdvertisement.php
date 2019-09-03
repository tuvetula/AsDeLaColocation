<?php
$title = "Déposer une nouvelle annonce";
ob_start();
?>
<div id="addAnAdvertisementForm" class="container">
    <div class="jumbotron">
        <h1 class="text-center">Ajouter une nouvelle annonce</h1>
        <form method="post" action="index.php?page=newAdvertisement">
            <!-- ----------Annonce---------- -->
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Annonce</h2>
                <!-- Titre, Description -->
                <div class="container">
                    <!--Titre-->
                    <div class="form-group">
                        <label class="font-weight-bold" for="title">Titre</label>
                        <input type="text" name="title" class="form-control" id="title"
                            placeholder="Titre de l'annonce" required>
                    </div>
                    <!--Description-->
                    <div class="form-group">
                        <label class="font-weight-bold" for="description">Description</label>
                        <textarea class="form-control" id="description" rows="6" name="description"
                            placeholder="maximum 3000 charactères" required></textarea>
                    </div>
                    <!-- Type, catégorie, disponible le, location sans visite -->
                    <div class="row">
                        <!--Type de logement-->
                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">Type de logement</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type"
                                    value="Maison" checked>
                                <label class="form-check-label" for="type">
                                    Maison
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type"
                                    value="Appartement">
                                <label class="form-check-label" for="type">
                                    Appartement
                                </label>
                            </div>
                        </div>
                        <!--Catégorie du logement-->
                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">Catégorie</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory1" value="Location" checked>
                                <label class="form-check-label" for="radioButtonAccomodationCategory1">
                                    Location
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory2" value="Colocation">
                                <label class="form-check-label" for="radioButtonAccomodationCategory2">
                                    Colocation
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory3" value="Sous-location">
                                <label class="form-check-label" for="radioButtonAccomodationCategory3">
                                    Sous-location
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                    id="radioButtonAccomodationCategory4" value="Courte-durée">
                                <label class="form-check-label" for="radioButtonAccomodationCategory4">
                                    Courte-durée
                                </label>
                            </div>
                        </div>
                        <!-- Disponible le -->
                        <div class="form-group col-md-3">
                            <label for="availableDate" class="font-weight-bold">Disponible le</label>
                            <input class="form-control" type="date" id="availableDate" name="availableDate" required>
                        </div>
                        <!-- Location sans visite + meublé -->
                        <div class="form-group col-md-3">
                            <!-- Meublé -->
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="isFurnished" name="isFurnished">
                                <label class="custom-control-label font-weight-bold" for="isFurnished">Meublé</label>
                            </div>
                            <!-- Location sans visite -->
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="rentWithoutVisit"
                                    name="rentWithoutVisit">
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
                                placeholder="Nom">
                        </div>
                        <!-- Telephone du contact pour les visites -->
                        <div class="form-group col-md-4">
                            <label for="contactPhoneNumberForVisit" class="font-weight-bold">Telephone du contact
                                pour
                                les visites</label>
                            <input id="contactPhoneNumberForVisit" type="tel" name="contactPhoneNumberForVisit"
                                class="form-control" placeholder="Téléphone">
                        </div>
                        <!-- Mail du contact pour les visites -->
                        <div class="form-group col-md-4">
                            <label for="contactMailForVisit" class="font-weight-bold">Mail du contact pour les
                                visites</label>
                            <input id="contactMailForVisit" type="email" name="contactMailForVisit" class="form-control"
                                placeholder="Mail">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Situation du loueur -->
                        <div class="form-group col-md-4">
                            <label for="renterSituation" class="font-weight-bold">Situation du loueur </label>
                            <select id="renterSituation" name="renterSituation" class="custom-select">
                                <option value="Propriétaire">Propriétaire</option>
                                <option value="Locataire">Locataire</option>
                            </select>
                        </div>
                        <!-- Durée minimum de séjour -->
                        <div class="form-group col-md-4">
                            <label for="locationMinDuration" class="font-weight-bold">Durée minimum de
                                séjour</label>
                            <select id="locationMinDuration" name="locationMinDuration" class="custom-select">
                                <option value="1 mois">1 mois</option>
                                <option value="3 mois">3 mois</option>
                                <option value="6 mois">6 mois</option>
                                <option value="9 mois">9 mois</option>
                                <option value="12 mois">12 mois</option>
                            </select>
                        </div>
                        <!-- Nombre de colocataires déja présent -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="nbOfOtherRoommatePresent">Nombre de
                                colocataires
                                déja
                                présent</label>
                            <div id="nbOfOtherRoommatePresentDiv" class="input-group mb-3">
                                <input id="nbOfOtherRoommatePresent" type="number" min="0" max="9"
                                    name="nbOfOtherRoommatePresent" class="form-control" placeholder="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Colocataire idéal (sexe) -->
                        <div class="form-group col-md-4">
                            <label for="idealRoommateSex" class="font-weight-bold">Colocataire idéal
                                (sexe)</label>
                            <select id="idealRoommateSex" name="idealRoommateSex" class="custom-select">
                                <option value="Femme">Femme</option>
                                <option value="Homme">Homme</option>
                                <option value="PeuImporte">Peu importe</option>
                            </select>
                        </div>
                        <!-- Colocataire idéal (situation) -->
                        <div class="form-group col-md-4">
                            <label for="idealRoommateSituation" class="font-weight-bold">Colocataire idéal
                                (situation)</label>
                            <select id="idealRoommateSituation" name="idealRoommateSituation" class="custom-select">
                                <option value="Etudiant">Etudiant</option>
                                <option value="Salarié">Salarié(e)</option>
                                <option value="PeuImporte">Peu importe</option>
                            </select>
                        </div>
                        <!-- Age minimum -->
                        <div class="form-group col-md-2">
                            <label class="font-weight-bold" for="idealRoommateMinAge">Age minimum</label>
                            <div id="idealRoommateMinAgeDiv" class="input-group mb-3">
                                <input id="idealRoommateMinAge" type="number" min="18" max="100"
                                    name="idealRoommateMinAge" class="form-control" placeholder="18" required>
                            </div>
                        </div>
                        <!-- Age maximum -->
                        <div class="form-group col-md-2">
                            <label class="font-weight-bold" for="idealRoommateMaxAge">Age maximum</label>
                            <div id="idealRoommateMaxAgeDiv" class="input-group mb-3">
                                <input id="idealRoommateMaxAge" type="number" min="18" max="100"
                                    name="idealRoommateMaxAge" class="form-control" placeholder="100" required>
                            </div>
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
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="monthlyRentExcludingCharges">Montant du loyer Hors
                                charges</label>
                            <div id="monthlyRentExcludingChargesDiv" class="input-group mb-3">
                                <input id="monthlyRentExcludingCharges" type="number" min="0"
                                    name="monthlyRentExcludingCharges" class="form-control" placeholder="0"
                                    aria-describedby="basic-addon2" required>
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
                                    placeholder="0" aria-describedby="basic-addon2" required>
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
                                    placeholder="0" aria-describedby="basic-addon2" required>
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
                                <option value="France" selected>France</option>
                                <option value="Europe">Europe</option>
                                <option value="PeuImporte">Peu importe</option>
                            </select>
                        </div>
                        <!-- Ratio de solvabilité -->
                        <div class="form-group col-md-4">
                            <label for="solvencyRatio" class="font-weight-bold">Ratio de solvabilité</label>
                            <select id="solvencyRatio" name="solvencyRatio" class="custom-select">
                                <option value="1X" selected>1X</option>
                                <option value="1.5X">1.5X</option>
                                <option value="2X">2X</option>
                                <option value="2.5X">2.5X</option>
                                <option value="3X">3X</option>
                                <option value="4X">4X</option>
                                <option value="5X">5X</option>
                                <option value="PeuImporte">Peu importe</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- financialRequirements -->
                        <div class="form-group col-md-4">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="financialRequirements"
                                    name="financialRequirements">
                                <label class="custom-control-label font-weight-bold"
                                    for="financialRequirements">Exigences financières</label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="eligibleForAids"
                                    name="eligibleForAids">
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
                                    name="chargesIncludeElectricity">
                                <label class="custom-control-label" for="chargesIncludeElectricity">Electricité</label>
                            </div>
                        </div>
                        <!-- Eau chaude -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHotWater"
                                    name="chargesIncludeHotWater">
                                <label class="custom-control-label" for="chargesIncludeHotWater">Eau
                                    chaude</label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHeating"
                                    name="chargesIncludeHeating">
                                <label class="custom-control-label" for="chargesIncludeHeating">Chauffage</label>
                            </div>
                        </div>
                        <!-- Internet -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeInternet"
                                    name="chargesIncludeInternet">
                                <label class="custom-control-label" for="chargesIncludeInternet">Internet</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Charges de co-propriété -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="chargesIncludeCoOwnershipCharges" name="chargesIncludeCoOwnershipCharges">
                                <label class="custom-control-label" for="chargesIncludeCoOwnershipCharges">Charges de
                                    co-propriété</label>
                            </div>
                        </div>
                        <!-- Assurance habitation -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeHomeInsurance"
                                    name="chargesIncludeHomeInsurance">
                                <label class="custom-control-label" for="chargesIncludeHomeInsurance">Assurance
                                    habitation</label>
                            </div>
                        </div>
                        <!-- Révision chaudière -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="chargesIncludeBoilerInspection"
                                    name="chargesIncludeBoilerInspection">
                                <label class="custom-control-label" for="chargesIncludeBoilerInspection">Révision
                                    chaudière</label>
                            </div>
                        </div>
                        <!-- Taxe d'ordures ménagères -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="chargesIncludeHouseholdGarbageTaxes" name="chargesIncludeHouseholdGarbageTaxes">
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
                                    name="chargesIncludeCleaningService">
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
                    <div class="form-group">
                        <label for="address_street" class="font-weight-bold">Numéro et nom de rue</label>
                        <input id="address_street" type="text" name="address_street" class="form-control"
                            placeholder="Saisir l'adresse du logement">
                    </div>
                    <!-- Code postal, ville, pays -->
                    <div class="row">
                        <!-- Code postal -->
                        <div class="form-group col-md-2">
                            <label for="address_zipcode" class="font-weight-bold">Code postal</label>
                            <input id="address_zipcode" type="text" name="address_zipcode" class="form-control"
                                placeholder="Code postal">
                        </div>
                        <!-- Ville -->
                        <div class="form-group col-md-6">
                            <label for="address_city" class="font-weight-bold">Ville</label>
                            <input id="address_city" type="text" name="address_city" class="form-control"
                                placeholder="Ville">
                        </div>
                        <!-- Pays -->
                        <div class="form-group col-md-4">
                            <label for="address_country" class="font-weight-bold">Pays</label>
                            <input id="address_country" type="text" name="address_country" class="form-control"
                                placeholder="Pays">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Surface habitable -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="accomodationLivingAreaSize">Surface habitable du
                                logement</label>
                            <div id="accomodationLivingAreaSizeDiv" class="input-group mb-3">
                                <input id="accomodationLivingAreaSize" type="number" min="1"
                                    name="accomodationLivingAreaSize" class="form-control" placeholder="0"
                                    aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m²</span>
                                </div>
                            </div>
                        </div>
                        <!-- Etage du logement -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="accomodationFloor">Etage du logement</label>
                            <div id="accomodationFloorDiv" class="input-group mb-3">
                                <input id="accomodationFloor" type="number" min="0" name="accomodationFloor"
                                    class="form-control" placeholder="0" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">étage</span>
                                </div>
                            </div>
                        </div>
                        <!-- Nombre d'étages -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="buildingNbOfFloors">Nombre d'etages (immeuble)</label>
                            <div id="buildingNbOfFloorsDiv" class="input-group mb-3">
                                <input id="buildingNbOfFloors" type="number" min="0" name="buildingNbOfFloors"
                                    class="form-control" placeholder="0" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">étage(s)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Nombre de pièces -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="accomodationNbOfRooms">Nombre de pièces</label>
                            <div id="accomodationNbOfRoomsDiv" class="input-group mb-3">
                                <input id="accomodationNbOfRooms" type="number" min="0" name="accomodationNbOfRooms"
                                    class="form-control" placeholder="0" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">pièces</span>
                                </div>
                            </div>
                        </div>
                        <!-- Nombre de chambres -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="accomodationNbOfBedrooms">Nombre de chambres</label>
                            <div id="accomodationNbOfBedroomsDiv" class="input-group mb-3">
                                <input id="accomodationNbOfBedrooms" type="number" min="0"
                                    name="accomodationNbOfBedrooms" class="form-control" placeholder="0"
                                    aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">chambre(s)</span>
                                </div>
                            </div>
                        </div>
                        <!-- Nombre de salles de bains -->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="accomodationNbOfBathrooms">Nombre de salles de
                                bain</label>
                            <div id="accomodationNbOfBathroomsDiv" class="input-group mb-3">
                                <input id="accomodationNbOfBathrooms" type="number" min="0"
                                    name="accomodationNbOfBathrooms" class="form-control" placeholder="0"
                                    aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">salle(s) de bain</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Nombre de chambres à louer-->
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold" for="nbOfBedroomsToRent">Nombre de chambres à louer</label>
                            <div id="nbOfBedroomsToRentDiv" class="input-group mb-3">
                                <input id="nbOfBedroomsToRent" type="number" min="0" name="nbOfBedroomsToRent"
                                    class="form-control" placeholder="0" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">chambre(s)</span>
                                </div>
                            </div>
                        </div>
                        <!-- Utilisation de la cuisine -->
                        <div class="form-group col-md-4">
                            <label for="kitchenUse" class="font-weight-bold">Utilisation de la cuisine</label>
                            <select id="kitchenUse" name="kitchenUse" class="custom-select">
                                <option value="Privée" selected>Privée</option>
                                <option value="Commun">Commun</option>
                            </select>
                        </div>
                        <!-- Utilisation du salon -->
                        <div class="form-group col-md-4">
                            <label for="livingRoomUse" class="font-weight-bold">Utilisation du salon</label>
                            <select id="livingRoomUse" name="livingRoomUse" class="custom-select">
                                <option value="Privée" selected>Privée</option>
                                <option value="Commun">Commun</option>
                                <option value="Aucun">Aucun</option>
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
                                    class="form-control" placeholder="0" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">kWhEp/m²/an</span>
                                </div>
                                <div class="input-group-append  ">
                                    <span id="energyClassLetterView" class="input-group-text" id="basic-addon2"></span>
                                </div>
                                <input id="energyClassLetterInput" type="hidden" name="energyClassLetter"
                                    class="form-control">
                            </div>
                        </div>
                        <!-- Ges -->
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold" for="EnergeticGes">Emissions de gaz à effet de serre</label>
                            <div id="EnergeticGes" class="input-group mb-3">
                                <input id="gesNumber" type="number" min="1" name="gesNumber" class="form-control"
                                    placeholder="0" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">kgeqCO2/m²/an</span>
                                </div>
                                <div class="input-group-append">
                                    <span id="gesLetterView" class="input-group-text" id="basic-addon2"></span>
                                </div>
                                <input id="gesLetterInput" type="hidden" name="gesLetter" class="form-control">
                            </div>
                        </div>
                    </div>
                    <h3>Le logement comprend:</h3>
                    <div class="row">
                        <!-- Accès handicapé -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="handicapedAccessibility"
                                    name="handicapedAccessibility">
                                <label class="custom-control-label " for="handicapedAccessibility">Accès
                                    handicapé</label>
                            </div>
                        </div>
                        <!-- Ascenceur -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasElevator"
                                    name="accomodationHasElevator">
                                <label class="custom-control-label " for="accomodationHasElevator">Ascenceur</label>
                            </div>
                        </div>
                        <!-- Parking commun -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasCommonParkingLot"
                                    name="accomodationHasCommonParkingLot">
                                <label class="custom-control-label " for="accomodationHasCommonParkingLot">Parking
                                    commun</label>
                            </div>
                        </div>
                        <!-- Place de parking privée -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasPrivateParkingPlace" name="accomodationHasPrivateParkingPlace">
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
                                    name="accomodationHasGarden">
                                <label class="custom-control-label " for="accomodationHasGarden">Jardin</label>
                            </div>
                        </div>
                        <!-- Balcon -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasBalcony"
                                    name="accomodationHasBalcony">
                                <label class="custom-control-label " for="accomodationHasBalcony">Balcon</label>
                            </div>
                        </div>
                        <!-- Terrasse -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasTerrace"
                                    name="accomodationHasTerrace">
                                <label class="custom-control-label " for="accomodationHasTerrace">Terrasse</label>
                            </div>
                        </div>
                        <!-- Piscine -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasSwimmingPool"
                                    name="accomodationHasSwimmingPool">
                                <label class="custom-control-label " for="accomodationHasSwimmingPool">Piscine</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Internet -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasInternet"
                                    name="accomodationHasInternet">
                                <label class="custom-control-label " for="accomodationHasInternet">Internet</label>
                            </div>
                        </div>
                        <!-- Wifi -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasWifi"
                                    name="accomodationHasWifi">
                                <label class="custom-control-label " for="accomodationHasWifi">Wifi</label>
                            </div>
                        </div>
                        <!-- Fibre optique -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasFiberOpticInternet" name="accomodationHasFiberOpticInternet">
                                <label class="custom-control-label " for="accomodationHasFiberOpticInternet">Fibre
                                    optique</label>
                            </div>
                        </div>
                        <!-- Netflix -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasNetflix"
                                    name="accomodationHasNetflix">
                                <label class="custom-control-label " for="accomodationHasNetflix">Netflix</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Télévision -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasTv"
                                    name="accomodationHasTv">
                                <label class="custom-control-label " for="accomodationHasTv">Télévision</label>
                            </div>
                        </div>
                        <!-- Double vitrage -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasDoubleGlazing"
                                    name="accomodationHasDoubleGlazing">
                                <label class="custom-control-label " for="accomodationHasDoubleGlazing">Double
                                    vitrage</label>
                            </div>
                        </div>
                        <!-- Chauffe eau gaz -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasGasWaterHeater"
                                    name="accomodationHasGasWaterHeater">
                                <label class="custom-control-label " for="accomodationHasGasWaterHeater">Chauffe eau
                                    gaz</label>
                            </div>
                        </div>
                        <!-- Ballon d'eau chaude -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasHotWaterTank"
                                    name="accomodationHasHotWaterTank">
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
                                    name="accomodationHasAirConditioning">
                                <label class="custom-control-label "
                                    for="accomodationHasAirConditioning">Climatisation</label>
                            </div>
                        </div>
                        <!-- Chauffage éléctrique -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasElectricHeating"
                                    name="accomodationHasElectricHeating">
                                <label class="custom-control-label " for="accomodationHasElectricHeating">Chauffage
                                    électrique</label>
                            </div>
                        </div>
                        <!-- Chauffage individuel gaz -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasIndividualGasHeating" name="accomodationHasIndividualGasHeating">
                                <label class="custom-control-label " for="accomodationHasIndividualGasHeating">Chauffage
                                    individuel gaz</label>
                            </div>
                        </div>
                        <!-- Chauffage collectif gaz -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input"
                                    id="accomodationHasCollectiveGasHeating" name="accomodationHasCollectiveGasHeating">
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
                                    name="accomodationHasWashingMachine">
                                <label class="custom-control-label "
                                    for="accomodationHasWashingMachine">Lave-linge</label>
                            </div>
                        </div>
                        <!-- Lave vaisselle -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasDishwasher"
                                    name="accomodationHasDishwasher">
                                <label class="custom-control-label "
                                    for="accomodationHasDishwasher">Lave-vaisselle</label>
                            </div>
                        </div>
                        <!-- Réfrigérateur -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasFridge"
                                    name="accomodationHasFridge">
                                <label class="custom-control-label " for="accomodationHasFridge">Réfrigérateur</label>
                            </div>
                        </div>
                        <!-- Congélateur -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasFreezer"
                                    name="accomodationHasFreezer">
                                <label class="custom-control-label " for="accomodationHasFreezer">Congélateur</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Plaques de cuisson -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasBakingTray"
                                    name="accomodationHasBakingTray">
                                <label class="custom-control-label " for="accomodationHasBakingTray">Plaques de
                                    cuisson</label>
                            </div>
                        </div>
                        <!-- Hotte aspirante -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasExtractorHood"
                                    name="accomodationHasExtractorHood">
                                <label class="custom-control-label " for="accomodationHasExtractorHood">Hotte
                                    aspirante</label>
                            </div>
                        </div>
                        <!-- Four -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasOven"
                                    name="accomodationHasOven">
                                <label class="custom-control-label " for="accomodationHasOven">Four</label>
                            </div>
                        </div>
                        <!-- Micro-ondes -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasMicrowaveOven"
                                    name="accomodationHasMicrowaveOven">
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
                                    name="accomodationHasCoffeeMachine">
                                <label class="custom-control-label "
                                    for="accomodationHasCoffeeMachine">Cafetière</label>
                            </div>
                        </div>
                        <!-- Machine à café dosette -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasPodCoffeeMachine"
                                    name="accomodationHasPodCoffeeMachine">
                                <label class="custom-control-label " for="accomodationHasPodCoffeeMachine">Machine à
                                    café avec dosette</label>
                            </div>
                        </div>
                        <!-- Bouilloire -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasKettle"
                                    name="accomodationHasKettle">
                                <label class="custom-control-label " for="accomodationHasKettle">Bouilloire</label>
                            </div>
                        </div>
                        <!-- Grille pain -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="accomodationHasToaster"
                                    name="accomodationHasToaster">
                                <label class="custom-control-label " for="accomodationHasToaster">Grille pain</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Visites autorisées -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="authorizedVisit"
                                    name="authorizedVisit">
                                <label class="custom-control-label " for="authorizedVisit">Visites autorisées</label>
                            </div>
                        </div>
                        <!-- Animaux autorisés -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="animalsAllowed"
                                    name="animalsAllowed">
                                <label class="custom-control-label " for="animalsAllowed">Animaux autorisés</label>
                            </div>
                        </div>
                        <!-- Fumer autorisé -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="smokingIsAllowed"
                                    name="smokingIsAllowed">
                                <label class="custom-control-label " for="smokingIsAllowed">Fumer est autorisé</label>
                            </div>
                        </div>
                        <!-- Fêtes autorisées -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="authorizedParty"
                                    name="authorizedParty">
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
                                    placeholder="0" aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">m²</span>
                                </div>
                            </div>
                        </div>
                        <!-- Type de chambre -->
                        <div class="form-group col-md-4">
                            <label for="bedroomType" class="font-weight-bold">Type de chambre</label>
                            <select id="bedroomType" name="bedroomType" class="custom-select">
                                <option value="Simple" selected>Simple</option>
                                <option value="Double">Double</option>
                                <option value="Partagée">Partagée</option>
                            </select>
                        </div>
                        <!-- Type de lit -->
                        <div class="form-group col-md-4">
                            <label for="bedType" class="font-weight-bold">Type de lit</label>
                            <select id="bedType" name="bedType" class="custom-select">
                                <option value="Simple" selected>Simple</option>
                                <option value="Double">Double</option>
                                <option value="Clic-clac">Clic-clac</option>
                            </select>
                        </div>
                    </div>
                    <h3>La chambre comprend:</h3>
                    <div class="row">
                        <!-- Bureau -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasDesk"
                                    name="bedroomHasDesk">
                                <label class="custom-control-label " for="bedroomHasDesk">Bureau</label>
                            </div>
                        </div>
                        <!-- Chaise -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasChair"
                                    name="bedroomHasChair">
                                <label class="custom-control-label " for="bedroomHasChair">Chaise</label>
                            </div>
                        </div>
                        <!-- Tv -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasTv"
                                    name="bedroomHasTv">
                                <label class="custom-control-label " for="bedroomHasTv">Télévision</label>
                            </div>
                        </div>
                        <!-- Fauteuil -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasArmchair"
                                    name="bedroomHasArmchair">
                                <label class="custom-control-label " for="bedroomHasArmchair">Fauteuil</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Table basse -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasCoffeeTable"
                                    name="bedroomHasCoffeeTable">
                                <label class="custom-control-label " for="bedroomHasCoffeeTable">Table basse</label>
                            </div>
                        </div>
                        <!-- Chevet -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasBedside"
                                    name="bedroomHasBedside">
                                <label class="custom-control-label " for="bedroomHasBedside">Chevet</label>
                            </div>
                        </div>
                        <!-- Lampe -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasLamp"
                                    name="bedroomHasLamp">
                                <label class="custom-control-label " for="bedroomHasLamp">Lampe</label>
                            </div>
                        </div>
                        <!-- Etagères -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasShelf"
                                    name="bedroomHasShelf">
                                <label class="custom-control-label " for="bedroomHasShelf">Etagère(s)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Armoire -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasWardrobe"
                                    name="bedroomHasWardrobe">
                                <label class="custom-control-label " for="bedroomHasWardrobe">Armoire</label>
                            </div>
                        </div>
                        <!-- Penderie -->
                        <div class="form-group col-md-3">
                            <div class=" custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input" id="bedroomHasCloset"
                                    name="bedroomHasCloset">
                                <label class="custom-control-label " for="bedroomHasCloset">Penderie</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Photos -->
            <div class="container pb-3 pt-3 border-bottom border-dark">
                <h2>Photos</h2>
                <div class="container">
                    <div><input type="file" onchange="handleFiles(files)" id="upload" multiple name="file"></div>
                    <div><label for="upload"><span id="preview"></span></label></div>
                </div>
            </div>

            <!-- Bouton submit -->
            <button type="submit" class="btn btn-primary offset-md-5 col-md-2">Enregistrer</button>

        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require('view/includes/template.php');