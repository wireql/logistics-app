import http from "../index";

function getTasks(token, params) {
    return http.get('tasks', {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

function getEmployee(token, id) {
    return http.get('employees/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function storeTasks(data, token) {
    return http.post('tasks', data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function updateEmployee(data, id, token) {
    return http.put('employees/'+id, data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function deleteEmployee(token, id) {
    return http.delete('employees/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

export {
    storeTasks,
    getTasks
}