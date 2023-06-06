<template>
    <div>
        <validation-observer
            ref="itemCreateObserver"
        >
            <v-row>
                <v-col
                    cols="12"
                    md="4"
                >
                    <validation-provider
                        v-slot="{ errors }"
                        name="Назва"
                        rules="required|max:40"
                    >
                        <v-text-field
                            v-model="newItem.title"
                            :counter="40"
                            :error-messages="errors"
                            autocomplete="off"
                            label="Назва"
                            required
                        />
                    </validation-provider>
                </v-col>
                <v-col
                    class="d-flex align-items-center"
                    cols="12"
                    md="4"
                >
                    <v-btn
                        class="mr-4"
                        @click="create"
                    >
                        <svg class="icon icon-plus mx-2">
                            <use xlink:href="/img/icons/symbol-defs.svg#icon-plus"></use>
                        </svg>
                        <span class="d-none d-md-inline">Додати статус</span>
                    </v-btn>
                </v-col>
            </v-row>
        </validation-observer>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="py-3">
                        <dt-delete-selected
                            @click.native="deleteSelectedItems"
                            :disabled="isSelectedAny"
                        />
                    </div>
                </div>
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

                        <template #item.actions="{ item }">
                            <delete-button
                                @delete="deleteSingleItem(item.id)"
                                :deletable="item.isSelectable"
                            />
                        </template>
                    </v-data-table>
                </v-card>
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="py-3">
                        <dt-delete-selected
                            @click.native="deleteSelectedItems"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DataTableCore from '../mixins/DataTableCore';

export default {
    name: 'StatusesTable',
    mixins: [
        DataTableCore
    ],
    data() {
        return {
            crudApiEndpoint: '/api/statuses',
            headers: [
                { text: 'id', align: 'start', value: 'id' },
                { text: 'Назва', value: 'title' },
                { text: 'Дії', value: 'actions', sortable: false, width: '1%' }
            ]
        };
    }
};
</script>
