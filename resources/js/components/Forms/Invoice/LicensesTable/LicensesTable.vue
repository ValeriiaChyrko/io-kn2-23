<template>
    <div>
        <v-simple-table>
            <thead>
            <tr>
                <th class="min-width"/>
                <th>Модель</th>
                <th>
                    <tooltipped-text
                        text-activator="М.В.Особа"
                        tooltip-text="Матеріально відповідальна особа"
                    />
                </th>

                <th>Дійсна до</th>
                <th>Ціна</th>
                <th class="min-width"/>
                <th class="min-width"/>
            </tr>
            </thead>
            <tbody>
            <licenses-table-row
                v-for="(license, index) in licenses"
                v-model="licenses[index]"
                @delete="deleteByIndex(index)"
                :approved="approved"
                :invoice-id="invoiceId"
                :key="license.uid"
                :parentable="parentable"
                :index="index + 1"
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
import LicensesTableRow from '~/components/Forms/Invoice/LicensesTable/LicensesTableRow';
import InvoiceCreateFormResourceAddButton from '~/components/Inventory/Invoice/InvoiceCreateFormResourceAddButton';
import TooltippedText from '~/components/Inventory/Invoice/TooltippedText';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'LicensesTable',
    components: {
        'resource-add-button': InvoiceCreateFormResourceAddButton,
        LicensesTableRow,
        TooltippedText
    },
    props: {
        value: {
            type: Array,
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
        }
    },
    computed: {
        licenses: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        editable() {
            return !this.approved || this.can('edit-approved-invoice')
        }
    },
    methods: {
        addLicense() {

            let uid = this.genUID();
            this.licenses.push({
                uid,
                isSaving: false
            });

            // Send row activation event to close other rows.
            EventBus.$emit(EventTypes.LICENSE_ROW_ACTIVATED, {
                uid
            });
        },
        deleteByIndex(index) {
            this.licenses.splice(index, 1);
        }
    }
};
</script>
