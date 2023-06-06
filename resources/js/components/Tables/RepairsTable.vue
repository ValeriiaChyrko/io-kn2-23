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
            :footer-props="footerOptions"
            :headers="headers"
            :items="items"
            :options.sync="options"
            :server-items-length="pagination.total"
            :loading="loading"
            class="elevation-1"
            must-sort
        >
            <template #item.item_inventory_number="{ item }">
                <template v-if="item.item_inventory_number">{{ item.item_inventory_number }}</template>
                <tooltipped-text tooltip-text="Інв. номер у предмета відсутній" v-else>
                    <span class="font-weight-bold">id:&nbsp;</span>{{ item.id }}
                </tooltipped-text>

            </template>

            <template #item.user_name="{ item }">
                <validation-observer
                    :ref="getValidatorRef('user_id', item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(item)"
                        :return-value.sync="item.user_id"
                        :validator="$refs[getValidatorRef('user_id', item.id)]"
                    >
                        {{ item.user_name }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Користувач"
                                rules="required"
                            >
                                <v-autocomplete
                                    v-model="item.user_id"
                                    :items="$store.state.users.users"
                                    :error-messages="errors"
                                    item-text="name"
                                    item-value="id"
                                    label="Користувач"
                                />
                            </validation-provider>
                        </template>
                    </edit-dialog>
                </validation-observer>
            </template>

            <template #item.provider_title="{ item }">

                <validation-observer
                    :ref="getValidatorRef('provider_id', item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(item)"
                        :return-value.sync="item.provider_id"
                        :validator="$refs[getValidatorRef('provider_id', item.id)]"
                    >
                        {{ item.provider_title }}
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Виконавець"
                                rules="required"
                            >
                                <v-autocomplete
                                    v-model="item.provider_id"
                                    :items="$store.state.providers.providers"
                                    :error-messages="errors"
                                    item-text="title"
                                    item-value="id"
                                    label="Виконавець"
                                />
                            </validation-provider>
                        </template>
                    </edit-dialog>
                </validation-observer>
            </template>

            <template #item.comment="{ item }">

                <validation-observer
                    :ref="getValidatorRef('comment', item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(item)"
                        :return-value.sync="item.comment"
                        :validator="$refs[getValidatorRef('comment', item.id)]"
                    >
                        <template #default>
                            <repair-comment
                                :comment="item.comment"
                            />
                        </template>
                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Коментар"
                                rules="max:255"
                            >
                                <v-textarea
                                    v-model="item.comment"
                                    :counter="255"
                                    :error-messages="errors"
                                    :rows="3"
                                    label="Коментар"
                                />
                            </validation-provider>
                        </template>
                    </edit-dialog>
                </validation-observer>
            </template>

            <template #item.start_date="{ item }">

                <validation-observer
                    :ref="getValidatorRef('start_date', item.id)"
                >
                    <edit-dialog
                        @changeless-save="changeless()"
                        @save="update(item)"
                        :return-value.sync="item.start_date"
                        :validator="$refs[getValidatorRef('start_date', item.id)]"
                    >
                        <template #default>
                            {{ formatDate(item.start_date) }}
                        </template>

                        <template #input>
                            <validation-provider
                                v-slot="{ errors }"
                                name="Дата початку"
                                :rules="{
                                    required: true,
                                    repair_start_date_before_or_equal_to_end_date: {
                                        end_date: item.end_date
                                    }
                                }"
                            >
                                <datepicker-dropdown
                                    v-model="item.start_date"
                                    :errors="errors"
                                    input-label="Дата початку"
                                />
                            </validation-provider>
                        </template>
                    </edit-dialog>
                </validation-observer>
            </template>

            <template #item.end_date="{ item }">
                <completed-repair-edit-menu
                    @updated="fetch()"
                    :repair-id="item.id"
                >
                    <repair-end-date
                        :end-date="formatDate(item.end_date)"
                        :is-unrepairable="item.is_unrepairable"
                    />
                </completed-repair-edit-menu>
            </template>

            <template #item.actions="{ item }">
                <repair-complete-menu
                    @completed="fetch()"
                    :repair-id="item.id"
                    :is-uncompleted="!item.is_completed"
                />

                <delete-button
                    @delete="deleteById(item.id)"
                    :deletable="item.is_deletable"
                />
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import TooltippedText from '~/components/Inventory/Invoice/TooltippedText';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import Snackbar from '~/components/modules/Snackbar';
import DatepickerDropdown from '../DatepickerDropdown';
import CompletedRepairEditMenu from '../Inventory/Repair/CompletedRepairEditMenu';
import RepairComment from '../Inventory/Repair/RepairComment';
import RepairCompleteMenu from '../Inventory/Repair/RepairCompleteMenu';
import RepairEndDate from '../Inventory/Repair/RepairEndDate';
import DataTableCore from '../mixins/DataTableCore';
import DateFormatting from '../mixins/DateFormatting';

export default {
    name: 'RepairsTable',
    mixins: [
        DataTableCore,
        DateFormatting
    ],
    components: {
        TooltippedText,
        CompletedRepairEditMenu,
        RepairComment,
        RepairCompleteMenu,
        RepairEndDate,
        DatepickerDropdown
    },
    data: () => ({
        isDefaultSortDirectionDesc: true,
        isSelectableByDefault: false,

        crudApiEndpoint: '/api/repairs',
        headers: [
            { text: 'id', align: 'start', value: 'id', width: '100px' },
            { text: 'Інвентарний номер', value: 'item_inventory_number' },
            { text: 'Відповідальна особа', value: 'user_name' },
            { text: 'Виконавець', value: 'provider_title' },
            { text: 'Коментар', value: 'comment' },
            { text: 'Дата початку', value: 'start_date' },
            { text: 'Дата кінця', value: 'end_date' },
            {
                text: 'Дії', value: 'actions', sortable: false, width: '1%',
                cellClass: 'text-no-wrap', align: 'center'
            }
        ]
    }),
    methods: {
        deleteById(id) {    //TODO: Review resources delete process in all datatables
            axios.delete(`/api/repairs/${ id }`)
            .then(response => {
                console.log(response);
                this.fetch();
                Snackbar.success('Успішно видалено');
            });
        }
    },
    created() {
        EventBus.$on(EventTypes.REPAIR_CREATED, () => {
            this.fetch();
        });

        this.$store.dispatch('users/fetch');
        this.$store.dispatch('providers/fetch');
    }
};
</script>
