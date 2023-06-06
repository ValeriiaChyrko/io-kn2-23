<template>
    <v-card>
        <v-card-title>
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
            :footer-props="footerOptions"
            :headers="headers"
            :items="items"
            :options.sync="options"
            :server-items-length="pagination.total"
            :loading="loading"
            :expanded.sync="expanded"
            class="elevation-1"
            must-sort
            show-select
            show-expand
        >
            <template #item.inventory_number="{ item:transfer }">
                {{transfer.items.length}}
            </template>
            <template #item.confirmed="{ item }">
                <v-icon
                    color="green"
                    v-if="item.confirmed === true"
                >
                    mdi-check-bold
                </v-icon>
                <v-icon
                    color="red"
                    v-else-if="item.confirmed === false"
                >
                    mdi-close-thick
                </v-icon>
                <span v-else>
                    <v-btn
                        @click="confirmTransfer(item.id, true)"
                    >
                        <v-icon
                            color="green"
                        >
                            mdi-check
                        </v-icon>
                        Підтвердити
                    </v-btn>
                    <v-btn
                        @click="confirmTransfer(item.id, false)"
                    >
                        <v-icon
                            color="red"
                        >
                            mdi-close
                        </v-icon>
                        Відхилити
                    </v-btn>
                </span>
            </template>
            <template #item.actions="{ item }">
                <transfer-file-view-button
                    :transfer-id="item.id"
                />
                <delete-button
                    @delete="deleteTransfer(item.id)"
                    :deletable="item.is_deletable"
                />
            </template>

            <template #expanded-item="{ headers, item }">
                <td :colspan="headers.length">
                    <v-container
                        fluid
                    >
                        <transfer-full-data
                            :transfer-id="item.id"
                        />
                    </v-container>
                </td>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import TransferFileViewButton from '~/components/Inventory/Transfer/TransferFileViewButton';
import TransferFullData from '~/components/Inventory/Transfer/TransferFullData';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import Snackbar from '~/components/modules/Snackbar';
import DataTableCore from '../mixins/DataTableCore';

export default {
    name: 'TransfersTable',
    components: {TransferFullData, TransferFileViewButton},
    mixins: [
        DataTableCore
    ],
    data: () => ({
        isDefaultSortDirectionDesc: true,
        expanded: [],
        crudApiEndpoint: '/api/transfers',
        headers: [
            {
                text: 'id', align: 'start', value: 'id', width: '100px'
                // sortable: false,
            },
            { text: 'Дата', value: 'transfer_date' },
            { text: 'Номер', value: 'transfer_number' },
            { text: 'Предметів', value: 'inventory_number' },
            { text: 'Від кого', value: 'from_user_name' },
            { text: 'Кому', value: 'to_user_name' },
            { text: 'Статус', value: 'confirmed' },
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
    methods: {
        // Редагування полей
        confirmTransfer(id, result) {
            axios.patch(`${ this.crudApiEndpoint }/${ id }/confirm`, { confirmed: result })
                .then(response => {
                    if(response.data.confirmed === true) {
                        Snackbar.success('Підтверджено');
                    }
                    else
                    {
                        Snackbar.warn('Відхилено');
                    }
                }).finally(() => {
                this.fetch();
            });
        },
        // Видалення полей
        deleteTransfer(id) {
            axios.delete(`${ this.crudApiEndpoint }/${ id }`).then(() => {
                this.fetch();
                Snackbar.success('Успішно видалено');

                EventBus.$emit('dt-item-deleted');    //TODO: Rename
            });
        }
    },
    created() {
        EventBus.$on(EventTypes.TRANSFER_CREATED, () => {
            this.fetch();
        });
    }
};
</script>
