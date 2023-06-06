<template>
    <v-menu
        v-model="isActiveDropdown"
        :close-on-content-click="false"
        :nudge-right="40"
        min-width="290px"
        transition="scale-transition"
        offset-y
    >
        <template #activator="{ on, attrs }">
            <v-text-field
                v-bind="attrs"
                v-model="formattedDate"
                v-on="on"
                :disabled="disabled"
                :error-messages="errors"
                :label="inputLabel"
                :prepend-icon="icon"
                clearable
                readonly
            />
        </template>
        <v-date-picker
            v-model="internalValue"
            no-title
        />
    </v-menu>
</template>

<script>
import DateFormatting from '~/components/mixins/DateFormatting';

export default {
    name: 'DatepickerDropdown',
    mixins: [
        DateFormatting
    ],
    props: {
        value: {},


        errors: {},
        inputLabel: {
            type: String,
            default: null
        },
        inputIcon: {
            type: String,
            default: 'mdi-calendar'
        },
        noInputIcon: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
        isActiveDropdown: false
    }),
    computed: {
        icon() {
            return this.noInputIcon ? null : this.inputIcon;
        },
        internalValue: {
            get() {
                return this.value;
            },
            set(val) {
                this.isActiveDropdown = false;
                this.$emit('input', val);
            }
        },
        formattedDate: {
            get() {
                return this.formatDate(this.internalValue);
            },
            set(val) {
                this.internalValue = val;
            }
        }
    }
};
</script>
