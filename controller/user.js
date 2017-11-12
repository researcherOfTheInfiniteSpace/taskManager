import {userView} from '/view/user';

const userController = {
    getAll: function() {
        let httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    userView.userDisplay(httpRequest.response);
                } else {
                    console.log('There was a problem with the request.');
                }
            }
        };
        httpRequest.open("GET", '/user/all');
        httpRequest.send();
    }
}

export {userController};
