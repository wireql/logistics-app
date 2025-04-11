import http from '../index';

function getAddresses(token, params) {
    return http.get('address', {
        headers: {
            Authorization: `Bearer ${token}`
        },
        params: params
    });
}

function getAddress(token, id) {
    return http.get('address/' + id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function getAddressCategories(token) {
    return http.get('address-categories', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function storeAddress(data, token) {
    return http.post('address', data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function updateAddress(data, id, token) {
    return http.put('address/' + id, data, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

function deleteAddress(token, id) {
    return http.delete('address/' + id, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });
}

export {
    getAddresses,
    getAddress,
    storeAddress,
    updateAddress,
    deleteAddress,
    getAddressCategories
};
