<template>
    <v-card>
        <div
            class="mb-2 pa-2"
        >
            <invoice-items-qr-code-bulk-print-button
                :invoices="selected"
            />
        </div>
        <v-card-title>
            Накладні
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                autocomplete="off"
                label="Пошук"
                single-line
                hide-details
                clearable
            />
        </v-card-title>

        <v-data-table
            v-model="selected"
            :headers="headers"
            :items="items"
            :footer-props="footerOptions"
            :options.sync="options"
            :server-items-length="pagination.total"
            :loading="loading"
            :expanded.sync="expanded"
            class="mb-5"
            must-sort
            show-expand
            show-select
        >
            <template #item.date="{ header, item }">
                {{ formatDate(item.date) }}
            </template>

            <template #item.total_sum="{ header, item }">
                {{ parseFloat(item.total_sum).toFixed(2) }}
            </template>

            <template #item.created_at="{ header, item }">
                {{ formatDatetime(item.created_at) }}
            </template>

            <template #item.actions="{ item }">
                <invoice-file-view-button
                    :invoice-id="item.id"
                />
                <invoice-items-qr-code-sheet-printer
                    :invoice-id="item.id"
                />
                <invoice-edit-form-open-button
                    :approved="item.approved"
                    :invoice-id="item.id"
                />
            </template>

            <template #expanded-item="{ headers, item }">
                <td :colspan="headers.length">
                    <v-container
                        fluid
                    >
                        <invoice-full-data
                            :invoice-id="item.id"
                        />
                    </v-container>
                </td>
            </template>

        </v-data-table>
    </v-card>
</template>

<script>
import InvoiceEditFormOpenButton from '~/components/Forms/Invoice/InvoiceEditFormOpenButton';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import InvoiceFileViewButton from '../Inventory/Invoice/InvoiceFileViewButton';
import InvoiceFullData from '../Inventory/Invoice/InvoiceFullData';
import InvoiceItemsQrCodeBulkPrintButton from '../Inventory/Invoice/InvoiceItemsQRCodeBulkPrintButton';
import InvoiceItemsQrCodeSheetPrinter from '../Inventory/Item/QR/InvoiceItemsQRCodeSheetPrinter';
import DataTableCore from '../mixins/DataTableCore';
import DateFormatting from '../mixins/DateFormatting';

export default {
    name: 'InvoicesTable',
    mixins: [
        DataTableCore,
        DateFormatting
    ],
    components: {
        InvoiceEditFormOpenButton,
        InvoiceItemsQrCodeBulkPrintButton,
        InvoiceItemsQrCodeSheetPrinter,
        InvoiceFileViewButton,
        InvoiceFullData
    },
    data: () => ({
        isDefaultSortDirectionDesc: true,

        expanded: [],
        crudApiEndpoint: '/api/invoices',
        headers: [
            {
                text: 'id', align: 'start', value: 'id', width: '100px'
                // sortable: false,
            },
            { text: 'Номер', value: 'number' },
            { text: 'Постачальник', value: 'provider_title' },
            { text: 'Отримувач', value: 'receiver_name' },
            { text: 'Дата накладної', value: 'date' },
            { text: 'Загальна сума', value: 'total_sum' },
            { text: 'Створено', value: 'created_at' },
            {
                text: 'Дії',
                value: 'actions',
                sortable: false,
                width: '1%',
                cellClass: 'text-no-wrap',
                align: 'center'
            },
            { text: '', value: 'data-table-expand' }
        ]
    }),
    created() {
        EventBus.$on(EventTypes.INVOICE_CREATED, () => {
            this.fetch();
        });
        EventBus.$on(EventTypes.RELOAD_INVOICES_TABLE, () => {
            this.fetch();
        });
    }
};
</script>
