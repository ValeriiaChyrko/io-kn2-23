<template>
    <v-card>
        <v-card-title>
            Приміщення
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                autocomplete="off"
                append-icon="mdi-magnify"
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
            <template #item.title="props">

                <validation-observer
                    :ref="getValidatorRef('title', props.item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(props.item)"
                        :return-value.sync="props.item.title"
                        :validator="$refs[getValidatorRef('title', props.item.id)]"
                    >
                        {{ props.item.title }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Назва"
                                rules="required|max:200"
                            >
                                <v-text-field
                                    v-model="props.item.title"
                                    :counter="200"
                                    :error-messages="errors"
                                    autocomplete="off"
                                    label="Назва"
                                    single-line
                                    required
                                />
                            </validation-provider>
                        </template>
                    </edit-dialog>
                </validation-observer>
            </template>

            <template #item.parent_title="props">
                <validation-observer
                    :ref="getValidatorRef('parent_title', props.item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(props.item)"
                        :return-value.sync="props.item.parent_id"
                        :validator="$refs[getValidatorRef('parent_title', props.item.id)]"
                    >
                        {{ props.item.parent_title }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Назва"
                                rules="required|max:200"
                            >
                                <v-autocomplete
                                    v-model="props.item.parent_id"
                                    :items="$store.state.departments.departments"
                                    :error-messages="errors"
                                    label="Виберіть батьківський департамент"
                                    item-text="title"
                                    item-value="id"
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
                    forbidden-text="Має дочірні компоненти"
                />
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import DataTableCore from '~/components/mixins/DataTableCore';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'DepartmentsTable',
    mixins: [
        DataTableCore
    ],
    data: () => ({
        crudApiEndpoint: '/api/departments',

        headers: [
            { text: 'id', align: 'start', value: 'id', width: '100px' },
            { text: 'Назва', value: 'title' },
            { text: 'Корпус', value: 'parent_title' },
            { text: 'Дії', value: 'actions', sortable: false, align: 'center', width: '1%' }
        ]
    }),
    created() {
        this.$store.dispatch('departments/fetch');

        EventBus.$on(EventTypes.DEPARTMENT_CREATED, () => {
            this.fetch();
        });
    }
};
</script>
