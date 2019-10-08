function requestAjaxPost(advertisementId) {
    let dataToPost = 'advertisementId=' + advertisementId;
    var req = new XMLHttpRequest();
    var filename = "https://app.asdelacoloc.fr/model/ajax/m_modifyIsActive.php";
    req.open("POST", filename, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(dataToPost);

    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            console.log('requete executée ');
            console.log(this.responseText);
        }
    }
}