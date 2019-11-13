let addressDiv = document.getElementById('addressDiv');
let streetDiv = document.getElementById('streetDiv');
let streetInput = document.getElementById('street');
let zipcodeDiv = document.getElementById('zipcodeDiv');
let zipcodeInput = document.getElementById('zipcode');
let cityDiv = document.getElementById('cityDiv');
let cityInput = document.getElementById('city');
let countryDiv = document.getElementById('countryDiv');
let countryInput = document.getElementById('country');
let data;

//CREATION DIV ET CHAMP INPUT POUR SAISIE ADRESSE
//Creation div
let divForstreetAutocompleteDiv = document.getElementById('divForstreetAutocompleteDiv');
let streetAutocompleteDiv = document.createElement('div');
streetAutocompleteDiv.setAttribute('id', 'streetAutocompleteDiv');
streetAutocompleteDiv.classList.add('form-group');
divForstreetAutocompleteDiv.appendChild(streetAutocompleteDiv);
//Creation label
let streetAutocompleteLabel = document.createElement('label');
streetAutocompleteLabel.setAttribute('for', 'streetAutocomplete');
streetAutocompleteLabel.classList.add('font-weight-bold');
streetAutocompleteLabel.innerText = "Adresse";
streetAutocompleteDiv.appendChild(streetAutocompleteLabel);
//Creation input
let streetAutocompleteInput = document.createElement('input');
streetAutocompleteInput.setAttribute('id', 'streetAutocomplete');
streetAutocompleteInput.setAttribute('type', 'text');
streetAutocompleteInput.setAttribute('name', 'streetAutocomplete');
streetAutocompleteInput.setAttribute('title', 'Adresse complète');
streetAutocompleteInput.classList.add('form-control');
streetAutocompleteInput.setAttribute('placeholder', 'Saisir l\'adresse du logement');
streetAutocompleteInput.setAttribute('maxlength', '255');
streetAutocompleteInput.setAttribute('required', '');
streetAutocompleteDiv.appendChild(streetAutocompleteInput);
if (streetInput.value.length > 0) {
    streetAutocompleteInput.value = streetInput.value + " " + zipcodeInput.value + " " + cityInput.value;
}
//On met une bordure rouge si il y a une erreur
if (verificationFieldPresence('errorAddressPhp')) {
    errorRedBorder(streetAutocompleteInput);
}
//On cache les champs adresse zipcode city country
streetDiv.style.display = "none";
zipcodeDiv.style.display = "none";
cityDiv.style.display = "none";
countryDiv.style.display = "none";

//ADDEVENTLISTENER

//Permet de ne pas prendre le focus sur un champ en cliquant si la liste d'adresse est présente
document.addEventListener('click', function() {
    //Si la liste d'adresses existe et que aucune adresse est focus (attribut hasfocus de ul = 0)
    if (verificationFieldPresence('ulAutocompleteChoices') && getValueAttribute('ulAutocompleteChoices', 'hasFocus') == 0) {
        let ulChoices = document.getElementById('ulAutocompleteChoices');
        createMessage("Veuillez sélectionner une adresse dans la liste déroulante", "error");
        //Si le span est présent
        if (verificationFieldPresence('spanValueInput')) {
            //Si valeur du champ input est différent du text dans le span alors on donne comme à input la valeur du span et on supprime le span
            if (streetAutocompleteInput.value != document.getElementById('spanValueInput').textContent) {
                streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
                removeElement('spanValueInput');
            }
        }
        streetAutocompleteInput.focus();
    } else if (verificationFieldPresence('ulAutocompleteChoices') && getValueAttribute('ulAutocompleteChoices', 'hasFocus') == 1) {
        errorRedBorder(streetAutocompleteInput);
        createMessage("Veuillez sélectionner une adresse dans la liste déroulante", "error");
    }
});

