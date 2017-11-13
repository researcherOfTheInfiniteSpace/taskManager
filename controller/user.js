import {userView} from '/view/user';

const userController = {
    getAll: function() {
        let httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    userView.userDisplay(httpRequest.response);
                } else {
                    console.log(httpRequest);
                }
            }
        };
        httpRequest.open("GET", '/user/all');
        httpRequest.send();
    },
    addUser: function(e) {
        e.preventDefault();
        let newUser = {
            title: document.querySelectorAll('input[name="title"]')[0].value,
            email: document.querySelectorAll('input[name="email"]')[0].value
        };
        let params = Object.keys(newUser).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(newUser[k]) }
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
        httpRequest.open("POST", '/user&' + params);
        httpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send();
    },
    deleteUser: function(userId) {
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
        httpRequest.open("DELETE", '/user&id=' + userId);
        httpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send();
    }
}

export {userController};
