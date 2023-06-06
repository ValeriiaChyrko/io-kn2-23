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
            show-select
            :footer-props="footerOptions"
            :headers="headers"
            :items="items"
            :options.sync="options"
            :server-items-length="pagination.total"
            :loading="loading"
            class="elevation-1"
        >
            <template #item.actions="{ item }">
                <role-edit-dialog
                    :role-id="item.id"
                />
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import RoleEditDialog from '~/components/Forms/RoleEditDialog';
import RoleAutocomplete from '~/components/Inputs/RoleAutocomplete';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import DataTableCore from '../mixins/DataTableCore';

export default {
    name: 'UsersTable',
    components: { RoleEditDialog, RoleAutocomplete },
    mixins: [
        DataTableCore
    ],
    data: () => ({
        crudApiEndpoint: '/api/roles',
        headers: [
            { text: 'id', align: 'start', value: 'id', width: '100px' },
            { text: 'Назва', value: 'name' },
            { text: 'Дії', value: 'actions', align: 'center', sortable: false, width: '1%' }
        ]
    }),
    created() {
        EventBus.$on(EventTypes.ROLE_CREATED, () => {
            this.fetch();
        });
    }
};
</script>
