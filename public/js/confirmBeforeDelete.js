function confirmation(url, advertisementId) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette annonce?")) {
        document.location.href = url + advertisementId;
    } else {
        return false;
    }
}