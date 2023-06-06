<template>
    <multiple-autocomplete
        v-model="model"
        :items="$store.state.types.types"
        :loading="$store.state.types.loading"
        :label="label"
        item-value="id"
        item-text="title"
    />
</template>

<script>
import MultipleAutocomplete from '~/components/Inputs/MultipleAutocomplete';

export default {
    name: 'TypeMultipleAutocomplete',
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
        this.$store.dispatch('types/fetch');
    }
};
</script>
