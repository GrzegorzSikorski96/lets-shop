import Vue from "vue"
import Vuex from "vuex"
import {getLocalUser} from './helpers/auth';
import {setAuthorization} from "./helpers/general";

Vue.use(Vuex);

const user = getLocalUser();

export default new Vuex.Store({
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        getToken(state) {
            if(state.currentUser) {
                return state.currentUser.token
            }
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.data.user, {token: payload.token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));

            Vue.toasted.show(payload.message, {
                type: 'success'
            });
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;

            Vue.toasted.show(payload.message, {
                type: 'error'
            });
        },
        logout(state) {
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
            state.calendars = [];

            Vue.toasted.show('Wylogowano', {
                type: 'success'
            });
        },
        register(state) {
            state.loading = true;
            state.auth_error = null;
        },
        registerFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;

            Vue.toasted.show(payload.message, {
                type: 'error'
            });
        },
        registerSuccess(state, payload) {
            state.auth_error = null;
            state.loading = false;

            Vue.toasted.show(payload.message, {
                type: 'success'
            });
        },
        refreshToken(state, payload) {
            if(state.currentUser) {
                state.currentUser.token = payload;
                localStorage.setItem("user", JSON.stringify(state.currentUser));
                setAuthorization(payload);
            }
        },
    },
    actions: {
        login(context) {
            context.commit("login");
        },
        register(context) {
            context.commit("register");
        },
    }
})