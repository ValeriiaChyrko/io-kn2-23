<template>
        <v-card color="white">
            <v-card-title>
                Технічне обладнання
                <v-spacer/>
                <div class="mr-4">
                    <table-headers-select-menu
                        v-model="headers"
                    />
                    <filter-menu
                        v-model="filters"
                        :configs="filterConfig"
                    />
                </div>


                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    autocomplete="off"
                    label="Пошук"
                    single-line
                    clearable
                />
            </v-card-title>

            <v-data-table
                v-model="selected"
                :expanded.sync="expanded"
                :footer-props="footerOptions"
                :headers="activeHeaders"
                :items="items"
                :loading="loading"
                :options.sync="options"
                :server-items-length="pagination.total"
                class="elevation-1"
                show-expand
                show-select
                must-sort
            >
                <template #item.actions="{ item }">
                    <item-repair-create-menu
                        @created="itemSentForRepair(item.id)"
                        :item-id="item.id"
                        :repairable="item.is_repairable"
                    />
                </template>

                <template #item.data-table-expand="{ item, isExpanded, expand }">
                    <v-badge
                        @click.native="expand(!isExpanded)"
                        class="cursor-pointer"
                        :content="item.parts_count + item.licenses_count"
                        :value="item.parts_count + item.licenses_count"
                        color="green"
                        overlap
                    >
                        <v-btn icon>
                            <v-icon
                                class="v-data-table__expand-icon"
                                :class="{ 'v-data-table__expand-icon--active': isExpanded }"
                            >
                                mdi-chevron-down
                            </v-icon>
                        </v-btn>
                    </v-badge>
                </template>

                <template #expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                        <item-full-data
                            :item-id="item.id"
                        />
                    </td>
                </template>
            </v-data-table>
        </v-card>
</template>

<script>
import FilterMenu from '~/components/DataTable/Filter/FilterMenu';
import TableHeadersSelectMenu from '~/components/DataTable/Filter/TableHeadersSelectMenu';
import ItemFullData from '../Inventory/Item/ItemFullData';
import ItemRepairCreateMenu from '../Inventory/Item/ItemRepairCreateMenu';
import DataTableCore from '../mixins/DataTableCore';
import { EventBus } from '../modules/EventBus';

export default {
    name: 'ItemsTable',
    mixins: [
        DataTableCore
    ],
    components: {
        TableHeadersSelectMenu,
        FilterMenu,
        ItemFullData,
        ItemRepairCreateMenu
    },
    data: () => ({
        expanded: [],
        crudApiEndpoint: '/api/items',

        filterConfig: [
            {
                title: 'Тип',
                field: 'items.type_id',
                operators: ['in', 'nin'],
                type: 'types'
            },
            {
                title: 'Модель',
                field: 'items.hardware_model_id',
                operators: ['in', 'nin'],
                type: 'hardwareModels'
            },
            // { TODO
            //     title: 'Накладна',
            //     field: 'items.invoice_id',
            //     operators: ['in', 'nin']
            // },
            {
                title: 'Власник',
                field: 'items.owner_id',
                operators: ['in', 'nin'],
                type: 'users'
            },
            {
                title: 'Приміщення',
                field: 'items.department_id',
                operators: ['in', 'nin'],
                type: 'departments'
            },
            {
                title: 'Ціна',
                field: 'items.price',
                operators: ['gt', 'gte', 'lt', 'lte', 'eq', 'neq'],
                type: 'text'
            }
        ],
        headers: [
            { text: 'id', align: 'start', value: 'id', width: '100px' },
            { text: 'Номер', value: 'inventory_number' },
            { text: 'Тип', value: 'type_title' },
            { text: 'Модель', value: 'hardware_model_title' },
            { text: 'Накладна', value: 'invoice_number' },
            { text: 'Дата накладної', value: 'invoice_date', disabled: true },
            { text: 'Власник', value: 'owner_name' },
            { text: 'Приміщення', value: 'department_title' },
            { text: 'Статус', value: 'status_title' },
            { text: 'Ціна', value: 'price', disabled: true },
            { text: 'Дії', value: 'actions', sortable: false, align: 'center', width: '1%', cellClass: 'text-no-wrap', disableable: false },
            { text: '', value: 'data-table-expand', disableable: false }
        ]
    }),
    methods: {
        //This method reload current table and send event via Event bus to reload nested item repairs table
        itemSentForRepair(itemId) {
            this.fetch();

            EventBus.$emit('reload-item-repairs', itemId);    //TODO: Review events
        }
    },
    created() {
        EventBus.$on('items-table-fetch', () => {
            this.fetch();
        });
    }
};
</script>
