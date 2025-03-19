import http from "../index";

function getRouteLists(token, params) {
    return http.get('route-lists', {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

function getRouteList(token, id) {
    return http.get('route-lists/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function getRouteListDocument(token, id) {
    return http.get('documents/route-lists/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        },
        responseType: 'blob'
    });
}

function storeRouteList(data, token) {
    return http.post('route-lists', data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function updateRouteList(data, id, token) {
    return http.put('route-lists/'+id, data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function deleteRouteList(token, id) {
    return http.delete('route-lists/'+id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

export {
    storeRouteList,
    getRouteLists,
    updateRouteList,
    getRouteList,
    deleteRouteList,
    getRouteListDocument
}