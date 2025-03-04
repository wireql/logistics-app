import http from "../index";

function getEmployees(token, params) {
    return http.get('employees', {
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

function storeEmployee(data, token) {
    return http.post('employees', data, {
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
    getEmployee,
    getEmployees,
    storeEmployee,
    updateEmployee,
    deleteEmployee
}