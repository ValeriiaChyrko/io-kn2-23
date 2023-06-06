import axios from 'axios';

export default {
    namespaced: true,

    state: {
        providers: [],

        loaded: false,
        loading: false
    },
    getters: {
        find: state => id => state.providers.find(provider => provider.id === id) ?? {}
    },
    mutations: {
        set(state, providers) {
            state.providers = providers;
        },
        unshift(state, provider) {
            state.providers.unshift(provider);
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
                    const { data } = await axios.get('/api/providers', {
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
