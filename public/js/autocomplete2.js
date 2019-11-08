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
streetAutocompleteInput.setAttribute('list', 'places');
streetAutocompleteInput.setAttribute('placeholder', 'Saisir l\'adresse du logement');
streetAutocompleteInput.setAttribute('maxlength', '255');
streetAutocompleteInput.setAttribute('required', '');
streetAutocompleteInput.classList.add('col-md-12');
streetAutocompleteDiv.appendChild(streetAutocompleteInput);
//Création div
let div = document.createElement('datalist');
div.setAttribute('id', 'places');
streetAutocompleteDiv.appendChild(div);

//On remplit le champ avec adresse en bdd
if (streetInput.value.length > 0) {
    streetAutocompleteInput.value = streetInput.value + " " + zipcodeInput.value + " " + cityInput.value;
}
//On cache les champs adresse zipcode city country
// streetDiv.style.display = "none";
// zipcodeDiv.style.display = "none";
// cityDiv.style.display = "none";
// countryDiv.style.display = "none";



//Attente évènement blur sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('blur', function() {
    if (streetAutocompleteInput.value.length > 0) {
        let validValue;
        data.features.forEach(element => {
            if (element.properties.label == streetAutocompleteInput.value) {
                validValue = true;
                streetAutocompleteInput.value = element.properties.label;
                streetInput.value = element.properties.name;
                zipcodeInput.value = element.properties.postcode;
                cityInput.value = element.properties.city;
                countryInput.value = "France";
            }
        })
        if (!validValue) {
            streetAutocompleteInput.focus();
        }
    }
});
//Attente évènement input sur saisie dans le champ streetAutocomplete
streetAutocompleteInput.addEventListener('keyup', function() {
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
                let datalistPlaces = document.getElementById('places');
                while (datalistPlaces.children.length > 0) {
                    datalistPlaces.removeChild(datalistPlaces.lastChild);
                    console.log(datalistPlaces.children.length);
                }
                //On parse le json et le stocke dans data
                data = JSON.parse(xhr.responseText);
                let results = data.features;
                console.log(results);
                if (results.length > 0) {
                    results.forEach(element => {
                        let addressLine = document.createElement('option');
                        addressLine.value = element.properties.label;
                        div.appendChild(addressLine);
                    });
                }
            }
        }
    };
    xhr.send();
});