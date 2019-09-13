jQuery(function($) {
    // init the state from the input
    $(".image-checkbox").each(function() {
        if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
            $(this).addClass('image-checkbox-checked');
        } else {
            $(this).removeClass('image-checkbox-checked');
        }
    });

    // sync the state to the input
    $(".image-checkbox").on("click", function(e) {
        if ($(this).hasClass('image-checkbox-checked')) {
            $(this).removeClass('image-checkbox-checked');
            $(this).find('input[type="checkbox"]').first().removeAttr("checked");
        } else {
            $(this).addClass('image-checkbox-checked');
            $(this).find('input[type="checkbox"]').first().attr("checked", "checked");
        }

        e.preventDefault();
    });
});

//Alerte avant suppression
let deleteButton = document.getElementById('modifyAdvertisementDeletePictureButton');


function confirmationBeforeDelete(url) {
    let deleteForm = document.getElementById('modifyAdvertisementDeletePictureForm');
    if (confirm("Êtes-vous sûr de vouloir supprimer?")) {
        deleteForm.action = url;
    } else {
        return false;
    }
}

// function clic() {
//     alert(this.id);
//     return false;
// }

// function load() {
//     var liens = document.getElementsByTagName('img');
//     for (var i = 0; i < liens.length; i++)
//         liens[i].setAttribute("id", "image" + i);

// }
// window.onload = load();

// picture3 = document.getElementById('image2');
// picture3.addEventListener("click", function() {
//     picture3.setAttribute("checked", "");
// })