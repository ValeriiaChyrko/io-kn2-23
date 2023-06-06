import axios from 'axios';

export default {
    namespaced: true,

    state: {
        hardwareModels: [],

        loaded: false,
        loading: false
    },
    getters: {
        find: state => id => state.hardwareModels.find(model => model.id === id) ?? {}
    },
    mutations: {
        set(state, hardwareModels) {
            state.hardwareModels = hardwareModels;
        },
        unshift(state, hardwareModel) {
            state.hardwareModels.unshift(hardwareModel);
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
                    const { data } = await axios.get('/api/hardware-models', {
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
