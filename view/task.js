import {taskController} from '/controller/task';

const taskView = {
    taskDisplay: function(node, tasks) {
        if(tasks) {
            tasks.forEach(task => {
                let newTask = document.getElementById('container').childNodes[1].getElementsByClassName('taskModel')[0].cloneNode(true);
                newTask.id = task.id;
                let taskTitle = document.createElement('span');
                taskTitle.appendChild(document.createTextNode(task.title));
                newTask.insertBefore(taskTitle, newTask.getElementsByClassName('deleteTask')[0]);
                newTask.getElementsByTagName('description')[0].appendChild(document.createTextNode(task.description));
                newTask.getElementsByClassName('deleteTask')[0].onclick = function(){taskView.deleteTask(task.id)};
                newTask.classList.remove('hidden');
                newTask.classList.remove('taskModel');
                node.getElementsByTagName('ul')[0].appendChild(newTask);
            });
        } else {
            node.getElementsByTagName('ul')[0].classList.add('hidden');
        }
        node.getElementsByClassName('addTask')[0].getElementsByTagName('button')[0].onclick = function(e) {
            e.preventDefault();
            let newTask = {user_id : node.id};
            node.getElementsByClassName('addTask')[0].childNodes.forEach(child => {
                if(child.tagName == 'INPUT') {
                    newTask[child.name] = child.value;
                }
            });
            console.log(newTask);
            taskController.addTask(newTask);
        };
    },
    deleteTask: function(taskId) {
        let result = window.confirm('Êtes vous sur de vouloir supprimer cette tâche ?');
        if(result) {
            taskController.deleteTask(taskId);
        }
    }
}

export {taskView};
