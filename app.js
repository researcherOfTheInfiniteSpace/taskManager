import {userController} from '/controller/user';

document.addEventListener("DOMContentLoaded", function(event) {
    //start App
    userController.getAll();
});
