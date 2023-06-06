<template>
    <v-autocomplete
        v-model="model"
        :disabled="loading"
        :loading="loading"
        :items="roles"
        label="Роль"
        item-text="name"
        item-value="id"
    />
</template>

<script>
export default {
    name: 'RoleAutocomplete',
    props: {
        value: {
            required: true
        },
        errorMessages: {}
    },
    data: () => ({
        loading: false,
        roles: []
    }),
    computed: {
        model: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    methods: {
        async loadRoles() {
            this.loading = true;
            this.roles = (await axios.get('/api/roles')).data.data;
            this.loading = false;
        }
    },
    created() {
        this.loadRoles();
    }
};
</script>