//Attente évènement blur sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('blur', function() {
    //Si le champ input n'est pas vide
    if (!verificationFieldValueIsEmpty('streetAutocomplete')) {
        //Si les champs cachés sont vides
        if (verificationFieldValueIsEmpty('street') || verificationFieldValueIsEmpty('zipcode') || verificationFieldValueIsEmpty('city')) {
            //Si la liste d'adresses existe
            if (verificationFieldPresence('ulAutocompleteChoices')) {
                //Si la liste d'adresses est caché, alors on la rend visible et on affiche un message
                if (getHiddenValue('ulAutocompleteChoices')) {
                    modifyHiddenPropertyOfAnElement('ulAutocompleteChoices', false);
                }
                //on fait focus sur la première adresse de la liste
                document.getElementById('ulAutocompleteChoices').children[0].children[0].focus();
                if ((verificationFieldPresence('message') && getValueAttribute('message', 'type') != 'error') || !verificationFieldPresence('message')) {
                    createMessage("Veuillez sélectionner une adresse dans la liste déroulante", "information");
                } else {
                    createMessage("Veuillez sélectionner une adresse dans la liste déroulante", 'error');
                }
            } else {
                //sinon si pas de fenetre avec les adresses alors on affiche un message adresse incomplète
                createMessage("Adresse incomplète", "error");
                streetAutocompleteInput.focus();
            }
        } else {
            normalGreyBorder(streetAutocompleteInput);
        }
    } else {
        createMessage("Champ obligatoire", "error");
    }
    if (verificationFieldPresence('message') && getValueAttribute('message', 'type') != 'error') {
        normalGreyBorder(streetAutocompleteInput);
    }
});

//Attente évènement focus sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('focus', function() {
    if (verificationFieldPresence('message') && getValueAttribute('message', 'type') != 'error') {
        normalGreyBorder(streetAutocompleteInput);
    }
})

//Attente évènement input sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('input', function() {
    removeElement('errorAddressPhp');
    createSpanUserWrite();
    normalGreyBorder(streetAutocompleteInput);
    streetInput.value = "";
    zipcodeInput.value = "";
    cityInput.value = "";
    countryInput.value = "";
    if (streetAutocompleteInput.value.length > 0) {
        let text = streetAutocompleteInput.value;
        let url = 'https://api-adresse.data.gouv.fr/search/?q=' + text + '&limit=5';
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status <= 400) {
                    //On parse le json et le stocke dans data
                    data = JSON.parse(xhr.responseText);
                    let results = data.features;
                    removeElement('ulAutocompleteChoices');
                    if (results.length > 0 && streetAutocompleteInput.value.length > 0) {
                        createAddressChoiceSection(results);
                        createMessage("Veuillez sélectionner une adresse dans la liste déroulante", "information");
                    } else {
                        removeElement('message');
                    }
                }
            }
        }
        xhr.send();
    } else {
        removeElement('message');
        removeElement('ulAutocompleteChoices');
    }
});
//key du champ streetautocompleteinput
streetAutocompleteInput.addEventListener("keydown", function(event) {
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    //Fleche du bas
    if (event.keyCode == 40) {
        if (verificationFieldPresence('ulAutocompleteChoices')) {
            ulChoices.children[0].children[0].focus();
            event.preventDefault();
        }
        //Touche echap
    } else if (event.keyCode == 27) {
        if (verificationFieldPresence('ulAutocompleteChoices') && !getHiddenValue('ulAutocompleteChoices')) {
            modifyHiddenPropertyOfAnElement('ulAutocompleteChoices', true);
            createMessage('Adresse incomplète', 'error');
            event.preventDefault();
        }
        //Touche shift tab
    } else if (event.keyCode == 16) {
        streetAutocompleteInput.addEventListener("keydown", function doublekeyInput(event) {
            if (event.keyCode == 9) {
                this.removeEventListener("keydown", doublekeyInput);
            }
        });
    }
})

//FONCTIONS

//Fonction onclick sur button adresse
function completeAddress(text) {
    removeElement('message');
    removeElement('ulAutocompleteChoices');
    removeElement('spanValueInput');
    data.features.forEach(element => {
        if (element.properties.label == text) {
            streetAutocompleteInput.value = element.properties.label;
            streetInput.value = element.properties.name;
            zipcodeInput.value = element.properties.postcode;
            cityInput.value = element.properties.city;
            countryInput.value = "France";
        }
    })
    streetAutocompleteInput.focus();
    streetAutocompleteInput.blur();
}

