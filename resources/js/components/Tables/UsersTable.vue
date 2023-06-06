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
            <template #item.name="props">

                <validation-observer
                    :ref="getValidatorRef('name', props.item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless"
                        @save="update(props.item)"
                        :return-value.sync="props.item.name"
                        :validator="$refs[getValidatorRef('name', props.item.id)]"
                    >
                        {{ props.item.name }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Ім'я"
                                rules="required|min:5|max:100"
                            >
                                <v-text-field
                                    v-model="props.item.name"
                                    :counter="100"
                                    :error-messages="errors"
                                    autocomplete="off"
                                    label="Ім'я"
                                    single-line
                                    required
                                />
                            </validation-provider>
                        </template>
                    </edit-dialog>
                </validation-observer>
            </template>

            <template #item.email="props">
                <validation-observer
                    :ref="getValidatorRef('email', props.item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless"
                        @save="update(props.item)"
                        :return-value.sync="props.item.email"
                        :validator="$refs[getValidatorRef('email', props.item.id)]"
                    >
                        {{ props.item.email }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="E-mail"
                                rules="required|email"
                            >
                                <v-text-field
                                    v-model="props.item.email"
                                    :counter="100"
                                    :error-messages="errors"
                                    autocomplete="off"
                                    label="E-mail"
                                    single-line
                                    required
                                />
                            </validation-provider>
                        </template>
                    </edit-dialog>
                </validation-observer>
            </template>

            <template #item.role_name="props">
                <validation-observer
                    :ref="getValidatorRef('role', props.item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(props.item)"
                        :return-value.sync="props.item.role_id"
                        :validator="$refs[getValidatorRef('role', props.item.id)]"
                    >
                        {{ props.item.role_name }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Роль"
                                rules="required"
                            >
                                <role-autocomplete
                                    v-model="props.item.role_id"
                                    :error-messages="errors"
                                />
                            </validation-provider>
                        </template>
                    </edit-dialog>
                </validation-observer>
            </template>

            <template #item.actions="{ item }">
                <delete-button
                    @delete="deleteSingleItem(item.id)"
                    :deletable="item.is_deletable"
                />
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import RoleAutocomplete from '~/components/Inputs/RoleAutocomplete';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import DataTableCore from '../mixins/DataTableCore';

export default {
    name: 'UsersTable',
    components: { RoleAutocomplete },
    mixins: [
        DataTableCore
    ],
    data: () => ({
        crudApiEndpoint: '/api/users',
        headers: [
            { text: 'id', align: 'start', value: 'id', width: '100px' },
            { text: 'Ім\'я', value: 'name' },
            { text: 'Email', value: 'email' },
            { text: 'Роль', value: 'role_name' },
            { text: 'Дії', value: 'actions', align: 'center', sortable: false, width: '1%' }
        ]
    }),
    created() {
        EventBus.$on(EventTypes.USER_CREATED, () => {    //TODO: Create method for handling multiple events
            this.fetch();
        });
        EventBus.$on(EventTypes.GOOGLE_WORKSPACE_USERS_LOADED, () => {
            this.fetch();
        });
    }
};
</script>
