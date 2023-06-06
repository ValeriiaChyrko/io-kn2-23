<template>
    <autocomplete-with-creation
        v-model="internalValue"
        @created="storeCreatedType($event)"
        :disabled="isDisabled"
        :errors="errors"
        :items="$store.state.types.types"
        :loading="isLoading"
        api-endpoint="/api/types"
        item-text="title"
        item-value="id"
    />
</template>

<script>
import AutocompleteWithCreation from '~/components/DataTable/AutocompleteWithCreation';

export default {
    name: 'TypeAutocomplete',
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
            return this.$store.state.types.loading;
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
        storeCreatedType(createdType) {
            this.$store.commit('types/unshift', createdType);
        }
    },
    created() {
        this.$store.dispatch('types/fetch');
    }
};
</script>
