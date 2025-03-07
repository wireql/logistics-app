import http from "../index";

function getVehicles(token, params) {
    return http.get('vehicles', {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

function getVehicleCategories(token) {
    return http.get('vehicle-categories', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function getVehicleStatuses(token) {
    return http.get('vehicle-statuses', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function getBodyTypes(token) {
    return http.get('body-types', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function getVehicle(token, id) {
    return http.get('vehicles/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function storeVehicle(data, token) {
    return http.post('vehicles', data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function updateVehicle(data, id, token) {
    return http.put('vehicles/'+id, data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function deleteVehicle(token, id) {
    return http.delete('vehicles/'+id, {
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
    getBodyTypes,
    getVehicleStatuses
}