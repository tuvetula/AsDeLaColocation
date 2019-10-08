let numberOtherRoomate = document.getElementById('nbOfOtherRoommatePresent');
let otherRoommateSex = document.getElementById('otherRoommateSex');
let otherRoommateSexWomenValue = document.getElementById('otherRoommateSexWomenValue');
let otherRoommateSexMixteValue = document.getElementById('otherRoommateSexMixteValue');
let otherRoommateSexNullValue = document.getElementById('otherRoommateSexNullValue');

if (numberOtherRoomate.value == 0) {
    otherRoommateSex.style.display = "none";
} else if (numberOtherRoomate.value > 0) {
    otherRoommateSexNullValue.style.display = "none";
}
if (numberOtherRoomate.value < 2) {
    otherRoommateSexMixteValue.style.display = "none";
}

numberOtherRoomate.addEventListener("change", () => {
    //Affichage champ sex des colocataires deja présents
    if (numberOtherRoomate.value > 0) {
        otherRoommateSex.style.display = "block";
        otherRoommateSexNullValue.removeAttribute("selected");
        otherRoommateSexNullValue.style.display = "none";
        otherRoommateSexWomenValue.setAttribute("selected", "");
    } else {
        otherRoommateSex.style.display = "none";
        otherRoommateSexNullValue.setAttribute("selected", "");
        otherRoommateSexWomenValue.removeAttribute("selected");
    }
    //Affichage valeur mixte si plus de 1 colocataire deja présent
    if (numberOtherRoomate.value < 2) {
        otherRoommateSexMixteValue.style.display = "none";
    } else {
        otherRoommateSexMixteValue.style.display = "block";
    }
})