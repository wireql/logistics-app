import http from "../index";

async function getUser(token) {
    return await http.get('user', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function registerUser(data) {
    return await http.post('register', data);
}

async function loginUser(data) {
    return await http.post('login', data);
}

async function logoutUser(token) {
    return await http.post('logout', {}, {
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