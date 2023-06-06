<template>
    <validation-observer
        ref="formObserver"
    >
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
                        :errors="errors"
                        :disabled="isLoading"
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
                        :counter="100"
                        :disabled="isLoading"
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
                        :disabled="isLoading"
                        :error-messages="errors"
                    />
                </validation-provider>
            </v-col>            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Отримувач"
                    rules="required|numeric"
                >
                    <user-autocomplete
                        v-model="invoice.receiver_id"
                        :disabled="isLoading"
                        :error-messages="errors"
                        input-label="Отримувач"
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Файл накладної"
                    rules="required|ext:pdf,jpg,jpeg,png"
                >
                    <v-file-input
                        v-model="file"
                        :error-messages="errors"
                        label="Файл накладної"
                        ref="fileInput"
                        truncate-length="23"
                        show-size
                    />
                </validation-provider>
            </v-col>
            <v-col
                class="d-flex align-center"
                cols="12"
                md="2"
            >
                <create-button
                    @click="create()"
                    :loading="isLoading"
                    text="Створити накладну"
                />
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import ProviderAutocomplete from '~/components/DataTable/ProviderAutocomplete';
import UserAutocomplete from '~/components/DataTable/UserAutocomplete';
import DatepickerDropdown from '~/components/DatepickerDropdown';
import CreateButton from '~/components/Forms/CreateButton';
import FormValidate from '~/components/mixins/FormValidate';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'InvoiceCreateForm',
    mixins: [
        FormValidate
    ],
    components: {
        UserAutocomplete,
        CreateButton,
        DatepickerDropdown,
        ProviderAutocomplete
    },
    data: () => ({
        isLoading: false,

        file: null,
        invoice: {}
    }),
    methods: {
        async create() {
            if(!await this.$refs.formObserver.validate()) {
                return;
            }
            this.isLoading = true;
            let invoice = (await axios.post('/api/invoices', this.createData(), {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })).data;

            EventBus.$emit(EventTypes.INVOICE_CREATED);
            EventBus.$emit(EventTypes.OPEN_INVOICE_EDIT_FORM, {
                invoiceId: invoice.id
            });

            this.resetForm();
            this.isLoading = false;
        },
        createData() {
            let formData = new FormData();
            formData.append('date', this.invoice.date);
            formData.append('number', this.invoice.number);
            formData.append('provider_id', this.invoice.provider_id);
            formData.append('receiver_id', this.invoice.receiver_id);
            formData.append('file', this.file);

            return formData;
        },
        resetForm() {
            this.invoice = {};
            this.file = null;
            this.$refs.formObserver.reset();
        }
    }
};
</script>
