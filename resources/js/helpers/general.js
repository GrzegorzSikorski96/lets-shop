import axios from 'axios';

export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const currentUser = store.state.currentUser;

        if (to.matched.some(record => record.meta.forVisitors)) {
            if (currentUser) {
                next({
                    path: "/"
                })
            } else next();
        } else {
            next();
        }
    });

    axios.interceptors.response.use(null, (error => {
        switch (error.response.status) {
            case 401: {
                store.commit('logout');
                router.push('/login');
                break;
            }
            case 404: {
                router.push('/');
                break;
            }
        }
    }));

    if (store.getters.currentUser) {
        setAuthorization(store.getters.getToken);
    }
}

export function setAuthorization(token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    axios.defaults.headers.common["Access-Control-Allow-Origin"] = '*';
}