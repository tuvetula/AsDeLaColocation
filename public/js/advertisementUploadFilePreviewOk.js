// Add the following code if you want the name of the file appear on select
// let typeFileInput1 = document.getElementById('customFile1');
// typeFileInput1.addEventListener('change', function() {
//     if (typeFileInput1.value != "") {
//         typeFileInput1.textContent = typeFileInput1.value;
//     } else {
//         typeFileInput1.textContent = "";
//     }
// })
function handleFiles(files) {
    let input = document.getElementById('upload');
    var imageType = /^image\//;
    if (files.length <= 10) {
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!imageType.test(file.type)) {
                alert("veuillez sélectionner une image");
            } else {
                if (i == 0) {
                    preview.innerHTML = '';
                }
                let imgDiv = document.createElement("div");
                imgDiv.classList.add("imageAddPreview");
                imgDiv.classList.add("col-md-4");
                imgDiv.classList.add("p-0");

                var img = document.createElement("img");
                img.classList.add("img-responsive");
                img.classList.add("img-thumbnail");

                img.file = file;
                imgDiv.appendChild(img);
                preview.appendChild(imgDiv);

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