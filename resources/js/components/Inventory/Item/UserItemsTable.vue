<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <v-card>
                <v-card-title>
                    Технічне обладнання
                    <v-spacer/>
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
                >
                    <template #item.actions="{ item }">
                        <item-parts-view-dialog
                            :item-id="item.id"
                            :standalone-mode-parts-count="item.parts_count + item.licenses_count"
                            standalone-loading
                        />
                    </template>
                </v-data-table>
            </v-card>
        </div>
    </div>
</template>

<script>
import DataTableCore from '../../mixins/DataTableCore';
import ItemPartsViewDialog from './ItemPartsViewDialog';

export default {
    name: 'UserItemsTable',
    mixins: [DataTableCore],
    components: {
        ItemPartsViewDialog
    },
    data() {
        return {
            crudApiEndpoint: '/api/items/user',
            headers: [
                {
                    text: 'id', align: 'start', value: 'id'
                    // sortable: false,
                },
                { text: 'Номер', value: 'inventory_number' },
                { text: 'Тип', value: 'type_title' },
                { text: 'Модель', value: 'hardware_model_title' },
                { text: 'Накладна', value: 'invoice_number' },
                //{ text: 'Власник', value: 'owner_name' },
                { text: 'Приміщення', value: 'department_title' },
                { text: 'Дії', value: 'actions', sortable: false, width: '1%' }
            ]
        };
    }
};
</script>
