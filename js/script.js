function confirmation() {
    return confirm("Are you sure you want to delete this ?");
}

function passwordOK(form) {

    console.log("passwordChecking...");
    var username = form.userName.value.trim();
    var password = form.password.value;
    var repassword = form.repassword.value;

    if (username == "" || password == "" || password != repassword) {
        alert("passwords not matching!");
        return false;
    } else {
        return true;
    }
}

function userDeleteConfirmation(userName) {
    let name = userName;
    return confirm("Are you sure you want to delete <b>" + name + "</b>?");
}