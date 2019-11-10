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
if (streetInput.value.length > 0) {
    streetAutocompleteInput.value = streetInput.value + " " + zipcodeInput.value + " " + cityInput.value;
}
streetAutocompleteInput.setAttribute('required', '');
streetAutocompleteDiv.appendChild(streetAutocompleteInput);

//On cache les champs adresse zipcode city country
streetDiv.style.display = "none";
zipcodeDiv.style.display = "none";
cityDiv.style.display = "none";
countryDiv.style.display = "none";

//Attente évènement focus sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('focus', function() {
    streetAutocompleteInput.style.borderColor = "rgb(233, 236, 239)";
})

//Attente évènement blur sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('blur', function() {
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    //Si le champ caché rue est vide
    if (streetAutocompleteInput.value.length != 0 && (streetInput.value.length == 0 || zipcodeInput.value.length == 0 || cityInput.value.length == 0)) {
        //Si la fenetre avec les adresses est caché, alors on la rend visible et on affiche un message
        if (ulChoices && ulChoices.hidden) {
            ulChoices.hidden = false;
            let errorMessage = document.createElement('p');
            errorMessage.setAttribute('id', 'errorMessage');
            errorMessage.classList.add('text-danger');
            errorMessage.classList.add('font-weight-bold');
            errorMessage.textContent = "Veuillez sélectionner une adresse dans la liste déroulante";
            streetAutocompleteDiv.appendChild(errorMessage);
            streetAutocompleteInput.focus();
            //Sinon si la fenetre avec les adresses est visible, alors on fait focus dessus
        } else if (ulChoices) {
            ulChoices.children[0].children[0].focus();
            //sinon si pas de fenetre avec les adresses alors on affiche un message adresse incomplète
        } else {
            //On verifie si le message est deja présent
            let errorMessageVerif = document.getElementById('errorMessage');
            if (!errorMessageVerif) {
                let errorMessage = document.createElement('p');
                errorMessage.setAttribute('id', 'errorMessage');
                errorMessage.classList.add('text-danger');
                errorMessage.classList.add('font-weight-bold');
                errorMessage.textContent = "Adresse incomplète";
                streetAutocompleteDiv.appendChild(errorMessage);
                streetAutocompleteInput.focus();
            } else {
                streetAutocompleteInput.focus();
            }
            streetAutocompleteInput.style.borderColor = "red";
        }
    } else {
        let errorMessageVerif = document.getElementById('errorMessage');
        if (errorMessageVerif) {
            streetAutocompleteDiv.removeChild(errorMessageVerif);
        }
        if (streetAutocompleteInput.value.length == 0) {
            let errorMessage = document.createElement('p');
            errorMessage.setAttribute('id', 'errorMessage');
            errorMessage.classList.add('text-danger');
            errorMessage.classList.add('font-weight-bold');
            errorMessage.textContent = "Champ obligatoire";
            streetAutocompleteDiv.appendChild(errorMessage);
            streetAutocompleteInput.style.borderColor = "red";
        }
    }
});

//Attente évènement input sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('input', function() {
    let errorMessageVerif = document.getElementById('errorMessage');
    if (errorMessageVerif) {
        streetAutocompleteDiv.removeChild(errorMessageVerif);
    }
    streetAutocompleteInput.style.borderColor = "rgb(233, 236, 239)";
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
                    let ulAutocompleteChoices = document.getElementById('ulAutocompleteChoices');
                    if (ulAutocompleteChoices) {
                        streetAutocompleteDiv.removeChild(ulAutocompleteChoices);
                    }
                    if (results.length > 0 && streetAutocompleteInput.value.length > 0) {
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
                        streetAutocompleteDiv.appendChild(ul);
                    }
                }
            }
        }
        xhr.send();
    } else {
        let ulAutocompleteChoices = document.getElementById('ulAutocompleteChoices');
        if (ulAutocompleteChoices) {
            streetAutocompleteDiv.removeChild(ulAutocompleteChoices);
        }
    }
});

