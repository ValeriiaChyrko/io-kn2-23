<template>
    <validation-observer ref="formObserver">
        <v-row>
            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Дата накладної"
                    rules="required"
                >
                    <datepicker-dropdown
                        v-model="invoice.date"
                        @input="input()"
                        :disabled="!editable"
                        :errors="errors"
                        input-label="Дата накладної"
                    />
                </validation-provider>
            </v-col>

            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Номер"
                    rules="required|max:100"
                >
                    <v-text-field
                        v-model="invoice.number"
                        @input="input()"
                        :counter="100"
                        :disabled="!editable"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Номер накладної"
                        required
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Постачальник"
                    rules="required|numeric"
                >
                    <provider-autocomplete
                        v-model="invoice.provider_id"
                        @input="input()"
                        :disabled="!editable"
                        :error-messages="errors"
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Отримувач"
                    rules="numeric"
                >
                    <user-autocomplete
                        v-model="invoice.receiver_id"
                        @input="input()"
                        :disabled="!editable"
                        :error-messages="errors"
                        input-label="Отримувач"
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="2"
            >
                <invoice-file-load-menu
                    @file-changed="updateFileUrl($event)"
                    :invoice-id="invoiceId"
                    :disabled="!editable"
                    :invoice-has-file="isInvoiceHasFile"
                />
            </v-col>
            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Загальна сума"
                    rules="max_value:99999999.99"
                >
                    <v-text-field
                        :error-messages="errors"
                        :value="totalSum"
                        :disabled="!editable"
                        label="Загальна сума"
                        readonly
                    />
                </validation-provider>
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import { debounce } from 'lodash-es';
import ProviderAutocomplete from '~/components/DataTable/ProviderAutocomplete';
import UserAutocomplete from '~/components/DataTable/UserAutocomplete';
import DatepickerDropdown from '~/components/DatepickerDropdown';
import InvoiceFileLoadMenu from '~/components/Forms/Invoice/InvoiceFileLoadMenu';
import FormValidate from '~/components/mixins/FormValidate';

export default {
    name: 'OnlyInvoiceEdit',
    mixins: [
        FormValidate
    ],
    components: {
        UserAutocomplete,
        InvoiceFileLoadMenu,
        DatepickerDropdown,
        ProviderAutocomplete
    },
    props: {
        value: {},

        invoiceId: {
            type: Number,
            required: true
        },
        totalSum: {
            default: 0
        }
    },
    data: () => ({
        file: null    // Create separate component
    }),
    computed: {
        invoice: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },

        editable() {
            return !this.invoice.approved || this.can('edit-approved-invoice');
        },
        isInvoiceHasFile() {
            return !!this.invoice.file_url;
        },
        isFilled() {
            return !!this.invoice.date
                && !!this.invoice.number
                && !!this.invoice.provider_id;
        }
    },
    methods: {
        updateFileUrl(newFileUrl) {
            this.invoice.file_url = newFileUrl;
        },
        input: debounce(function() {
            if(!this.isFilled) {
                return;
            }

            this.$refs.formObserver.validate()
            .then(result => {
                if(result) {
                    this.updateInvoice();
                }
            });
        }, 350),

        updateInvoice() {
            this.invoice.isSaving = true;

            axios.patch(`/api/invoices/${this.invoiceId}`, this.invoice)
            .then(response => {
                let invoice = response.data;
                invoice.isSaving = this.invoice.isSaving;

                this.invoice = invoice;
            }).finally(() => {
                this.invoice.isSaving = false;
            });
        }
    }
};
</script>
