function changeIsMemberState(userId) {
    let dataToPost = 'userId=' + userId;
    var req = new XMLHttpRequest();
    var filename = "http://localhost/Asdelacoloc/model/ajax/m_modifyIsMember.php";
    req.open("POST", filename, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.send(dataToPost);

    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            console.log('requete executée');
            console.log(this.responseText);
        }
    }
}