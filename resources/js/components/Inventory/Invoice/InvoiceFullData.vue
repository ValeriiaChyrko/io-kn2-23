<template>
    <div>
        <div v-if="isLoading" class="text-center">
            <v-progress-circular
                :size="50"
                color="primary"
                indeterminate
            />
        </div>
        <template v-else>
            <template v-if="showItemsTable">
                <h5>Обладнання</h5>
                <v-data-table
                    :headers="itemsHeaders"
                    :items="items"
                    :items-per-page="10"
                    class="elevation-2 mb-3"
                >
                    <template #item.actions="{ item }">
                        <item-parts-view-dialog
                            :parts-count="item.parts_count + item.licenses_count"
                            :item-id="item.id"
                            :preloaded-item="item"
                        />
                        <parent-item-view-menu
                            :item-id="item.part_of"
                        />
                    </template>
                </v-data-table>
            </template>

            <template v-if="showLicensesTable">
                <h5>Ліцензії</h5>
                <v-data-table
                    :headers="licensesHeaders"
                    :items="licenses"
                    :items-per-page="10"
                    class="elevation-2 mb-3"
                >
                    <template #item.actions="{ item }">
                        <parent-item-view-menu
                            :item-id="item.item_id"
                        />
                    </template>
                </v-data-table>
            </template>
        </template>
    </div>
</template>

<script>
import { EventBus, EventTypes } from '../../modules/EventBus';
import ItemPartsViewDialog from '../Item/ItemPartsViewDialog';
import ItemsQrCodeSheetPrinter from '../Item/QR/ItemsQRCodeSheetPrinter';
import ParentItemViewMenu from './ParentItemViewMenu';

export default {
    name: 'InvoiceFullData',
    components: {
        ItemsQrCodeSheetPrinter,
        ItemPartsViewDialog,
        ParentItemViewMenu
    },
    props: {
        invoiceId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            invoice: {},
            items: [],
            licenses: [],

            isLoadingInvoice: false,
            isLoadingItems: false,
            isLoadingLicenses: false,

            itemsHeaders: [
                { text: 'id', align: 'start', value: 'id' },
                { text: 'Інвентарний номер', value: 'inventory_number' },
                { text: 'Тип', value: 'type_title' },
                { text: 'Модель', value: 'hardware_model_title' },
                { text: 'Власник', value: 'owner_name' },
                { text: 'Приміщення', value: 'department_title' },
                { text: 'Ціна', value: 'price' },
                { text: '', value: 'actions', sortable: false, width: '1%', cellClass: 'text-no-wrap' }
            ],
            licensesHeaders: [
                { text: 'id', align: 'start', value: 'id' },
                { text: 'Назва', value: 'software_model_title' },
                { text: 'Предмет', value: 'item_inventory_number' },
                { text: 'Власник', value: 'owner_name' },
                { text: 'Ціна', value: 'price' },
                { text: '', value: 'actions', sortable: false, width: '1%', cellClass: 'text-no-wrap' }
            ]
        };
    },
    computed: {
        isLoading() {
            return this.isLoadingInvoice || this.isLoadingItems || this.isLoadingLicenses;
        },
        showItemsTable() {
            return this.items.length > 0;
        },
        showLicensesTable() {
            return this.licenses.length > 0;
        }
    },
    methods: {
        fetch() {
            this.loadInvoice();
            this.loadItems();
            this.loadLicenses();
        },
        async loadInvoice() {
            this.isLoadingInvoice = true;
            this.invoice = (await axios.get(`/api/invoices/${ this.invoiceId }`)).data;
            this.isLoadingInvoice = false;
        },
        async loadItems() {
            this.isLoadingItems = true;
            this.items = (await axios.get(`/api/invoices/${ this.invoiceId }/items`)).data;
            this.isLoadingItems = false;
        },
        async loadLicenses() {
            this.isLoadingLicenses = true;
            this.licenses = (await axios.get(`/api/invoices/${ this.invoiceId }/licenses`)).data;
            this.isLoadingLicenses = false;
        }
    },
    created() {
        this.fetch();

        EventBus.$on(EventTypes.RELOAD_INVOICE_FULL_DATA, invoiceId => {
            if(this.invoiceId === invoiceId) {
                this.fetch();
            }
        });
    }
};
</script>
