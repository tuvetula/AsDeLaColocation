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
                var img = document.createElement("img");
                img.classList.add("col-md-4");
                img.classList.add("img-responsive");
                img.classList.add("py-2");
                img.classList.add("obj");
                img.file = file;
                preview.appendChild(img);

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