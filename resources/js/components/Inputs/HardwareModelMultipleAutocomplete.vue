<template>
    <multiple-autocomplete
        v-model="model"
        :items="$store.state.hardwareModels.hardwareModels"
        :loading="$store.state.hardwareModels.loading"
        :label="label"
        item-value="id"
        item-text="title"
    />
</template>

<script>
import MultipleAutocomplete from '~/components/Inputs/MultipleAutocomplete';

export default {
    name: 'HardwareModelMultipleAutocomplete',
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
        this.$store.dispatch('hardwareModels/fetch');
    }
};
</script>
