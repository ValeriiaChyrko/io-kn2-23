<template>
    <validation-observer
        ref="formObserver"
        tag="tr"
    >
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
            />
        </validation-provider>
        <validation-provider
            v-slot="{ errors }"
            name="Ціна"
            rules="price|max_value:999999.99"
            tag="td"
        >
            <v-text-field
                v-model="item.price"
                @input="input()"
                :disabled="!editable"
                :error-messages="errors"
                autocomplete="off"
            />
        </validation-provider>
        <td
            class="text-no-wrap"
        >
            <item-delete-button
                v-if="isExists"
                :disabled="!editable"
                @delete="deleteLocally()"
                :item-id="item.id"
            />
            <delete-button
                v-else
                @delete="deleteLocally()"
                :deletable="!editable"
            />
        </td>
        <td class="text-no-wrap">
            <load-status-icon
                :exists="isExists"
                :saving="isSaving"
            />
        </td>
    </validation-observer>
</template>

<script>
import { debounce } from 'lodash-es';
import DeleteButton from '~/components/DataTable/DeleteButton';
import HardwareModelAutocomplete from '~/components/DataTable/HardwareModelAutocomplete';
import TypeAutocomplete from '~/components/DataTable/TypeAutocomplete';
import ItemDeleteButton from '~/components/Forms/Invoice/ItemsTable/ItemDeleteButton';
import LoadStatusIcon from '~/components/Forms/Invoice/LoadStatusIcon/LoadStatusIcon';
import FormValidate from '~/components/mixins/FormValidate';

export default {
    name: 'ItemPartsTableRow',
    mixins: [ FormValidate ],
    components: {
        LoadStatusIcon,
        DeleteButton,
        ItemDeleteButton,
        HardwareModelAutocomplete,
        TypeAutocomplete,
    },
    props: {
        value: {
            type: Object,
            required: true
        },
        itemId: {
            type: Number,
            required: true
        },
        approved: {
            type: Boolean,
            required: true
        }
    },
    data: () => ({
        isSaving: false
    }),
    computed: {
        item: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        isExists() {
            return !!this.item.id;
        },
        isFilled() {
            return !!this.item.type_id
                && !!this.item.hardware_model_id;
        },
        editable() {
            return !this.approved || this.can('edit-approved-invoice');
        }
    },
    methods: {
        input: debounce(function() {
            if(!this.isFilled) {
                return;
            }

            this.$refs.formObserver.validate()
            .then(result => {
                if(!result) { return; }

                if(this.isExists) {
                    this.updatePart();
                } else {
                    this.createPart();
                }
            });
        }, 350),

        createPart() {
            this.isSaving = true;

            axios.post(`/api/items/${ this.itemId }/parts`, {
                type_id: this.item.type_id,
                hardware_model_id: this.item.hardware_model_id,
                price: this.item.price
            }).then(response => {
                let item = response.data;
                item.uid = this.item.uid;

                this.item = item;
            }).finally(() => {
                this.isSaving = false;
            });
        },
        updatePart() {
            this.isSaving = true;

            axios.patch(`/api/items/${ this.item.id }`, {
                type_id: this.item.type_id,
                hardware_model_id: this.item.hardware_model_id,
                price: this.item.price
            }).finally(() => {
                this.isSaving = false;
            });
        },
        deleteLocally() {
            this.$emit('delete');
        }
    }
};
</script>
