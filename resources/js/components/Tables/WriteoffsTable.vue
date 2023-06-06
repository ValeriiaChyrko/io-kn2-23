<template>
    <v-card>
        <v-card-title>
            Списання
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

            <template #item.created_at="{ header, item }">
                {{ formatDatetime(item.created_at) }}
            </template>

            <template #item.actions="{ item }">
                <writeoff-file-view-button
                    :writeoff-id="item.id"
                />
                <writeoff-edit-form-edit-button
                    :confirmed="item.confirmed"
                    :writeoff-id="item.id"
                />
            </template>

            <template #expanded-item="{ headers, item }">
                <td :colspan="headers.length">
                    <v-container
                        fluid
                    >
                        <writeoff-full-data
                            :writeoff-id="item.id"
                        />
                    </v-container>
                </td>
            </template>

        </v-data-table>
    </v-card>
</template>

<script>
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import InvoiceFullData from '../Inventory/Invoice/InvoiceFullData';
import DataTableCore from '../mixins/DataTableCore';
import DateFormatting from '../mixins/DateFormatting';
import WriteoffFileViewButton from "~/components/Forms/Writeoff/WriteoffFileViewButton.vue";
import WriteoffEditFormEditButton from "~/components/Forms/Writeoff/WriteoffEditFormOpenButton.vue";
import WriteoffFullData from "~/components/Inventory/Writeoff/WriteoffFullData.vue";

export default {
    name: 'InvoicesTable',
    mixins: [
        DataTableCore,
        DateFormatting
    ],
    components: {
        WriteoffFullData,
        WriteoffEditFormEditButton,
        WriteoffFileViewButton
    },
    data: () => ({
        isDefaultSortDirectionDesc: true,

        expanded: [],
        crudApiEndpoint: '/api/writeoffs',
        headers: [
            {
                text: 'id', align: 'start', value: 'id', width: '100px'
                // sortable: false,
            },
            { text: 'Номер', value: 'number' },
            { text: 'Дата', value: 'date' },
            { text: 'Відповідальна особа', value: 'user_name' },
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
    methods: {
        async fetch() {
            this.loading = true;

            await new Promise(resolve => setTimeout(resolve, 1000));

            console.warn('fetch');
            this.loading = false;
            this.items = [
                {
                    id: 1,
                    number: 77471,
                    date: '2021-12-14T00:00:00.000000Z',
                    user_id: 1,
                    user_name: 'Анатолій Павлович Мініч',
                    confirmed: true,
                    created_at: '2021-11-14T00:00:00.000000Z'
                },
                {
                    id: 2,
                    number: 82862,
                    date: '2021-12-20T00:00:00.000000Z',
                    user_id: 2,
                    user_name: 'Галина Сергіївна Пастушок',
                    confirmed: false,
                    created_at: '2021-11-20T00:00:00.000000Z'
                },
                {
                    id: 3,
                    number: 57573,
                    date: '2021-12-14T00:00:00.000000Z',
                    user_id: 3,
                    user_name: 'Олександр Іванович Іванів',
                    confirmed: true,
                    created_at: '2021-11-14T00:00:00.000000Z'
                },
                {
                    id: 4,
                    number: 31854,
                    date: '2021-12-20T00:00:00.000000Z',
                    user_id: 4,
                    user_name: 'Олександр Васильович Корнійчук',
                    confirmed: true,
                    created_at: '2021-11-20T00:00:00.000000Z'
                },
                {
                    id: 5,
                    number: 97055,
                    date: '2021-12-14T00:00:00.000000Z',
                    user_id: 5,
                    user_name: 'Христина Миколаївна Карповець',
                    confirmed: false,
                    created_at: '2021-11-14T00:00:00.000000Z'
                },
                {
                    id: 6,
                    number: 73496,
                    date: '2021-12-20T00:00:00.000000Z',
                    user_id: 6,
                    user_name: 'Любов Іванівна Дідик',
                    confirmed: false,
                    created_at: '2021-11-20T00:00:00.000000Z'
                }
            ];
        },
        update() {
            console.warn('update');
        },
        massDelete(itemsIdArray) {
            console.warn('massDelete', itemsIdArray);
        }
    },
    created() {
        EventBus.$on(EventTypes.WRITEOFF_CREATED, () => {
            this.fetch();
        });
        EventBus.$on(EventTypes.RELOAD_WRITEOFFS_TABLE, () => {
            this.fetch();
        });
    }
};
</script>
