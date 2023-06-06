import axios from 'axios';

export default {
    namespaced: true,

    state: {
        softwareModels: [],

        loaded: false,
        loading: false
    },
    getters: {
        find: state => id => state.softwareModels.find(model => model.id === id) ?? {}
    },
    mutations: {
        set(state, softwareModels) {
            state.softwareModels = softwareModels;
        },
        unshift(state, softwareModel) {
            state.softwareModels.unshift(softwareModel);
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
                    const { data } = await axios.get('/api/software-models', {
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
