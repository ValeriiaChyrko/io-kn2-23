import axios from 'axios';

export default {
    namespaced: true,

    state: {
        users: [],

        loaded: false,
        loading: false
    },
    getters: {
        find: state => id => state.users.find(user => user.id === id) ?? {}
    },
    mutations: {
        set(state, users) {
            state.users = users;
        },
        unshift(state, user) {
            state.users.unshift(user);
        },
        markAsLoaded(state) {
            state.loaded = true;
        },
        markAsLoading(state, isLoading = true) {
            state.loading = isLoading;
        }
    },
    actions: {
        async fetch({ state, commit }) {
            if(!state.loaded && !state.loading) {
                commit('markAsLoading');
                try {
                    const { data } = await axios.get('/api/users', {
                        params: {
                            perPage: -1
                        }
                    });
                    commit('set', data.data);
                    commit('markAsLoaded');
                } catch(e) {
                    console.error(e);
                }
                commit('markAsLoading', false);
            }
        }
    }
};
