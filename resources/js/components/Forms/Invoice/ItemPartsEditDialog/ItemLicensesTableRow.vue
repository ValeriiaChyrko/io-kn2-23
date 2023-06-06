<template>
    <validation-observer
        ref="formObserver"
        tag="tr"
    >
        <validation-provider
            v-slot="{ errors }"
            name="Модель ПЗ"
            rules="required|numeric"
            tag="td"
        >
            <software-model-autocomplete
                v-model="license.software_model_id"
                @input="input()"
                :disabled="!editable"
                :errors="errors"
            />
        </validation-provider>
        <td>
            <datepicker-dropdown
                v-model="license.end_date"
                @input="input()"
                :disabled="!editable"
                no-input-icon
            />
        </td>
        <validation-provider
            v-slot="{ errors }"
            name="Ціна"
            rules="price|max_value:999999.99"
            tag="td"
        >
            <v-text-field
                v-model="license.price"
                @input="input()"
                :disabled="!editable"
                :error-messages="errors"
                autocomplete="off"
            />
        </validation-provider>
        <td class="text-no-wrap">
            <license-delete-button
                v-if="isExists"
                @delete="deleteLocally()"
                :disabled="!editable"
                :license-id="license.id"
            />
            <delete-button
                v-else
                :deletable="!editable"
                @delete="deleteLocally()"
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
import SoftwareModelAutocomplete from '~/components/DataTable/SoftwareModelAutocomplete';
import DatepickerDropdown from '~/components/DatepickerDropdown';
import LicenseDeleteButton from '~/components/Forms/Invoice/LicensesTable/LicenseDeleteButton';
import LoadStatusIcon from '~/components/Forms/Invoice/LoadStatusIcon/LoadStatusIcon';
import FormValidate from '~/components/mixins/FormValidate';

export default {
    name: 'ItemLicensesTableRow',
    mixins: [ FormValidate ],
    components: {
        LoadStatusIcon,
        LicenseDeleteButton,
        DeleteButton,
        DatepickerDropdown,
        SoftwareModelAutocomplete
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
        license: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        isExists: function() {
            return Boolean(this.license.id);
        },
        isFilled: function() {
            return Boolean(this.license.software_model_id);
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

            axios.post(`/api/items/${ this.itemId }/licenses`, {
                software_model_id: this.license.software_model_id,
                end_date: this.license.end_date,
                price: this.license.price
            }).then(response => {
                let license = response.data;
                license.uid = this.license.uid;

                this.license = license;
            }).finally(() => {
                this.isSaving = false;
            });
        },
        updatePart() {
            this.isSaving = true;

            axios.patch(`/api/licenses/${ this.license.id }`, {
                software_model_id: this.license.software_model_id,
                end_date: this.license.end_date,
                price: this.license.price
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
