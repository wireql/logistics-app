import http from "../index";

function getUser(token) {
    return http.get('user', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function registerUser(data) {
    return http.post('register', data);
}

function loginUser(data) {
    return http.post('login', data);
}

function logoutUser(token) {
    return http.post('logout', {}, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

export {
    getUser,
    registerUser,
    loginUser,
    logoutUser
}