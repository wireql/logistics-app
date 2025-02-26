import http from "../index";

async function getEmployees(token, params) {
    return await http.get('employees', {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

async function getEmployee(token, id) {
    return await http.get('employees/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function storeEmployee(data, token) {
    return await http.post('employees', data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function updateEmployee(data, id, token) {
    return await http.put('employees/'+id, data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function deleteEmployee(token, id) {
    return await http.delete('employees/'+id, {
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