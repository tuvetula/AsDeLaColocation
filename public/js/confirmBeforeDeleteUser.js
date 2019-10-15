function confirmationDeleteUser(url, userId) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur?")) {
        document.location.href = url + userId;
    } else {
        return false;
    }
}