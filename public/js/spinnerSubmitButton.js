function spinnerSubmitButton() {
    let submitButton = document.getElementById('submitButton');
    let spinner = document.createElement('span');
    let classListSpinner = spinner.classList;
    classListSpinner.add('spinner-border');
    classListSpinner.add('spinner-border-sm');
    submitButton.innerText = 'Chargement...';
    submitButton.setAttribute('disabled', '');
    submitButton.appendChild(spinner);
}