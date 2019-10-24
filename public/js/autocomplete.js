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
streetAutocompleteInput.addEventListener('blur', function() {
    if (streetAutocompleteInput.value.length > 0) {
        let validValue;
        data.features.forEach(element => {
            if (element.properties.label == streetAutocompleteInput.value) {
                validValue = true;
            }
        })
        if (!validValue) {
            streetAutocompleteInput.focus();
        }
    }
});
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
                let divAutocompleteChoices = document.getElementById('divAutocompleteChoices');
                if (divAutocompleteChoices) {
                    streetAutocompleteDiv.removeChild(divAutocompleteChoices);
                }
                if (results.length > 0) {
                    //Création div
                    let div = document.createElement('div');
                    div.setAttribute('id', 'divAutocompleteChoices');
                    div.style.backgroundColor = "rgb(255,255,255)";
                    div.classList.add('row');
                    div.classList.add('col-md-6');
                    div.classList.add('ml-0');
                    div.classList.add('border');
                    div.classList.add('border-primary');
                    div.classList.add('rounded');
                    //Remplissage div élément
                    results.forEach(element => {
                        let addressLine = document.createElement('p');
                        addressLine.classList.add('container-fluid');
                        addressLine.classList.add('px-0');
                        addressLine.innerText = element.properties.label;
                        addressLine.setAttribute('onclick', 'autocomplete(this.innerText)');
                        addressLine.setAttribute('onmouseover', 'mouseoverstyle(this)');
                        addressLine.setAttribute('onmouseout', 'normalstyle(this)');
                        div.appendChild(addressLine);
                    });
                    streetAutocompleteDiv.appendChild(div);
                }
            }
        }
    };
    xhr.send();
});
//Fonction onclick sur adresse api
function autocomplete(text) {
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