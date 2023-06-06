<template>
    <v-autocomplete
        v-model="model"
        :disabled="loading"
        :loading="loading"
        :items="items"
        :label="label"
        :item-text="itemText"
        :item-value="itemValue"
        multiple
        hide-details
        dense
        clearable
    >
        <template #selection="{ index, item }">
            <v-chip small v-if="index < 2">
                {{ item[itemText] }}
            </v-chip>

            <span
                v-else-if="index === 2"
                class="grey--text text-caption"
            >
                +{{ model.length - 2 }}
            </span>
        </template>
    </v-autocomplete>
</template>

<script>
export default {
    name: 'MultipleAutocomplete',
    props: {
        value: {
            required: true
        },
        itemText: {
            type: String,
            default: 'title'
        },
        itemValue: {
            type: String,
            default: 'id'
        },
        label: {
            type: String,
            default: ''
        },
        loading: {
            type: Boolean,
            default: false
        },
        items: {
            type: Array,
            required: true
        }
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
};
</script>
