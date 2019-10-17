//Barre de recherche (liste utilisateurs)
let searchBar = document.getElementById('searchBar');
//Etat à l'arrivée sur la page (pour retour sur page avec "page précedente")
let divUserCard = document.getElementsByClassName('card');
for (let i = 0; i < divUserCard.length; i++) {
    let divUserInfo = divUserCard[i].getElementsByClassName('userInfo');
    for (let j = 0; j < divUserInfo.length; j++) {
        for (let k = 0; k < divUserInfo[j].children.length; k++) {
            if (!divUserInfo[j].children[k].innerText.toLowerCase().includes(searchBar.value.toLowerCase())) {
                divUserCard[i].hidden = true;
            } else {
                divUserCard[i].hidden = false;
            }
        }
    }
}
//AddEventListener (sur changement du innerText de la barre de recherche) 
searchBar.addEventListener('input', function() {
    let divUserCard = document.getElementsByClassName('card');
    for (let i = 0; i < divUserCard.length; i++) {
        let divUserInfo = divUserCard[i].getElementsByClassName('userInfo');
        for (let j = 0; j < divUserInfo.length; j++) {
            // let divUserInfoNbOfChildren = divUserInfo[j].children.length;
            let divUserCardStatue = divUserCard[i].hidden;
            for (let k = 0; k < divUserInfo[j].children.length; k++) {
                if (k == 0) {
                    if (divUserInfo[j].children[k].innerText.toLowerCase().includes(searchBar.value.toLowerCase().trim())) {
                        divUserCard[i].hidden = false;
                    } else {
                        divUserCard[i].hidden = true;
                    }
                } else {
                    let divUserCardNewStatue = divUserCard[i].hidden;
                    if (divUserCardStatue != divUserCardNewStatue && !divUserCardStatue) {
                        if (divUserInfo[j].children[k].innerText.toLowerCase().includes(searchBar.value.toLowerCase().trim())) {
                            divUserCard[i].hidden = false;
                        } else {
                            divUserCard[i].hidden = true;
                        }
                    }
                }
            }
        }
    }
});