import axios from 'axios';

export function http() {
    return axios.create({
        //baseURL: 'http://192.168.0.45:8000/'
        //baseURL: 'https://192.168.0.199:444/',
        baseURL: 'http://192.168.68.111:8000/',
    });
}