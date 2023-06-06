<template>
    <autocomplete-with-creation
        v-model="internalValue"
        @created="storeCreatedHardwareModel($event)"
        :disabled="isDisabled"
        :errors="errors"
        :items="$store.state.hardwareModels.hardwareModels"
        :loading="isLoading"
        api-endpoint="/api/hardware-models"
        item-text="title"
        item-value="id"
    />
</template>

<script>
import AutocompleteWithCreation from '~/components/DataTable/AutocompleteWithCreation';

export default {
    name: 'HardwareModelAutocomplete',
    components: {
        AutocompleteWithCreation
    },
    props: {
        value: {
            required: true
        },
        errors: {},
        disabled: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        isDisabled() {
            return this.isLoading || this.disabled;
        },
        isLoading() {
            return this.$store.state.hardwareModels.loading;
        },
        internalValue: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    methods: {
        storeCreatedHardwareModel(createdHardwareModel) {
            this.$store.commit('hardwareModels/unshift', createdHardwareModel);
        }
    },
    created() {
        this.$store.dispatch('hardwareModels/fetch');
    }
};
</script>
