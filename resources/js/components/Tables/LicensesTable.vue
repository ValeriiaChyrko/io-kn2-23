<template>
    <v-card>
        <v-card-title>
            Ліцензії
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
            show-select
            :footer-props="footerOptions"
            :headers="headers"
            :items="items"
            :options.sync="options"
            :server-items-length="pagination.total"
            :loading="loading"
            class="elevation-1"
            must-sort
        />
    </v-card>
</template>

<script>
import DataTableCore from '../mixins/DataTableCore';

export default {
    name: 'LicensesTable',
    mixins: [
        DataTableCore
    ],
    data: () => ({
        crudApiEndpoint: '/api/licenses',
        headers: [
            {
                text: 'id', align: 'start', value: 'id', width: '100px'
                // sortable: false,
            },
            { text: 'Назва', value: 'software_model_title' },
            { text: 'Предмет', value: 'item_inventory_number' },
            { text: 'Накладна', value: 'invoice_number' },
            { text: 'Власник', value: 'owner_name' },
            { text: 'Ціна', value: 'price' }
            //{ text: 'Дії', value: 'actions', sortable: false },
        ]
    })
};
</script>
