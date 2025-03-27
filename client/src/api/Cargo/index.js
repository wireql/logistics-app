import http from "../index";

function storeCargo(data, token, routeListId, routePointId) {
    return http.post('route-lists/' + routeListId + '/route-points/' + routePointId + "/cargos", data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function getCargos(token, routeListId, routePointId, params) {
    return http.get('route-lists/' + routeListId + '/route-points/' + routePointId + "/cargos", {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

export {
    storeCargo,
    getCargos
}