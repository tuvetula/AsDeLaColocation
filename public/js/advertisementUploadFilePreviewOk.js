function handleFiles(files, id) {
    let inputDiv = document.getElementById('inputDiv');
    let nbchildrenDivInput = inputDiv.children.length;
    let countNbOfFiles = 0;
    for (let z = 0; z < nbchildrenDivInput; z++) {
        countNbOfFiles += inputDiv.children[z].files.length;
    }
    let input = document.getElementById(id);
    var imageType = /^image\//;
    if (countNbOfFiles <= 10) {
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!imageType.test(file.type)) {
                alert("Veuillez sélectionner une image");
                input.value = "";
            } else {
                if (i == 0) {
                    preview.innerHTML = '';
                }

                let imgDiv = document.createElement("div");
                imgDiv.classList.add("imageAddPreview");
                imgDiv.classList.add("col-md-4");
                imgDiv.classList.add("p-0");
                preview.appendChild(imgDiv);

                var img = document.createElement("img");
                // img.file = file;
                img.classList.add("img-responsive");
                img.classList.add("img-thumbnail");
                imgDiv.appendChild(img);


                var reader = new FileReader();
                reader.onload = (function(aImg) {
                    return function(e) {
                        aImg.src = e.target.result;
                    };
                })(img);
                reader.readAsDataURL(file);
            }
        }
    } else {
        alert("Vous devez sélectionner 10 images maximum");
        //On efface les anciennes photos
        input.value = "";
        //On supprime les anciennes photos de la view
        preview.innerHTML = '';
    }
}