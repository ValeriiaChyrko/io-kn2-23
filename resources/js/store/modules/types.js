import axios from 'axios';

export default {
    namespaced: true,

    state: {
        types: [],

        loaded: false,
        loading: false
    },
    getters: {
        find: state => id => state.types.find(type => type.id === id) ?? {}
    },
    mutations: {
        set(state, types) {
            state.types = types;
        },
        unshift(state, type) {
            state.types.unshift(type);
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
                    const { data } = await axios.get('/api/types', {
                        params: {
                            perPage: -1
                        }
                    });
                    commit('set', data.data);
                    commit('markAsLoaded');
                } catch (e) {
                    console.error(e);
                }
                commit('markAsLoading', false);
            }
        }
    }
};
