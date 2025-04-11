import http from '../index';

function getRoutePoints(token, routeListId, params) {
    return http.get('route-lists/' + routeListId + '/route-points', {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

function getRoutePointCategories(token, params) {
    return http.get('route-point-categories', {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

function storeRoutePoint(data, token, routeListId) {
    return http.post('route-lists/' + routeListId + '/route-points', data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

export { storeRoutePoint, getRoutePoints, getRoutePointCategories };
