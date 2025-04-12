import axios from 'axios';
const BASE_URL = 'http://localhost:8000/api/';

const http = axios.create({
    baseURL: BASE_URL,
    withCredentials: true
});

http.defaults.headers.common['Content-Type'] = 'application/json';

export default http;
