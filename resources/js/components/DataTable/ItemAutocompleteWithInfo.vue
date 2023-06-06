<template>
    <v-autocomplete
        v-model="internalValue"
        :error-messages="errorMessages"
        :items="items"
        :item-disabled="disableUnrepairable ? 'is_unrepairable' : 'disabled'"
        :label="label"
        :multiple="multiple"
        :chips="chips"
        item-text="inventory_number"
        item-value="id"
        clearable
    >
        <template #selection="{ item }">
            <template v-if="item.inventory_number">{{ item.inventory_number }} - </template>{{ item.type_title }}
        </template>

        <template #item="{ item, attrs }">
            <v-list-item-content>
                <v-list-item-title>
                    <template v-if="item.inventory_number">{{ item.inventory_number }} - </template>{{ item.owner_name }}
                </v-list-item-title>
                <v-list-item-subtitle>
                    <v-icon :disabled="attrs.disabled" x-small>mdi-home</v-icon>
                    {{ item.department_title }}
                    <template v-if="item.user">
                        <v-icon :disabled="attrs.disabled" x-small>mdi-account</v-icon>
                        {{ item.user.name }}
                    </template>
                    <br/>
                    <span
                        :class="attrs.disabled ? 'text--secondary' : 'text--primary'"
                    >
                        {{ item.type_title }}
                    </span> - {{ item.hardware_model_title }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </template>
    </v-autocomplete>
</template>

<script>
export default {
    name: 'ItemAutocompleteWithInfo',
    props: {
        value: {},
        errorMessages: {},

        items: {
            type: Array,
            required: true
        },
        label: {
            type: String,
            default: ''
        },
        disableUnrepairable: {
            type: Boolean,
            default: false
        },
        multiple: {
            type: Boolean,
            default: false
        },
        chips: {
            type: Boolean,
            default: false
        }
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
    }
};
</script>
