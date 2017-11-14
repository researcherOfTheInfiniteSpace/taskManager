import {userController} from '/controller/user';

document.addEventListener("DOMContentLoaded", function(event) {
    //start App
    userController.getAll();

    //Action
    let addUser = document.getElementById('addUser').querySelectorAll('button[type="submit"]')[0];
    addUser.onclick = userController.addUser;

});
