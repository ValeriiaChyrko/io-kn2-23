<template>
    <v-autocomplete
        v-model="internalValue"
        :error-messages="errors"
        :items="items"
        :search-input.sync="search"
        :loading="isLoading"
        :hide-no-data="!isLoadedData"
        :disabled="disabled"
        label="Батьківстький предмет"
        item-text="inventory_number"
        item-value="id"
        cache-items
        clearable
    />
</template>

<script>
//TODO: Review component

import { debounce } from 'lodash-es';

export default {
    name: 'InventoryItemSearch',
    props: {
        value: {
            required: true
        },
        errors: {},
        disabled: {
            type: Boolean
        }

    },
    data() {
        return {
            search: null,

            isLoading: false,
            isLoadedData: false,

            items: []
        };
    },
    computed: {
        internalValue: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    watch: {
        search: debounce(function() {
            this.loadItems();

        }, 350)
    },
    methods: {
        loadItems() {
            if(this.search === '' || !this.search) {
                this.isLoadedData = false;
                this.items = [];
                return;
            }

            this.isLoading = true;

            axios.get(`/api/items/inventory-number/${ this.search }`)
            .then(response => {
                this.items = response.data;
                this.isLoadedData = true;
            }).finally(() => {
                this.isLoading = false;
            });
        }
    }
};
</script>