//Fonction keyDown
function keydown(elt, e) {
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    ulNbOfChildren = elt.parentNode.parentNode.children.length;
    //Fleche du bas
    if (e.keyCode == 40) {
        for (let i = 0; i < ulNbOfChildren; i++) {
            if (elt.textContent == ulChoices.children[i].children[0].textContent) {
                if (i < ulNbOfChildren - 1) {
                    ulChoices.children[i + 1].children[0].focus();
                } else {
                    ulChoices.children[0].children[0].focus();
                }
            }
        }
        e.preventDefault();
        //Flèche du haut
    } else if (e.keyCode == 38) {
        for (let i = 0; i < ulNbOfChildren; i++) {
            if (elt.textContent == ulChoices.children[i].children[0].textContent) {
                if (i > 0) {
                    ulChoices.children[i - 1].children[0].focus();
                } else {
                    ulChoices.children[ulNbOfChildren - 1].children[0].focus();
                }
            }
        }
        e.preventDefault();
        //Touche tab
    } else if (e.keyCode == 9) {
        for (let i = 0; i < ulNbOfChildren; i++) {
            if (elt.textContent == ulChoices.children[i].children[0].textContent) {
                if (i < ulNbOfChildren - 1) {
                    ulChoices.children[i + 1].children[0].focus();
                } else {
                    ulChoices.children[0].children[0].focus();
                }
            }
        }
        e.preventDefault();
        //Touche echap
    } else if (e.keyCode == 27) {
        modifyHiddenPropertyOfAnElement('ulAutocompleteChoices', true);
        createMessage('Adresse incomplète', 'error');
        if (verificationFieldPresence('spanValueInput')) {
            streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
        }
        streetAutocompleteInput.focus();
        e.preventDefault();
        //Touche retour (backspace)
    } else if (e.keyCode == 8) {
        if (verificationFieldPresence('spanValueInput')) {
            streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
        }
        streetAutocompleteInput.focus();
        streetAutocompleteInput.value = streetAutocompleteInput.value.substring(0, streetAutocompleteInput.value.length - 1);
        e.preventDefault();
        //Touches lettres
    } else if (e.keyCode >= 48 && e.keyCode <= 90) {
        let letter = String.fromCharCode(e.keyCode).toLowerCase();
        streetAutocompleteInput.focus();
        streetAutocompleteInput.value = streetAutocompleteInput.value + letter;
        e.preventDefault();
        //Touche shift
    } else if (e.keyCode == 16) {
        ulChoices.addEventListener("keydown", function doublekey(event) {
            if (event.keyCode == 9) {
                this.removeEventListener("keydown", doublekey);
                if (document.getElementById('spanValueInput')) {
                    streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
                }
                streetAutocompleteInput.focus();
            }
        });
        e.preventDefault();
    }
}
//Blur address line
function addressButtonBlur(elt) {
    if (verificationFieldPresence('spanValueInput')) {
        streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
    }
    elt.style.backgroundColor = "white";
}
//Focus address line
function addressButtonFocus(elt) {
    streetAutocompleteInput.value = elt.textContent;
    elt.style.backgroundColor = 'rgb(209,213,216)';
}
//Fonction mouseover
function mouseoverstyle(elt) {
    elt.focus();
    elt.style.cursor = "pointer";
}
//Fonction mouseout
function normalstyle(elt) {
    elt.blur();
}
//change la valeur de l'attribut onfocus de la liste d'adresse
function changeUlOnFocus() {
    let ulchoices = document.getElementById('ulAutocompleteChoices');
    if (ulchoices.getAttribute('hasfocus') == 0) {
        ulchoices.setAttribute('hasfocus', '1')
    } else {
        ulchoices.setAttribute('hasfocus', '0');
    }
}
//Fonction creation ul li choix adresses
function createAddressChoiceSection(results) {
    //Création ul
    let ul = document.createElement('ul');
    ul.setAttribute('id', 'ulAutocompleteChoices');
    ul.setAttribute('hasfocus', '0');
    ul.style.backgroundColor = "rgb(255,255,255)";
    ul.style.listStyleType = "none";
    ul.classList.add('row');
    ul.classList.add('col-md-9');
    ul.classList.add('ml-0');
    ul.classList.add('px-0');
    ul.classList.add('border');
    ul.classList.add('border-primary');
    ul.classList.add('rounded');
    //Remplissage ul élément
    results.forEach(element => {
        //Création li
        let li = document.createElement('li');
        li.classList.add('container-fluid');
        li.classList.add('px-0');
        //Création button
        let addressLineButton = document.createElement('button');
        addressLineButton.classList.add('container-fluid');
        addressLineButton.classList.add('text-left');
        addressLineButton.classList.add('px-3');
        addressLineButton.setAttribute('tabindex', '0');
        addressLineButton.setAttribute('type', 'button');
        addressLineButton.setAttribute('onclick', 'completeAddress(this.textContent)');
        addressLineButton.setAttribute('onmouseover', 'mouseoverstyle(this)');
        addressLineButton.setAttribute('onmouseout', 'normalstyle(this)');
        addressLineButton.setAttribute('onkeydown', 'keydown(this,event)');
        addressLineButton.setAttribute('onblur', 'addressButtonBlur(this);changeUlOnFocus()');
        addressLineButton.setAttribute('onfocus', 'addressButtonFocus(this);changeUlOnFocus()')
        addressLineButton.style.backgroundColor = "white";
        addressLineButton.style.border = "none";
        addressLineButton.textContent = element.properties.label;
        li.appendChild(addressLineButton);
        ul.appendChild(li);
    });
    streetAutocompleteDiv.insertBefore(ul, document.getElementById('message'));
}