//Fonction onclick sur button adresse
function completeAddress(text) {
    if (document.getElementById('spanValueInput')) {
        streetAutocompleteDiv.removeChild(document.getElementById('spanValueInput'));
    }
    data.features.forEach(element => {
        if (element.properties.label == text) {
            streetAutocompleteInput.value = element.properties.label;
            streetInput.value = element.properties.name;
            zipcodeInput.value = element.properties.postcode;
            cityInput.value = element.properties.city;
            countryInput.value = "France";
        }
    })
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    streetAutocompleteDiv.removeChild(ulChoices);
    let errorMessageVerif = document.getElementById('errorMessage');
    if (errorMessageVerif) {
        streetAutocompleteDiv.removeChild(errorMessageVerif);
    }
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
        let ulAutocompleteChoices = document.getElementById('ulAutocompleteChoices');
        if (ulAutocompleteChoices) {
            ulAutocompleteChoices.hidden = true;
        }
        let errorMessageVerif = document.getElementById('errorMessage');
        if (errorMessageVerif) {
            streetAutocompleteDiv.removeChild(errorMessageVerif);
        }
        if (document.getElementById('spanValueInput')) {
            streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
        }
        streetAutocompleteInput.focus();
        e.preventDefault();
        //Touche retour (backspace)
    } else if (e.keyCode == 8) {
        if (document.getElementById('spanValueInput')) {
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

//key du champ streetautocompleteinput
streetAutocompleteInput.addEventListener("keydown", function(event) {
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    //Fleche du bas
    if (event.keyCode == 40) {
        if (ulChoices.children[0].children[0]) {
            ulChoices.children[0].children[0].focus();
            event.preventDefault();
        }
        //Touche echap
    } else if (event.keyCode == 27) {
        let errorMessageVerif = document.getElementById('errorMessage');
        if (ulChoices && !ulChoices.hidden) {
            ulChoices.hidden = true;
            if (errorMessageVerif) {
                streetAutocompleteDiv.removeChild(errorMessageVerif);
            }
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

//Blur address line
function addressButtonBlur(elt) {
    elt.style.backgroundColor = "white";
    if (elt.textContent.toLowerCase() != streetAutocompleteInput.value.toLowerCase()) {
        if (document.getElementById('spanValueInput')) {
            streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
            streetAutocompleteDiv.removeChild(document.getElementById('spanValueInput'));
        }
    } else if (document.getElementById('spanValueInput') && elt.textContent.toLowerCase() == document.getElementById('spanValueInput').textContent) {
        elt.click();
    } else if (elt.textContent.toLowerCase() == streetAutocompleteInput.value.toLowerCase() && document.getElementById('spanValueInput') && elt.textContent.toLowerCase() != document.getElementById('spanValueInput').textContent) {
        streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
    }
}
//Focus address line
function addressButtonFocus(elt) {
    if (!document.getElementById('spanValueInput')) {
        let span = document.createElement('span');
        span.setAttribute('id', 'spanValueInput');
        span.style.color = "gray";
        span.hidden = true;
        span.textContent = streetAutocompleteInput.value;
        streetAutocompleteDiv.appendChild(span);
    }
    streetAutocompleteInput.value = elt.textContent;
    elt.style.backgroundColor = "rgb(233, 236, 239)";
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
//change ul onfocus
function changeUlOnFocus() {
    let ulchoices = document.getElementById('ulAutocompleteChoices');
    if (ulchoices.getAttribute('hasfocus') == 0) {
        ulchoices.setAttribute('hasfocus', '1')
    } else {
        ulchoices.setAttribute('hasfocus', '0');
    }
}
//Permet de ne pas prendre le focus sur un champ en cliquant si la liste d'adresse est présente
document.addEventListener('click', function() {
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    //Si la liste d'adresses existe et que aucune adresse est focus
    if (ulChoices && ulChoices.getAttribute('hasFocus') == 0) {
        //Si valeur du champ input est différent du text dans le span
        if (streetAutocompleteInput.value != document.getElementById('spanValueInput').textContent) {
            if (document.getElementById('errorMessage')) {
                let errorMessageVerif = document.getElementById('errorMessage');
                streetAutocompleteDiv.removeChild(errorMessageVerif);
            }
            let errorMessage = document.createElement('p');
            errorMessage.setAttribute('id', 'errorMessage');
            errorMessage.classList.add('text-danger');
            errorMessage.classList.add('font-weight-bold');
            errorMessage.textContent = "Veuillez sélectionner une adresse dans la liste déroulante";
            streetAutocompleteDiv.appendChild(errorMessage);
            streetAutocompleteInput.value = document.getElementById('spanValueInput').textContent;
            streetAutocompleteDiv.removeChild(document.getElementById('spanValueInput'));
            streetAutocompleteInput.focus();
            //Sinon si c'est la meme valeur
        } else {
            console.log('coucou');
            // completeAddress(streetAutocompleteInput.value);
            streetAutocompleteInput.focus();
            streetAutocompleteInput.style.borderColor = "red";
        }
    }
})