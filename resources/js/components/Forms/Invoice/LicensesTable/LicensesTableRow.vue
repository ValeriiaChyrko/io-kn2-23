<template>
    <validation-observer
        ref="formObserver"
        tag="tr"
    >
        <td>{{ index }}</td>
        <template v-if="isExpanded">
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
                    ref="softwareModelField"
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="М.В. Особа"
                rules="required|numeric"
                tag="td"
            >
                <user-autocomplete
                    v-model="license.owner_id"
                    @input="input()"
                    :disabled="!editable"
                    :error-messages="errors"
                    ref="userField"
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="Дійсна до"
                rules=""
                tag="td"
            >
                <datepicker-dropdown
                    v-model="license.end_date"
                    @input="input()"
                    :disabled="!editable"
                    :errors="errors"
                    no-input-icon
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="Ціна"
                rules="required|price|max_value:999999.99"
                tag="td"
            >
                <v-text-field
                    v-model="license.price"
                    @input="input()"
                    :disabled="!editable"
                    :error-messages="errors"
                    autocomplete="off"
                    ref="priceField"
                    required
                />
            </validation-provider>
        </template>
        <template v-else>
            <td @click="activate('softwareModelField')" class="cursor-pointer text-body-1">
                {{ softwareModel.title }}
            </td>
            <td @click="activate('userField')" class="cursor-pointer text-body-1">
                {{ owner.name }}
            </td>
            <td @click="activate()" class="cursor-pointer text-body-1">
                {{ formatDate(license.end_date) }}
            </td>
            <td @click="activate('priceField')" class="cursor-pointer text-body-1">
                {{ license.price }}
            </td>
        </template>
        <td class="text-no-wrap">
            <parent-item-select-menu
                v-if="editable"
                v-model="license.item_id"
                @input="input()"
                :items="parentable"
                :owner.sync="license.owner_id"
            />
            <parent-item-view-menu
                v-else
                :item-id="license.item_id"
            />
            <license-copy-menu
                :disabled="!isExists || !editable"
                :license-id="license.id"
            />


            <license-delete-button
                v-if="isExists"
                @delete="deleteLocally()"
                :disabled="!editable"
                :license-id="license.id"
            />
            <delete-button
                v-else
                @delete="deleteLocally()"
            />
        </td>
        <td class="text-no-wrap">
            <load-status-icon
                :saving="license.isSaving"
                :exists="isExists"
            />
        </td>
    </validation-observer>
</template>

<script>
import { debounce } from 'lodash-es';
import DeleteButton from '~/components/DataTable/DeleteButton';
import SoftwareModelAutocomplete from '~/components/DataTable/SoftwareModelAutocomplete';
import UserAutocomplete from '~/components/DataTable/UserAutocomplete';
import DatepickerDropdown from '~/components/DatepickerDropdown';
import CopyMenu from '~/components/Forms/Invoice/ItemsTable/ItemCopyMenu';
import LicenseCopyMenu from '~/components/Forms/Invoice/LicensesTable/LicenseCopyMenu';
import LicenseDeleteButton from '~/components/Forms/Invoice/LicensesTable/LicenseDeleteButton';
import LoadStatusIcon from '~/components/Forms/Invoice/LoadStatusIcon/LoadStatusIcon';
import ParentItemSelectMenu from '~/components/Inventory/Invoice/ParentItemSelectMenu';
import ParentItemViewMenu from '~/components/Inventory/Invoice/ParentItemViewMenu';
import DateFormatting from '~/components/mixins/DateFormatting';
import FormValidate from '~/components/mixins/FormValidate';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'LicensesTableRow',
    mixins: [
        DateFormatting,
        FormValidate
    ],
    components: {
        ParentItemViewMenu,
        LicenseCopyMenu,
        CopyMenu,
        DatepickerDropdown,
        DeleteButton,
        LoadStatusIcon,
        LicenseDeleteButton,
        ParentItemSelectMenu,
        SoftwareModelAutocomplete,
        UserAutocomplete
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
        license: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        editable() {
            return !this.approved || this.can('edit-approved-invoice')
        },
        isExpanded() {
            return this.isActive || !this.isExists;
        },
        isExists() {
            return Boolean(this.license.id);
        },
        isFilled() {
            return !!this.license.software_model_id
                && !!this.license.owner_id
                && !!this.license.price;
        },
        owner() {
            return this.$store.getters['users/find'](this.license.owner_id);
        },
        softwareModel() {
            return this.$store.getters['softwareModels/find'](this.license.software_model_id);
        }
    },
    methods: {
        activate(fieldRef = null) {
            this.isActive = true;
            EventBus.$emit(EventTypes.LICENSE_ROW_ACTIVATED, {
                uid: this.license.uid
            });

            if(fieldRef) {
                setTimeout(() => {
                    this.$refs[fieldRef].$el.querySelector('input').focus();
                });
            }
        },
        deactivate() {
            this.isActive = false;
        },
        input: debounce(function() {
            if(!this.isFilled) {
                return;
            }

            this.$refs.formObserver.validate()
            .then(result => {
                if(!result) { return; }

                if(this.isExists) {
                    this.updateLicense();
                } else {
                    this.isActive = true;
                    this.createLicense();
                }
            });
        }, 350),

        createLicense() {
            this.license.isSaving = true;

            axios.post(`/api/invoices/${ this.invoiceId }/licenses`, this.license)
            .then(response => {
                let license = response.data;
                license.uid = this.license.uid;
                license.isSaving = this.license.isSaving;

                this.license = license;
            }).finally(() => {
                this.license.isSaving = false;
            });
        },
        updateLicense() {
            this.license.isSaving = true;

            axios.patch(`/api/licenses/${ this.license.id }`, this.license)
            .finally(() => {
                this.license.isSaving = false;
            });
        },
        deleteLocally() {
            this.$emit('delete');
        }
    },
    created() {
        EventBus.$on(EventTypes.LICENSE_ROW_ACTIVATED, payload => {
            if(payload.uid !== this.license.uid) {
                this.deactivate();
            }
        });
    }
};
</script>
