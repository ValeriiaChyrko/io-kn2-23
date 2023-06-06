export default {
    namespaced: true,

    state: {
        counter: 0
    },
    mutations: {
        increment(state) {
            state.counter++;
        }
    }
};
