let errors = document.getElementsByTagName('p');
for (let i = 0; i < errors.length; i++) {
    if (errors[i].getAttribute("type") == "error") {
        errors[i].parentNode.getElementsByTagName('input')[0].style.borderColor = "rgb(217,83,79)";
        errors[i].parentNode.getElementsByTagName('input')[0].style.borderWidth = "2px";
        errors[i].parentNode.getElementsByTagName('input')[0].addEventListener('input', function() {
            this.style.borderColor = "rgb(209,213,216)";
            this.borderWidth = "1px";
            if (this.parentNode.getElementsByTagName('p').length > 0) {
                this.parentNode.removeChild(this.parentNode.getElementsByTagName('p')[0]);
            }
        })
    }
    if (errors[i].getAttribute("type") == "errorT") {
        errors[i].parentNode.getElementsByTagName('textarea')[0].style.borderColor = "rgb(217,83,79)";
        errors[i].parentNode.getElementsByTagName('textarea')[0].style.borderWidth = "2px";
        errors[i].parentNode.getElementsByTagName('textarea')[0].addEventListener('input', function() {
            this.style.borderColor = "rgb(209,213,216)";
            this.borderWidth = "1px";
            if (this.parentNode.getElementsByTagName('p').length > 0) {
                this.parentNode.removeChild(this.parentNode.getElementsByTagName('p')[0]);
            }
        })
    }
}