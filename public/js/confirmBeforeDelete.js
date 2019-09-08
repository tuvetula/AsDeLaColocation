function confirmation(advertisementId) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette annonce?")) {
        document.location.href = 'index.php?page=deleteAdvertisement&id=' + advertisementId;
    } else {
        return false;
    }
}