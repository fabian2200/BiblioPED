import axios from 'axios';

export function http() {
    return axios.create({
        baseURL: 'http://192.168.1.76:8000/'
        //baseURL: 'https://192.168.101.160/'
    });
}