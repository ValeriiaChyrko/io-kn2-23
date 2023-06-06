<template>
    <v-dialog
        v-model="formActive"
        fullscreen
        no-click-animation
        persistent
        transition="dialog-bottom-transition"
    >
        <v-card>
            <v-toolbar
                class="mb-5 rounded-0"
                color="primary"
                dark
                elevation="7"
            >
                <v-btn
                    dark
                    icon
                    @click="closeForm()"
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-toolbar-title>Редагування накладної</v-toolbar-title>
                <v-spacer/>
                <load-status-text
                    :saving="isSavingAny"
                />

                <invoice-approval-dialog
                    v-if="!isLoadingInvoice && can('approve-invoice')"
                    :invoice-id="invoiceId"
                    :approved="invoice.approved"
                />
            </v-toolbar>

            <v-card-text>
                <div v-show="isLoading">
                    <v-skeleton-loader
                        class="mx-auto"
                        type="table-row"
                    />
                    <v-skeleton-loader
                        class="mx-auto"
                        type="table"
                    />
                </div>


                <div v-show="!isLoading">
                    <only-invoice-edit
                        v-model="invoice"
                        :invoice-id="invoiceId"
                        :total-sum="totalSum"
                    />

                    <div v-show="!isInvoiceHasReceiver">
                        <v-alert
                            icon="mdi-account-question-outline"
                            type="warning"
                            text
                        >
                            У накладній відсутній отримувач.
                        </v-alert>
                    </div>

                    <div v-show="isInvoiceHasFile">
                        <items-table
                            v-model="items"
                            :approved="!!invoice.approved"
                            :invoice-id="invoiceId"
                            :parentable="parentable"
                        />
                        <licenses-table
                            v-model="licenses"
                            :approved="!!invoice.approved"
                            :invoice-id="invoiceId"
                            :parentable="parentable"
                        />
                    </div>

                    <div v-show="!isInvoiceHasFile">
                        <v-alert
                            icon="mdi-file-remove-outline"
                            type="warning"
                            text
                        >
                            Для редагування предметів накладної необхідно завантажити копію документа.
                        </v-alert>
                    </div>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import InvoiceApprovalDialog from '~/components/Forms/Invoice/EditFormKebabMenu/InvoiceApprovalDialog';
import ItemsTable from '~/components/Forms/Invoice/ItemsTable/ItemsTable';
import LicensesTable from '~/components/Forms/Invoice/LicensesTable/LicensesTable';
import LoadStatusText from '~/components/Forms/Invoice/LoadStatusText';
import OnlyInvoiceEdit from '~/components/Forms/Invoice/OnlyInvoiceEdit';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'InvoiceEditForm',
    components: {
        InvoiceApprovalDialog,
        ItemsTable,
        LicensesTable,
        LoadStatusText,
        OnlyInvoiceEdit
    },
    data: () => ({
        formActive: false,
        invoiceId: null,

        isLoadingInvoice: false,
        isLoadingItems: false,
        isLoadingLicenses: false,

        invoice: {},
        items: [],
        licenses: [],

        parentable: []
    }),
    computed: {
        isLoading() {
            return this.isLoadingItems || this.isLoadingLicenses || this.isLoadingInvoice;
        },
        isInvoiceHasFile() {
            return !!this.invoice.file_url;
        },
        isInvoiceHasReceiver() {
            return !!this.invoice.receiver_id;
        },
        totalSum() {
            let positionsSum = arr => arr.reduce((sum, elem) => sum + parseFloat(elem.price || 0), 0);

            return parseFloat(positionsSum(this.items) + positionsSum(this.licenses)).toFixed(2);
        },
        /**
         * Check if at least one item or license from arrays are currently saving to database
         *
         * @return boolean
         */
        isSavingAny() {
            let checkArray = arr => arr.some(elem => elem.isSaving === true);

            return checkArray(this.items) || checkArray(this.licenses) || !!this.invoice.isSaving;
        }
    },
    methods: {
        closeForm() {
            //TODO: Wait for save all data?
            this.formActive = false;
            EventBus.$emit(EventTypes.RELOAD_INVOICES_TABLE);
            EventBus.$emit(EventTypes.RELOAD_INVOICE_FULL_DATA, this.invoiceId);
        },
        async loadInvoice() {
            this.isLoadingInvoice = true;

            let { data: invoice } = await axios.get(`/api/invoices/${ this.invoiceId }`);

            invoice.isSaving = false;
            this.invoice = invoice;

            this.isLoadingInvoice = false;
        },
        async loadItems(withLoader = true) {
            if(withLoader) {
                this.isLoadingItems = true;
            }

            let { data: items } = await axios.get(`/api/invoices/${ this.invoiceId }/items`);
            items.forEach(item => {
                item.uid = this.genUID();
                item.isSaving = false;
            });
            this.items = items;

            if(withLoader) {
                this.isLoadingItems = false;
            }
        },
        async loadLicenses(withLoader = true) {
            if(withLoader) {
                this.isLoadingLicenses = true;
            }

            let { data: licenses } = await axios.get(`/api/invoices/${ this.invoiceId }/licenses`);

            licenses.forEach(license => {
                license.uid = this.genUID();
                license.isSaving = false;
            });
            this.licenses = licenses;

            if(withLoader) {
                this.isLoadingLicenses = false;
            }
        },
        getParentableItems() {
            axios.get('/api/items', {
                params: {
                    scopes: ['onlyParentable'],
                    filters: [
                        {
                            field: 'items.invoice_id',
                            operator: 'neq',
                            value: this.invoiceId
                        }
                    ],
                    perPage: -1
                }
            }).then(response => {
                this.parentable = response.data.data;
            });
        }
    },
    created() {
        this.$store.dispatch('types/fetch');
        this.$store.dispatch('users/fetch');
        this.$store.dispatch('departments/fetch');
        this.$store.dispatch('hardwareModels/fetch');
        this.$store.dispatch('softwareModels/fetch');

        EventBus.$on(EventTypes.OPEN_INVOICE_EDIT_FORM, data => {
            this.invoiceId = data.invoiceId;
            this.formActive = true;
            this.loadInvoice();
            this.loadItems();
            this.loadLicenses();
            this.getParentableItems();    // TODO: fix ignoreInvoice param value, one load or partial loading
        });

        EventBus.$on(EventTypes.RELOAD_INVOICE_ITEMS_TABLE, () => this.loadItems(false));
        EventBus.$on(EventTypes.RELOAD_INVOICE_LICENSES_TABLE, () => this.loadLicenses(false));
        EventBus.$on(EventTypes.CLOSE_INVOICE_EDIT_FORM, () => this.closeForm());
    }
};
</script>
