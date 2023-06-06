<template>
    <span>
        <items-qr-code-sheet-printer
            :items="itemsToPrint"
            ref="sheet"
        />

        <v-dialog
            v-model="isActiveDialog"
            max-width="450px"
            scrollable
        >
            <template #activator="{ on, attrs }">
                <v-btn
                    v-bind="attrs"
                    v-on="on"
                    :disabled="isPrintButtonDisabled"
                >
                    <v-icon>mdi-qrcode</v-icon>
                    Друк кодів для вибраних
                </v-btn>
            </template>

            <v-card>
                <v-card-title>
                    Вибрані накладні
                </v-card-title>
                <v-card-text>
                    <v-list>
                        <v-list-item v-for="(invoice, index) in invoices" :key="invoice.id">
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ invoice.provider_title }} - {{ invoice.number }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    <v-icon small>mdi-calendar</v-icon>
                                    {{ invoice.date }}
                                </v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action>
                                <v-icon
                                    @click="deleteInvoice(index)"
                                    :disabled="isLoading"
                                >
                                    mdi-delete
                                </v-icon>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                </v-card-text>
                <dialog-actions
                    @confirm="print()"
                    @cancel="closeDialog()"
                    confirm-text="Друкувати"
                    :loading="isLoading"
                />
                <v-card-subtitle v-if="isLoading" class="text-right">
                    {{ loadedInvoices }}&nbsp;/&nbsp;{{ totalInvoices }}
                </v-card-subtitle>
            </v-card>
        </v-dialog>
    </span>
</template>

<script>
import DialogActions from '../../DataTable/DialogActions';
import ItemsQrCodeSheetPrinter from '../Item/QR/ItemsQRCodeSheetPrinter';

export default {
    name: 'invoice-items-qr-code-bulk-print-button',
    components: {
        DialogActions,
        ItemsQrCodeSheetPrinter
    },
    props: {
        invoices: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        isActiveDialog: false,
        isLoading: false,

        itemsToPrint: [],
        loadedInvoices: 0
    }),
    computed: {
        isPrintButtonDisabled() {
            return this.invoices.length === 0;
        },
        totalInvoices() {
            return this.invoices.length;
        }
    },
    methods: {
        deleteInvoice(index) {
            this.invoices.splice(index, 1);
            if(this.invoices.length === 0) {
                this.closeDialog();
            }
        },
        closeDialog() {
            this.isActiveDialog = false;
        },

        async print() {
            await this.fetch();

            await this.$refs.sheet.print();
        },
        async fetch() {
            this.isLoading = true;
            this.loadedInvoices = 0;

            for(const invoice of this.invoices) {
                let loadedItems = (await axios.get(`/api/invoices/${ invoice.id }/items`)).data;
                loadedItems = loadedItems.filter(item => item.inventory_number);

                this.itemsToPrint.push(...loadedItems);    //TODO: Stop on error?
                this.loadedInvoices++;
            }

            this.isLoading = false;
        }
    }
};
</script>