//Fonction creation p message
function createMessage(text, type) {
    if (verificationFieldPresence('message')) {
        if (getValueAttribute('message', 'type') == type && document.getElementById('message').textContent == text) {
            return;
        }
        removeElement('message');
    }
    let message = document.createElement('p');
    message.setAttribute('id', 'message');
    message.textContent = text;
    message.classList.add('font-weight-bold');
    if (type == "error") {
        message.setAttribute('type', 'error');
        message.classList.add('text-danger');
        errorRedBorder(streetAutocompleteInput);
    } else if (type == 'information') {
        message.setAttribute('type', 'information');
        message.classList.add('text-primary');
    }
    streetAutocompleteDiv.appendChild(message);
}
//Fonction pour supprimer message d'erreur
function removeElement(id) {
    let errorMessageVerif = document.getElementById(id);
    if (errorMessageVerif) {
        if (errorMessageVerif.id == "errorAddressPhp") {
            errorMessageVerif.parentNode.removeChild(errorMessageVerif);
        } else {
            streetAutocompleteDiv.removeChild(errorMessageVerif);
        }
    }
}
//Fonction creation span (conserver la saisie de l'utilisateur)
function createSpanUserWrite() {
    if (verificationFieldPresence('spanValueInput')) {
        removeElement('spanValueInput');
    }
    let span = document.createElement('span');
    span.setAttribute('id', 'spanValueInput');
    span.hidden = true;
    span.textContent = streetAutocompleteInput.value;
    streetAutocompleteDiv.appendChild(span);

}
//Fonction pour modifier le hidden d'un élément
function modifyHiddenPropertyOfAnElement(id, value) {
    let field = document.getElementById(id);
    if (field) {
        field.hidden = value;
    }
}
//Fonction pour vérifier la présence d'un champ à partir de son id
function verificationFieldPresence(id) {
    let fieldVerification = document.getElementById(id);
    if (fieldVerification) {
        return true;
    } else {
        return false;
    }
}
//Fonction pour vérifier si des champs sont vides (length 0)
function verificationFieldValueIsEmpty(id) {
    if (document.getElementById(id).value.length == 0) {
        return true;
    } else {
        return false;
    }
}
//Fonction pour vérifier la valeur de la propriété hidden d'un élément
function getHiddenValue(id) {
    if (document.getElementById(id).hidden) {
        return true;
    } else {
        return false;
    }
}
//Fonction pour récupérer la valeur d'un attribut d'un élément
function getValueAttribute(id, attributeName) {
    return document.getElementById(id).getAttribute(attributeName);
}
//Fonction bordure rouge erreur
function errorRedBorder(element) {
    element.style.borderColor = "rgb(217,83,79)";
    element.style.borderWidth = "2px";
}
//Fonction bordure normale
function normalGreyBorder(element) {
    element.style.borderColor = "rgb(209,213,216)";
    element.style.borderWidth = "1px";
    //
}