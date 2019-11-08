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



//Attente évènement blur sur saisie dans le champ streetAutocomplete
// streetAutocompleteInput.addEventListener('blur', function() {
//     let ulChoices = document.getElementById('ulAutocompleteChoices');
//     let childrenFocus = 0;
//     if (streetAutocompleteInput.value.length>0 && ){
//         for (let i = 0; i < ulChoices.children.length; i++) {
//             if (ulChoices.children[i].children[0].issetFocus == 1) {
//                 childrenFocus = 1;
//             }
//         }
//         if (childrenFocus == 0) {
//             streetAutocompleteInput.focus();
//         }
//     }
// });

//Attente évènement input sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('input', function() {
    streetInput.value = "";
    zipcodeInput.value = "";
    cityInput.value = "";
    countryInput.value = "";
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
                if (results.length > 0) {
                    //Création ul
                    let ul = document.createElement('ul');
                    ul.setAttribute('id', 'ulAutocompleteChoices');
                    ul.setAttribute('issetFocus', '0');
                    ul.style.backgroundColor = "rgb(255,255,255)";
                    ul.style.listStyleType = "none";
                    ul.classList.add('row');
                    ul.classList.add('col-md-9');
                    ul.classList.add('ml-0');
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
                        addressLineButton.classList.add('px-0');
                        addressLineButton.setAttribute('tabindex', '0');
                        addressLineButton.setAttribute('type', 'button');
                        addressLineButton.setAttribute('onclick', 'completeAddress(this.textContent)');
                        addressLineButton.setAttribute('onmouseover', 'mouseoverstyle(this)');
                        addressLineButton.setAttribute('onmouseout', 'normalstyle(this)');
                        addressLineButton.setAttribute('onkeydown', 'keydown(this,event)');
                        addressLineButton.setAttribute('onfocus', 'onfocusSet(this)');
                        addressLineButton.setAttribute('onblur', 'onblurSet(this)');
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
    };
    xhr.send();
});

//Fonction onclick sur button adresse
function completeAddress(text) {
    data.features.forEach(element => {
        if (element.properties.label == text) {
            streetAutocompleteInput.value = element.properties.label;
            streetInput.value = element.properties.name;
            zipcodeInput.value = element.properties.postcode;
            cityInput.value = element.properties.city;
            countryInput.value = "France";
        }
    })
    streetAutocompleteDiv.removeChild(streetAutocompleteDiv.lastChild);
}
//Fonction mouseover
function mouseoverstyle(elt) {
    elt.style.backgroundColor = "rgb(233, 236, 239)";
    elt.style.cursor = "pointer";
}
//Fonction mouseout
function normalstyle(elt) {
    elt.style.backgroundColor = "rgb(255,255,255)";
}
//Fonction keyDown
function keydown(elt, e) {
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    ulNbOfChildren = elt.parentNode.parentNode.children.length;
    //Fleche du haut
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
        //Flèche du bas
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
    }
}

function onfocusSet(elt) {
    elt.setAttribute('issetFocus', '1');
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    ulChoices.setAttribute('issetFocus', '1');

}

function onblurSet(elt) {
    elt.setAttribute('issetFocus', '0');
    let ulChoices = document.getElementById('ulAutocompleteChoices');
    ulChoices.setAttribute('issetFocus', '0');
}