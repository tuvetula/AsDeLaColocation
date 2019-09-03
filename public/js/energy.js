//Lettre class energie Performance
let energyClassNumber = document.getElementById("energyClassNumber");
let energyClassLetterView = document.getElementById("energyClassLetterView");
let energyClassLetterInput = document.getElementById("energyClassLetterInput");

energyClassNumber.addEventListener("input", function() {
    if (energyClassNumber.value <= 50) {
        energyClassLetterView.textContent = "A";
        energyClassLetterView.style.backgroundColor = "rgb(13, 219, 157)";
    } else if (energyClassNumber.value > 50 && energyClassNumber.value <= 90) {
        energyClassLetterView.textContent = 'B';
        energyClassLetterView.style.backgroundColor = "rgb(97,241,39)";
    } else if (energyClassNumber.value > 90 && energyClassNumber.value <= 150) {
        energyClassLetterView.textContent = "C";
        energyClassLetterView.style.backgroundColor = "rgb(202,250,2)";
    } else if (energyClassNumber.value > 150 && energyClassNumber.value <= 230) {
        energyClassLetterView.textContent = "D";
        energyClassLetterView.style.backgroundColor = "rgb(249,221,23)";
    } else if (energyClassNumber.value > 230 && energyClassNumber.value <= 330) {
        energyClassLetterView.textContent = "E";
        energyClassLetterView.style.backgroundColor = "rgb(253,173,0)";
    } else if (energyClassNumber.value > 330 && energyClassNumber.value <= 450) {
        energyClassLetterView.textContent = "F";
        energyClassLetterView.style.backgroundColor = "rgb(252,113,48)";
    } else if (energyClassNumber.value > 450) {
        energyClassLetterView.textContent = "G";
        energyClassLetterView.style.backgroundColor = "rgb(217,70,84)";
    }
    if (energyClassNumber.value == "") {
        energyClassLetterView.textContent = "";
        energyClassLetterView.style.backgroundColor = "#e9ecef";
    }
    energyClassLetterInput.value = energyClassLetterView.textContent;
    // console.log("energyClassLetterInput: " + energyClassLetterInput.value);
});

//Lettre ges
let gesNumber = document.getElementById("gesNumber");
let gesLetterView = document.getElementById("gesLetterView");
let gesLetterInput = document.getElementById("gesLetterInput");
gesNumber.addEventListener("input", function() {
    if (gesNumber.value <= 5) {
        gesLetterView.textContent = "A";
        gesLetterView.style.backgroundColor = "rgb(13, 219, 157)";
    } else if (gesNumber.value > 5 && gesNumber.value <= 10) {
        gesLetterView.textContent = 'B';
        gesLetterView.style.backgroundColor = "rgb(97,241,39)";
    } else if (gesNumber.value > 10 && gesNumber.value <= 20) {
        gesLetterView.textContent = "C";
        gesLetterView.style.backgroundColor = "rgb(202,250,2)";
    } else if (gesNumber.value > 20 && gesNumber.value <= 35) {
        gesLetterView.textContent = "D";
        gesLetterView.style.backgroundColor = "rgb(249,221,23)";
    } else if (gesNumber.value > 35 && gesNumber.value <= 55) {
        gesLetterView.textContent = "E";
        gesLetterView.style.backgroundColor = "rgb(253,173,0)";
    } else if (gesNumber.value > 55 && gesNumber.value <= 80) {
        gesLetterView.textContent = "F";
        gesLetterView.style.backgroundColor = "rgb(252,113,48)";
    } else if (gesNumber.value > 80) {
        gesLetterView.textContent = "G";
        gesLetterView.style.backgroundColor = "rgb(217,70,84)";
    }
    if (gesNumber.value == "") {
        gesLetterView.textContent = "";
        gesLetterView.style.backgroundColor = "#e9ecef";
    }
    gesLetterInput.value = gesLetterView.textContent;
    // console.log("gesLetterInput: " + gesLetterInput.value);
});