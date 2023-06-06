export default {
    methods: {
        genUID() {    // TODO: Rename?
            this.$store.commit('uid/increment');

            return this.$store.state.uid.counter;
        }
    }
};
