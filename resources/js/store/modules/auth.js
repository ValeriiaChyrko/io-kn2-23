import axios from 'axios';

export default {
    namespaced: true,

    state: {
        user: window.config.data.user
    },
    getters: {
        user: state => state.user,
        userId: state => state.user?.id,
        check: state => state.user !== null,
        role: state => state.user.role
    },
    mutations: {
        fetchUserSuccess(state, { user }) {
            state.user = user;
        },

        logout(state) {
            state.user = null;
        }
    },
    actions: {
        async fetchUser({ commit }) {
            try {
                const { data } = await axios.get('/api/user');

                commit('fetchUserSuccess', { user: data });
            } catch (e) { }
        },

        async logout({ commit }) {
            try {
                await axios.post('/logout');
            } catch (e) { }

            commit('logout');
        },

        async fetchGoogleOauthUrl() {
            const { data } = await axios.get('/login/google/redirect');

            return data.url;
        }
    }
};
