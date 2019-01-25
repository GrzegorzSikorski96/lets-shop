import { setAuthorization } from "./general";
import axios from "axios";

export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/login', credentials)
            .then((response) => {
                setAuthorization(response.data.token);
                res(response.data);
            })
            .catch((err) =>{
                rej(err);
            })
    })
}

export function register(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/register', credentials)
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                this.$toasted.show( err.data.message, {
                    type: 'error'
                });
            })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem("user");

    if(!userStr) {
        return null;
    }

    return JSON.parse(userStr);
}
