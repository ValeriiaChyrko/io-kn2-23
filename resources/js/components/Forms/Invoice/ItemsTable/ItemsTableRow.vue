<template>
    <validation-observer
        ref="formObserver"
        tag="tr"
    >
        <td>{{ index }}</td>
        <template v-if="isExpanded">
            <validation-provider
                v-slot="{ errors }"
                name="Тип обладнання"
                rules="required|numeric"
                tag="td"
            >
                <type-autocomplete
                    v-model="item.type_id"
                    @input="input()"
                    :disabled="!editable"
                    :errors="errors"
                    ref="typeField"
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                :rules="{
                    max: {length: 100},
                    item_number_regex: true,
                    distinct: inventoryNumbers,
                    item_number_unique: {ignoreId: item.id}
                }"
                name="Інвентарний номер"
                tag="td"
            >
                <v-text-field
                    v-model="item.inventory_number"
                    @input="input()"
                    :counter="100"
                    :disabled="!editable"
                    :error-messages="errors"
                    autocomplete="off"
                    ref="inventoryNumberField"
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="М.В. Особа"
                rules="required|numeric"
                tag="td"
            >
                <user-autocomplete
                    v-model="item.owner_id"
                    @input="input()"
                    :disabled="!editable"
                    :error-messages="errors"
                    ref="userField"
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="Приміщення"
                rules="required|numeric"
                tag="td"
            >
                <department-autocomplete
                    v-model="item.department_id"
                    @input="input()"
                    :disabled="!!item.part_of || !editable"
                    :error-messages="errors"
                    ref="departmentField"
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="Модель обладнання"
                rules="required|numeric"
                tag="td"
            >
                <hardware-model-autocomplete
                    v-model="item.hardware_model_id"
                    @input="input()"
                    :disabled="!editable"
                    :errors="errors"
                    ref="hardwareModelField"
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="Ціна"
                rules="required|price|max_value:999999.99"
                tag="td"
            >
                <!-- TODO: Create component for price input and auto formatting? -->
                <v-text-field
                    v-model="item.price"
                    @input="input()"
                    :disabled="!editable"
                    :error-messages="errors"
                    autocomplete="off"
                    ref="priceField"
                />
            </validation-provider>
        </template>
        <template v-else>
            <td @click="activate('typeField')" class="cursor-pointer text-body-1">
                {{ type.title }}
            </td>
            <td @click="activate('inventoryNumberField')" class="cursor-pointer text-body-1">
                {{ item.inventory_number }}
            </td>
            <td @click="activate('userField')" class="cursor-pointer text-body-1">
                {{ owner.name }}
            </td>
            <td @click="activate('departmentField')" class="cursor-pointer text-body-1">
               {{ department.title }}
            </td>
            <td @click="activate('hardwareModelField')" class="cursor-pointer text-body-1">
                {{ hardwareModel.title }}
            </td>
            <td @click="activate('priceField')" class="cursor-pointer text-body-1">
                {{ item.price }}
            </td>
        </template>
        <td
            class="text-no-wrap"
        >
            <item-parts-edit-dialog
                :approved="approved"
                :disabled="isDisabledPartsButton"
                :item-id="item.id"
                :parts-count.sync="item.parts_count"
                :licenses-count.sync="item.licenses_count"
            />

            <parent-item-select-menu
                v-if="editable"
                v-model="item.part_of"
                @input="input()"
                :disabled="isDisabledParentSelectButton"
                :department.sync="item.department_id"
                :owner.sync="item.owner_id"
                :items="parentable"
            />
            <parent-item-view-menu
                v-else
                :item-id="item.part_of"
            />

            <item-copy-menu
                :disabled="!isExists || !editable"
                :item-id="item.id"
                :inventory-number="item.inventory_number"
                enableNumberRange
            />


            <item-delete-button
                v-if="isExists"
                @delete="deleteLocally()"
                :disabled="!editable"
                :item-id="item.id"
            />
            <delete-button
                v-else
                :deletable="!!editable"
                @delete="deleteLocally()"
            />

        </td>
        <td class="text-no-wrap">
            <load-status-icon
                :saving="item.isSaving"
                :exists="isExists"
            />
        </td>
    </validation-observer>
</template>

