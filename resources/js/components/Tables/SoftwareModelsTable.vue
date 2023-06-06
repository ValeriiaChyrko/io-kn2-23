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
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import DataTableCore from '../mixins/DataTableCore';

export default {
    name: 'SoftwareModelsTable',
    mixins: [
        DataTableCore
    ],
    data: () => ({
        crudApiEndpoint: '/api/software-models',
        headers: [
            { text: 'id', align: 'start', value: 'id', width: '100px' },
            { text: 'Назва', value: 'title' },
            { text: 'Дії', value: 'actions', align: 'center', sortable: false, width: '1%' }
        ]
    }),
    created() {
        EventBus.$on(EventTypes.HARDWARE_MODEL_CREATED, () => {
            this.fetch();
        });
    }
};
</script>
