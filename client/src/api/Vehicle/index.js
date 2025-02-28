import http from "../index";

async function getVehicles(token, params) {
    return await http.get('vehicles', {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

async function getVehicleCategories(token) {
    return await http.get('vehicle-categories', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function getBodyTypes(token) {
    return await http.get('body-types', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function getVehicle(token, id) {
    return await http.get('vehicles/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function storeVehicle(data, token) {
    return await http.post('vehicles', data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function updateVehicle(data, id, token) {
    return await http.put('vehicles/'+id, data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

async function deleteVehicle(token, id) {
    return await http.delete('vehicles/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

export {
    getVehicles,
    getVehicle,
    storeVehicle,
    updateVehicle,
    deleteVehicle,
    getVehicleCategories,
    getBodyTypes
}