<script>
import { debounce } from 'lodash-es';
import DeleteButton from '~/components/DataTable/DeleteButton';
import DepartmentAutocomplete from '~/components/DataTable/DepartmentAutocomplete';
import HardwareModelAutocomplete from '~/components/DataTable/HardwareModelAutocomplete';
import TypeAutocomplete from '~/components/DataTable/TypeAutocomplete';
import UserAutocomplete from '~/components/DataTable/UserAutocomplete';
import ItemPartsEditDialog from '~/components/Forms/Invoice/ItemPartsEditDialog/ItemPartsEditDialog';
import ItemCopyMenu from '~/components/Forms/Invoice/ItemsTable/ItemCopyMenu';
import ItemDeleteButton from '~/components/Forms/Invoice/ItemsTable/ItemDeleteButton';
import LoadStatusIcon from '~/components/Forms/Invoice/LoadStatusIcon/LoadStatusIcon';
import ParentItemSelectMenu from '~/components/Inventory/Invoice/ParentItemSelectMenu';
import ParentItemViewMenu from '~/components/Inventory/Invoice/ParentItemViewMenu';
import FormValidate from '~/components/mixins/FormValidate';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'ItemsTableRow',
    mixins: [
        FormValidate
    ],
    components: {
        ParentItemViewMenu,
        ItemPartsEditDialog,
        DeleteButton,
        DepartmentAutocomplete,
        ItemCopyMenu,
        HardwareModelAutocomplete,
        ItemDeleteButton,
        LoadStatusIcon,
        ParentItemSelectMenu,
        TypeAutocomplete,
        UserAutocomplete,
    },
    props: {
        value: {
            type: Object,
            required: true
        },
        invoiceId: {
            type: Number,
            required: true
        },
        inventoryNumbers: {
            type: Array,
            required: true
        },
        parentable: {
            type: Array,
            required: true
        },
        approved: {
            type: Boolean,
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },
    data: () => ({
        isActive: false
    }),
    computed: {
        item: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        editable() {
            return !this.approved || this.can('edit-approved-invoice');
        },
        isExpanded() {
            return this.isActive || !this.isExists;
        },
        isExists() {
            return !!this.item.id;
        },
        isFilled() {
            return !!this.item.type_id
                && !!this.item.owner_id
                && !!this.item.department_id
                && !!this.item.hardware_model_id
                && !!this.item.price;
        },
        isDisabledPartsButton() {
            return !this.isExists || !!this.item.part_of;
        },
        isDisabledParentSelectButton() {
            return this.partsCount > 0;
        },
        partsCount() {
            return this.item.parts_count + this.item.licenses_count;
        },
        type() {
            return this.$store.getters['types/find'](this.item.type_id);
        },
        owner() {
            return this.$store.getters['users/find'](this.item.owner_id);
        },
        department() {
            return this.$store.getters['departments/find'](this.item.department_id);
        },
        hardwareModel() {
            return this.$store.getters['hardwareModels/find'](this.item.hardware_model_id);
        }
    },
    methods: {
        activate(fieldRef = null) {
            this.isActive = true;
            EventBus.$emit(EventTypes.ITEM_ROW_ACTIVATED, {
                uid: this.item.uid
            });

            if(fieldRef) {
                setTimeout(() => {
                    this.$refs[fieldRef].$el.querySelector('input').click();
                });
            }
        },
        deactivate() {
            this.isActive = false;
        },
        deleteLocally() {
            this.$emit('delete');
        },
        input: debounce(async function() {
            if(!this.isFilled || !await this.$refs.formObserver.validate()) {
                return;
            }

            if(this.isExists) {
                this.updateItem();
            } else {
                this.isActive = true;
                this.createItem();
            }
        }, 350),
        createItem() {
            this.item.isSaving = true;

            axios.post(`/api/invoices/${ this.invoiceId }/items`, this.item)
            .then(response => {
                let item = response.data;

                this.$set(this.item, 'id', item.id);
            }).finally(() => {
                this.item.isSaving = false;
            });
        },
        updateItem() {
            this.item.isSaving = true;

            axios.patch(`/api/items/${ this.item.id }`, this.item)
            .finally(() => {
                this.item.isSaving = false;
            });
        },
    },
    created() {
        EventBus.$on(EventTypes.ITEM_ROW_ACTIVATED, payload => {
            if(payload.uid !== this.item.uid) {
                this.deactivate();
            }
        });
    }
};
</script>
