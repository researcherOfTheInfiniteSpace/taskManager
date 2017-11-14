import {taskView} from '/view/task';

const taskController = {
    addTask: function(newTask) {
        let params = Object.keys(newTask).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(newTask[k]) }
        ).join('&');
        let httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    window.location.href = '/';
                } else {
                    console.log(httpRequest);
                }
            }
        };
        httpRequest.open("POST", '/task&' + params);
        httpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send();
    },
    deleteTask: function(taskId) {
        let httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    window.location.href = '/';
                } else {
                    console.log(httpRequest);
                }
            }
        };
        httpRequest.open("DELETE", '/task&id=' + taskId);
        httpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send();
    }
}

export {taskController};
