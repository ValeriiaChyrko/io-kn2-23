<template>
    <autocomplete-with-creation
        v-model="internalValue"
        @created="storeCreatedSoftwareModel($event)"
        :disabled="isDisabled"
        :errors="errors"
        :items="$store.state.softwareModels.softwareModels"
        :loading="isLoading"
        api-endpoint="/api/software-models"
        item-text="title"
        item-value="id"
    />
</template>

<script>
import AutocompleteWithCreation from '~/components/DataTable/AutocompleteWithCreation';

export default {
    name: 'SoftwareModelAutocomplete',
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
            return this.$store.state.softwareModels.loading;
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
        storeCreatedSoftwareModel(createdSoftwareModel) {
            this.$store.commit('softwareModels/unshift', createdSoftwareModel);
        }
    },
    created() {
        this.$store.dispatch('softwareModels/fetch');
    }
};
</script>
