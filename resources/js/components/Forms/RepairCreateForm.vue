<template>
    <validation-observer
        ref="createFormObserver"
    >
        <v-row>
            <v-col
                cols="12"
                lg="2"
                md="4"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Предмет"
                    rules="required|numeric"
                >
                    <item-autocomplete-with-info
                        v-model="newItem.item_id"
                        :error-messages="errors"
                        :items="repairableItems"
                        disable-unrepairable
                        label="Предмет"
                    />
                </validation-provider>
            </v-col>

            <v-col
                cols="12"
                lg="2"
                md="4"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Відповідальна особа"
                    rules="required|numeric"
                >
                    <user-autocomplete
                        v-model="newItem.user_id"
                        :error-messages="errors"
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                lg="2"
                md="4"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Виконавець"
                    rules="required|numeric"
                >
                    <provider-autocomplete
                        v-model="newItem.provider_id"
                        :error-messages="errors"
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                lg="2"
                md="4"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Дата початку"
                    rules="required"
                >
                    <datepicker-dropdown
                        v-model="newItem.start_date"
                        input-label="Дата початку"
                    />
                </validation-provider>
            </v-col>
            <v-col
                class="d-flex align-center"
                cols="12"
                lg="2"
                md="4"
            >
                <create-button
                    @click="create()"
                    text="Додати ремонт"
                />
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import ItemAutocompleteWithInfo from '~/components/DataTable/ItemAutocompleteWithInfo';
import ProviderAutocomplete from '~/components/DataTable/ProviderAutocomplete';
import UserAutocomplete from '~/components/DataTable/UserAutocomplete';
import DatepickerDropdown from '~/components/DatepickerDropdown';
import ResourceCreateForm from '~/components/mixins/ResourceCreateForm';
import { EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'RepairCreateForm',
    components: {
        DatepickerDropdown,
        ItemAutocompleteWithInfo,
        ProviderAutocomplete,
        UserAutocomplete
    },
    mixins: [
        ResourceCreateForm
    ],
    data() {
        return {
            repairableItems: [],

            newItemDefault: {
                user_id: this.$store.getters['auth/userId'],
                start_date: new Date().toISOString().substr(0, 10)
            },

            createdEvent: EventTypes.REPAIR_CREATED,
            apiCreateEndpoint: '/api/repairs'
        };
    },
    methods: {
        getRepairableItems() {
            axios.get('/api/items', {
                params: {
                    scopes: ['onlyRepairable'],
                    perPage: -1
}
            }).then(response => {
                this.repairableItems = response.data.data;
            });
        }
    },
    created() {
        this.getRepairableItems();
    }
};
</script>
