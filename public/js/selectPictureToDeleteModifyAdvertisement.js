let inputCheckbox = document.getElementsByName('pictureToDelete[]');
for (let i = 0; i < inputCheckbox.length; i++) {
    inputCheckbox[i].style.display = "none";
}

function changeStatue(id, event) {
    let labelTochange = document.getElementById(id);
    let classListLabel = labelTochange.classList;
    if (classListLabel.contains('image-checkbox-checked')) {
        //Calcul nombre de nouvelles photos selectionnées
        let inputDiv = document.getElementById('inputDiv');
        let nbchildrenDivInput = inputDiv.children.length;
        let countNbOfFiles = 0;
        for (let z = 0; z < nbchildrenDivInput; z++) {
            countNbOfFiles += inputDiv.children[z].files.length;
        }
        //Calcul nombre de photos déja présente et non-cochées
        let inputDivDeletePictures = document.getElementsByName('pictureToDelete[]');
        if (inputDivDeletePictures != null) {
            let nbchildrenDivDeletePictures = inputDivDeletePictures.length;
            let countNbOfFilesPresentPictures = 0;
            for (let y = 0; y < nbchildrenDivDeletePictures; y++) {
                if (!inputDivDeletePictures[y].hasAttribute('checked')) {
                    countNbOfFilesPresentPictures++;
                }
            }
            countNbOfFiles += countNbOfFilesPresentPictures;
        }
        if (countNbOfFiles < 10) {
            classListLabel.remove('image-checkbox-checked');
            labelTochange.getElementsByTagName('input')[0].removeAttribute('checked');
        } else {
            alert("Votre annonce peut contenir 10 photos maximum");
        }

    } else {
        classListLabel.add('image-checkbox-checked');
        labelTochange.getElementsByTagName('input')[0].setAttribute('checked', 'checked');
    }
    event.preventDefault();
}