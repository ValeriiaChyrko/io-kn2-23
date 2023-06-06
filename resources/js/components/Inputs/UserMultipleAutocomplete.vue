<template>
    <multiple-autocomplete
        v-model="model"
        :items="$store.state.users.users"
        :loading="$store.state.users.loading"
        :label="label"
        item-value="id"
        item-text="name"
    />
</template>

<script>
import MultipleAutocomplete from '~/components/Inputs/MultipleAutocomplete';

export default {
    name: 'UserMultipleAutocomplete',
    components: {
        MultipleAutocomplete
    },
    props: {
        value: {
            required: true
        },
        label: {
            type: String,
            default: ''
        },
    },
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
    created() {
        this.$store.dispatch('users/fetch');
    }
};
</script>
