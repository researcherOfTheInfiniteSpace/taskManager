import {userController} from '/controller/user';
import {taskView} from '/view/task';

const userView = {
    userDisplay: function(data) {
        data = JSON.parse(data);
        data.forEach(user => {
            //create new User
            let newUser = document.getElementById('container').childNodes[1].cloneNode(true);
            newUser.id = user.id;
            newUser.dataset.email = user.email;
            let userName = document.createElement('span');
            userName.classList.add('userName');
            userName.appendChild(document.createTextNode(user.name));
            newUser.insertBefore(userName, newUser.getElementsByClassName('deleteUser')[0]);
            newUser.getElementsByClassName('deleteUser')[0].onclick = function(){userView.deleteUser(user.id)};
            newUser.classList.remove('hidden');
            if(user.tasks && typeof user.tasks == "object") {
                taskView.taskDisplay(newUser, user.tasks);
            } else {
                taskView.taskDisplay(newUser);
            }
            container.insertBefore(newUser, document.getElementById('addUser'));
        });
    },
    deleteUser: function(userId) {
        let result = window.confirm('Êtes vous sur de vouloir supprimer cet utilisateur ?');
        if(result) {
            userController.deleteUser(userId)
        }
    }
}

export {userView};
