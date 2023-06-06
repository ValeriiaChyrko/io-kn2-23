<template>
    <div>
        <v-autocomplete
            v-model="internalValue"
            @keydown.enter="enterPressed()"
            :disabled="disabled"
            :error-messages="errors"
            :items="items"
            :item-text="itemText"
            :item-value="itemValue"
            :loading="loading"
            :search-input.sync="search"
            ref="autocomplete"
        >
            <template slot="prepend-item">
                <v-list-item
                    @click="createNewItem()"
                    :disabled="!isCanCreateNewItem"
                >
                    <v-list-item-title>
                        <template v-if="isEmptyString">
                            Введіть значення
                        </template>
                        <template v-else>
                            <template v-if="isUniqueString">
                                Додати
                                <strong>{{ search }}</strong>
                            </template>
                            <template v-else>
                                Вже використовується
                            </template>
                        </template>
                    </v-list-item-title>
                </v-list-item>
            </template>
        </v-autocomplete>
    </div>
</template>

<script>
import { isEmpty } from 'lodash-es';
import Snackbar from '~/components/modules/Snackbar';

export default {
    name: 'AutocompleteWithCreation',
    props: {
        value: {
            required: true
        },
        errors: {},

        apiEndpoint: {
            type: String,
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        },

        items: {
            type: Array,
            required: true
        },
        itemText: {
            type: String,
            default: 'title'
        },
        itemValue: {
            type: String,
            default: 'id'
        }

    },
    data: () => ({
        search: null
    }),
    computed: {
        internalValue: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        },
        isUniqueString() {
            if(this.isEmptyString) {
                return false;
            }
            return (this.items.filter(obj => obj[this.itemText].toLowerCase() === this.search.toLowerCase()).length === 0);
        },
        isEmptyString() {
            return isEmpty(this.search);
        },

        isCanCreateNewItem() {
            return (this.isUniqueString && !this.isEmptyString);
        }
    },
    methods: {
        createNewItem() {
            if(this.isCanCreateNewItem) {
                let newRecord = {};
                newRecord[this.itemText] = this.search;

                axios.post(this.apiEndpoint, newRecord).then(response => {
                    this.$emit('created', response.data);

                    this.internalValue = response.data.id;

                    Snackbar.success('Додано');
                });
            }
        },
        enterPressed() {
            if(this.$refs.autocomplete.hasDisplayedItems === false) {    // TODO: Mark the line as a possible problem in the future
                this.createNewItem();
            }
        }
    }
};
</script>
