function changeStatue(id, event) {
    let labelTochange = document.getElementById(id);
    let classListLabel = labelTochange.classList;
    if (classListLabel.contains('image-checkbox-checked')) {
        classListLabel.remove('image-checkbox-checked');
        labelTochange.getElementsByTagName('input')[0].removeAttribute('checked');
    } else {
        classListLabel.add('image-checkbox-checked');
        labelTochange.getElementsByTagName('input')[0].setAttribute('checked', 'checked');
    }
    event.preventDefault();
}