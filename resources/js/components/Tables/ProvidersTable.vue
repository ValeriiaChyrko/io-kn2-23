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
                                rules="required|max:40"
                            >
                                <v-text-field
                                    v-model="props.item.title"
                                    :counter="40"
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

            <template #item.address="props">

                <validation-observer
                    :ref="getValidatorRef('address', props.item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(props.item)"
                        :return-value.sync="props.item.address"
                        :validator="$refs[getValidatorRef('address', props.item.id)]"
                    >
                        {{ props.item.address }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Адреса"
                                rules="required|min:5|max:50"
                            >
                                <v-text-field
                                    v-model="props.item.address"
                                    :counter="50"
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

            <template #item.phone="props">

                <validation-observer
                    :ref="getValidatorRef('phone', props.item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(props.item)"
                        :return-value.sync="props.item.phone"
                        :validator="$refs[getValidatorRef('phone', props.item.id)]"
                    >
                        {{ props.item.phone }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Назва"
                                rules="required|max:20"
                            >
                                <v-text-field
                                    v-model="props.item.phone"
                                    :counter="20"
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
    name: 'ProvidersTable',
    mixins: [
        DataTableCore
    ],
    data: () => ({
        crudApiEndpoint: '/api/providers',
        headers: [
            { text: 'id', align: 'start', value: 'id', width: '100px' },
            { text: 'Назва', value: 'title' },
            { text: 'Адреса', value: 'address' },
            { text: 'Телефон', value: 'phone' },
            { text: 'Дії', value: 'actions', sortable: false, width: '1%', align: 'center' }
        ]
    }),
    created() {
        EventBus.$on(EventTypes.PROVIDER_CREATED, () => {
            this.fetch();
        });
    }
};
</script>
