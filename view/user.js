import {userController} from '/controller/user';

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
            userName.appendChild(document.createTextNode(user.title));
            newUser.insertBefore(userName, newUser.getElementsByClassName('deleteUser')[0]);
            newUser.getElementsByClassName('deleteUser')[0].onclick = function(){userView.deleteUser(user.id)};
            newUser.classList.remove('hidden');
            if(user.tasks && typeof user.tasks == "object") {
                user.tasks.forEach(task => {
                    let newTask = document.getElementById('container').childNodes[1].getElementsByClassName('taskModel')[0].cloneNode(true);
                    newTask.id = task.id;
                    let taskTitle = document.createElement('span');
                    taskTitle.appendChild(document.createTextNode(task.title));
                    newTask.insertBefore(taskTitle, newTask.getElementsByClassName('deleteTask')[0]);
                    newTask.getElementsByTagName('description')[0].appendChild(document.createTextNode(task.description));
                    newTask.classList.remove('hidden');
                    newTask.classList.remove('taskModel');
                    newUser.getElementsByTagName('ul')[0].appendChild(newTask);
                });
            } else {
                newUser.getElementsByTagName('ul')[0].classList.add('hidden');
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
