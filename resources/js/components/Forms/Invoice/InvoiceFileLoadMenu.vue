<template>
    <v-menu
        v-model="isActive"
        :min-width="350"
        :close-on-content-click="false"
    >
        <template #activator="{  }">
            <v-text-field
                @click="open()"
                :disabled="disabled"
                :value="activatorFieldContent"
                prepend-icon="mdi-paperclip"
                label="Файл накладної"
                readonly
            >
                <template #append-outer>
                    <invoice-file-view-button
                        :disabled="!invoiceHasFile"
                        :invoice-id="invoiceId"
                    />
                </template>
            </v-text-field>
        </template>

        <v-card>
            <v-card-title>
                Файл накладної
            </v-card-title>
            <v-card-text class="px-4">
                <validation-observer
                    ref="formObserver"
                    :disabled="!isActive"
                >
                    <validation-provider
                        v-slot="{ errors }"
                        name="Файл накладної"
                        rules="required|ext:pdf,jpg,jpeg,jfif,png"
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
                </validation-observer>
            </v-card-text>

            <dialog-actions
                @cancel="close()"
                @close="close()"
                @confirm="save()"
                confirm-text="Оновити"
                :loading="isLoading"
                :close-only="isCloseOnly"
            />
        </v-card>
    </v-menu>
</template>

<script>
import { isNull } from 'lodash-es';
import InvoiceFileViewButton from '~/components/Inventory/Invoice/InvoiceFileViewButton';
import Snackbar from '~/components/modules/Snackbar';
import byteToSize from '~/shared/byte-to-size';
import DialogActions from '../../DataTable/DialogActions';
import DatepickerDropdown from '../../DatepickerDropdown';
import FormValidate from '../../mixins/FormValidate';

export default {
    name: 'InvoiceFileLoadMenu',
    components: {
        InvoiceFileViewButton,
        DialogActions,
        DatepickerDropdown
    },
    mixins: [
        FormValidate
    ],
    props: {
        invoiceId: {
            type: Number,
            required: true
        },
        invoiceHasFile: {
            type: Boolean,
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
        isActive: false,
        isLoading: false,

        activatorFieldContent: '',
        file: null
    }),
    computed: {
        isCloseOnly() {
            return isNull(this.file);
        }
    },
    watch: {
        invoiceId() {
            this.activatorFieldContent = '';
            this.loadExistingFileData();
        }
    },
    methods: {
        open() {
            this.isActive = true;
            this.file = null;

            this.$nextTick(() => {
                this.resetForm();

                if(!this.invoiceHasFile) {    // Automatically focus on file input if invoice haven't file
                    this.$refs.fileInput.$el.querySelector('input').click();
                }
            });
        },
        close() {
            this.isActive = false;
        },
        async save() {
            if(!await this.$refs.formObserver.validate()) {
                return;
            }
            this.isLoading = true;

            let formData = new FormData();
            formData.append('file', this.file);
            let response = await axios.post(`/api/invoices/${this.invoiceId}/file`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            await this.loadExistingFileData();
            this.$emit('file-changed', response.data.file_url);
            this.close();
            Snackbar.success('Файл оновлено');


            this.isLoading = false;
        },
        resetForm() {
            this.file = null;
            this.$refs.formObserver.reset();
        },
        async loadExistingFileData() {
            let response = await axios.head(`/api/invoices/${ this.invoiceId }/file`);

            if(response.status === 200) {
                let size = byteToSize(response.headers['content-length']);
                let extension = '.' + (response.headers['content-type']).split('/')[1];

                this.activatorFieldContent = size + ' ' + extension;
            }
        }
    },
    created() {
        this.loadExistingFileData();
    }
};
</script>
