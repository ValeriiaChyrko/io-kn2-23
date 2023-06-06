<template>
    <validation-observer
        ref="createFormObserver"
    >
        <v-row>
            <v-col
                cols="12"
                md="3"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Дата передачі"
                    rules="required"
                >
                    <datepicker-dropdown
                        v-model="transfer.transfer_date"
                        :errors="errors"
                        input-label="Дата передачі"
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="3"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Номер"
                    rules="required|max:100"
                >
                    <v-text-field
                        v-model="transfer.transfer_number"
                        :counter="100"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Номер"
                        required
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="3"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Файл передачі"
                    rules="required|ext:pdf,jpg,jpeg,png"
                >
                    <v-file-input
                        v-model="file"
                        label="Файл передачі"
                        show-size
                        truncate-length="23"
                        :error-messages="errors"
                    />
                </validation-provider>
            </v-col>
        </v-row>
        <v-row class="mb-6">
            <v-col
                cols="12"
                md="6"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Предмети"
                    rules="required|numeric"
                >
                    <item-autocomplete-with-info
                        v-model="transfer.items_id"
                        :error-messages="errors"
                        :items="filteredItems"
                        label="Предмети"
                        multiple
                        chips
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="3"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Кому передаємо"
                    :rules="{
                        required: true,
                        receiver_is_not_owner: itemsOwnerId
                }"
                >
                    <user-autocomplete
                        v-model="transfer.to_user_id"
                        :error-messages="errors"
                        input-label="Кому передаємо"
                    />
                </validation-provider>
            </v-col>

            <v-col
                class="d-flex align-center"
                cols="12"
                md="2"
            >
                <create-button
                    @click="create()"
                    text="Передати обладнання"
                />
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import ItemAutocompleteWithInfo from '~/components/DataTable/ItemAutocompleteWithInfo';
import UserAutocomplete from '~/components/DataTable/UserAutocomplete';
import DatepickerDropdown from '~/components/DatepickerDropdown';
import CreateButton from '~/components/Forms/CreateButton';
import FormValidate from '~/components/mixins/FormValidate';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'TransferCreateForm',
    components: {
        DatepickerDropdown,
        ItemAutocompleteWithInfo,
        UserAutocomplete,
        CreateButton
    },
    mixins: [
        FormValidate
       // ResourceCreateForm
    ],
    data() {
        return {
            transferableItems: [],
            file: null,
            transfer: {}
        };
    },
    methods: {
        getTransferableItems() {
            axios.get('/api/items', {
                params: {
                    scopes: ['onlyTransferable'],
                    perPage: -1
                }
            }).then(response => {
                this.transferableItems = response.data.data;
            });
        },
        async create() {
            if(!await this.$refs.createFormObserver.validate()) {
                return;
            }
            this.isLoading = true;
            (await axios.post('/api/transfers', this.createData(), {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })).data;

            EventBus.$emit(EventTypes.TRANSFER_CREATED);

            this.resetForm();
            this.getTransferableItems();
            this.isLoading = false;
        },
        createData() {
            let formData = new FormData();
            console.log(this.transfer.items_id);
            for (var i = 0; i < this.transfer.items_id.length; i++) {
                formData.append('items_id[]', this.transfer.items_id[i]);
            }
            formData.append('transfer_date', this.transfer.transfer_date);
            formData.append('transfer_number', this.transfer.transfer_number);
            formData.append('to_user_id', this.transfer.to_user_id);
            formData.append('file', this.file);

            return formData;
        },
        resetForm() {
            this.transfer = {};
            this.file = null;
            this.$refs.createFormObserver.reset();
        }
    },
    computed: {
        itemsOwnerId() {
            if ((this.transfer.items_id ?? []).length > 0) {
                return this.transferableItems.find(item => {
                    return item.id === this.transfer.items_id[0]
                }).owner_id;
            }
            return -1;
        },
        filteredItems(){
            if ((this.transfer.items_id ?? []).length > 0) {
                return this.transferableItems.filter( item => {
                    return item.owner_id === this.itemsOwnerId;
                });
            } else {
                return this.transferableItems;
            }
        }
    },
    created() {
        this.getTransferableItems();
    }
};
</script>
