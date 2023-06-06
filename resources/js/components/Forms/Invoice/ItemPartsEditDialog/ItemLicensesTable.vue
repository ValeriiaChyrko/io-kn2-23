<template>
    <div>
        <v-simple-table>
            <thead>
            <tr>
                <th>Назва</th>
                <th>Дійсна до</th>
                <th>Ціна</th>
                <th class="min-width"/>
                <th class="min-width"/>
            </tr>
            </thead>
            <tbody>
            <item-licenses-table-row
                v-for="(license, index) in licenses"
                v-model="licenses[index]"
                @delete="deleteByIndex(index)"
                :approved="approved"
                :key="license.uid"
                :item-id="itemId"
            />
            </tbody>
        </v-simple-table>
        <resource-add-button
            @add="addLicense()"
            :disabled="!editable"
            button-text="Додати ліцензію"
        />
    </div>
</template>

<script>
import ItemLicensesTableRow from '~/components/Forms/Invoice/ItemPartsEditDialog/ItemLicensesTableRow';
import InvoiceCreateFormResourceAddButton from '~/components/Inventory/Invoice/InvoiceCreateFormResourceAddButton';

export default {
    name: 'ItemLicensesTable',
    components: {
        'resource-add-button': InvoiceCreateFormResourceAddButton,
        ItemLicensesTableRow
    },
    props: {
        value: {
            type: Array,
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
    computed: {
        licenses: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        editable() {
            return !this.approved || this.can('edit-approved-invoice');
        }
    },
    methods: {
        addLicense() {
            this.licenses.push({
                uid: this.genUID()
            });
        },
        deleteByIndex(index) {
            this.licenses.splice(index, 1);
        }
    }
};
</script>
