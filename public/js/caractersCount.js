//Count Description
let textArea = document.getElementById('description');
let countDescription = document.getElementById('countDescription');
countDescription.innerHTML = textArea.value.length + "/2000";
countDescription.style.color = "gray";
textArea.addEventListener('keyup', function() {
    countDescription.innerHTML = textArea.value.length + "/2000";
    if (textArea.value.length >= 2000) {
        countDescription.style.color = "red";
        countDescription.style.fontWeight = "bold";
    } else {
        countDescription.style.color = "gray";
        countDescription.style.fontWeight = "normal";
    }
});
//Count Title
if (document.getElementById('title')) {
    let inputTitle = document.getElementById('title');
    let countTitle = document.getElementById('countTitle');
    countTitle.innerHTML = inputTitle.value.length + "/80";
    countTitle.style.color = "gray";
    inputTitle.addEventListener('keyup', function() {
        countTitle.innerHTML = inputTitle.value.length + "/80";
        if (inputTitle.value.length >= 80) {
            countTitle.style.color = "red";
            countTitle.style.fontWeight = "bold";
        } else {
            countTitle.style.color = "gray";
            countTitle.style.fontWeight = "normal";
        }
    });
}