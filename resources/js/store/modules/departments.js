import axios from 'axios';

export default {
    namespaced: true,

    state: {
        departments: [],

        loaded: false,
        loading: false
    },
    getters: {
        find: state => id => state.departments.find(department => department.id === id) ?? {}
    },
    mutations: {
        set(state, departments) {
            state.departments = departments;
        },
        unshift(state, department) {
            state.departments.unshift(department);
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
                    const { data } = await axios.get('/api/departments', {
                        params: {
                            perPage: -1
                        }
                    });
                    commit('set', data.data);
                    commit('markAsLoaded');
                } catch(e) {
                    console.error(e);    // FIXME
                }
                commit('markAsLoading', false);
            }
        }
    }
};
