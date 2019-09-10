let password1 = document.getElementById('passwordSubscribe1');
let password2 = document.getElementById('passwordSubscribe2');
let buttonSubscribe = document.getElementById('buttonSubscribe');
let form = document.getElementById('form1');

buttonSubscribe.addEventListener('click', function() {
    if (password1.value != password2.value) {
        password1.style.backgroundColor = "red";
        password2.style.backgroundColor = "red";
        form.action = "";
    }
})