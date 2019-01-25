import { setAuthorization } from "./general";
import axios from "axios";

export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/auth/login', credentials)
            .then((response) => {
                setAuthorization(response.data.token);
                res(response.data);
            })
            .catch((err) =>{
                Vue.toasted.show('Błędny email lub hasło', {
                    type: 'error'
                });
            })
    })
}

export function register(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/auth/register', credentials)
            .then((response) => {
                res(response.data);
            })
            .catch((err) => {
                this.$toasted.show('Nie udało się utworzyć konta', {
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
