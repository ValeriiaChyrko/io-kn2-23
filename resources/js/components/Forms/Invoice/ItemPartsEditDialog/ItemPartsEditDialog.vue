<template>
    <v-dialog
        v-model="isActive"
        max-width="80%"
        @keydown.esc="close()"
        @click:outside="close()"
    >
        <template #activator="{ on }">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <v-badge
                        :color="badgeColor"
                        :content="partsLicensesCount"
                        :value="isBadgeVisible"
                        overlap
                    >
                        <v-btn
                            icon
                            v-on="{ ...onTooltip }"
                            @click="openDialog()"
                            :disabled="disabled"
                        >
                            <v-icon
                                dense
                            >
                                mdi-file-tree
                            </v-icon>
                        </v-btn>
                    </v-badge>
                </template>
                <span>{{ tooltipText }}</span>
            </v-tooltip>
        </template>

        <v-card>
            <v-card-title>
                <span class="headline">Деталі обладнання</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <item-parts-table
                        v-model="items"
                        :approved="approved"
                        :item-id="itemId"
                    />

                    <item-licenses-table
                        v-model="licenses"
                        :approved="approved"
                        :item-id="itemId"
                    />
                </v-container>
            </v-card-text>

            <dialog-actions
                @close="close()"
                close-only
            />
        </v-card>
    </v-dialog>
</template>

<script>
import DialogActions from '~/components/DataTable/DialogActions';
import ItemLicensesTable from '~/components/Forms/Invoice/ItemPartsEditDialog/ItemLicensesTable';
import ItemPartsTable from '~/components/Forms/Invoice/ItemPartsEditDialog/ItemPartsTable';
import FormValidate from '~/components/mixins/FormValidate';

export default {
    name: 'ItemPartsEditDialog',
    mixins: [FormValidate],
    components: {
        ItemPartsTable,
        ItemLicensesTable,
        DialogActions
    },
    props: {
        partsCount: {
            type: Number,
            required: true
        },
        licensesCount: {
            type: Number,
            required: true
        },
        itemId: {
            type: Number,
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        },
        approved: {
            type: Boolean,
            required: true
        }
    },
    data: () => ({
        isActive: false,

        loadingItems: false,
        loadingLicenses: false,

        licenses: [],
        items: []
    }),
    methods: {
        close() {
            let partsCount = this.items.filter(item => item.id).length;
            let licensesCount = this.licenses.filter(license => license.id).length;

            this.$emit('update:parts-count', partsCount);
            this.$emit('update:licenses-count', licensesCount);

            this.items = [];
            this.licenses = [];

            this.isActive = false;
        },

        loadItems() {
            this.loadingItems = true;

            axios.get(`/api/items/${ this.itemId }/parts`)
            .then(response => {
                this.items = response.data;
            }).finally(() => {
                this.loadingItems = false;
            });
        },
        loadLicenses() {
            this.loadingLicenses = true;

            axios.get(`/api/items/${ this.itemId }/licenses`)
            .then(response => {
                this.licenses = response.data;
            }).finally(() => {
                this.loadingLicenses = false;
            });
        },

        openDialog() {
            this.isActive = true;

            this.loadItems();
            this.loadLicenses();
        }
    },
    computed: {
        isBadgeVisible() {
            return this.partsLicensesCount > 0;
        },
        partsLicensesCount() {
            return this.partsCount + this.licensesCount;
        },
        badgeColor() {
            return this.disabled ? 'grey' : 'green';
        },
        editable() {
            return !this.approved || this.can('edit-approved-invoice')
        },
        tooltipText() {
            return this.editable ? 'Додати комплектуючі' : 'Переглянути комплектуючі'
        }
    }
};
</script>
