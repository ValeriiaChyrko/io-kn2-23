<template>
    <div>
        <v-simple-table>
            <thead>
            <tr>
                <th class="min-width"/>
                <th>Тип</th>
                <th>Інвентарний номер</th>
                <th>
                    <tooltipped-text
                        text-activator="М.В.Особа"
                        tooltip-text="Матеріально відповідальна особа"
                    />
                </th>
                <th>Приміщення</th>
                <th>Модель</th>
                <th>Ціна</th>
                <th class="min-width"/>
                <th class="min-width"/>
            </tr>
            </thead>
            <tbody>
            <items-table-row
                v-for="(item, index) in items"
                v-model="items[index]"
                @delete="deleteByIndex(index)"
                :approved="approved"
                :invoice-id="invoiceId"
                :key="item.uid"
                :inventory-numbers="inventoryNumbers"
                :index="index + 1"
                :parentable="parentable"
            />
            </tbody>
        </v-simple-table>

        <resource-add-button
            @add="addItem()"
            :disabled="!editable"
            button-text="Додати обладнання"
        />
    </div>
</template>

<script>
import ItemsTableRow from '~/components/Forms/Invoice/ItemsTable/ItemsTableRow';
import InvoiceCreateFormResourceAddButton from '~/components/Inventory/Invoice/InvoiceCreateFormResourceAddButton';
import TooltippedText from '~/components/Inventory/Invoice/TooltippedText';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'ItemsTable',
    components: {
        'resource-add-button': InvoiceCreateFormResourceAddButton,
        ItemsTableRow,
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
        items: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        editable() {
            return !this.approved || this.can('edit-approved-invoice')
        },
        inventoryNumbers() {
            return this.items.map(item => item.inventory_number);
        }
    },
    methods: {
        addItem() {
            let uid = this.genUID();
            this.items.push({
                uid,
                isSaving: false
            });

            // Send row activation event to close other rows.
            EventBus.$emit(EventTypes.ITEM_ROW_ACTIVATED, {
                uid
            });
        },
        deleteByIndex(index) {
            this.items.splice(index, 1);
        }
    }
};
</script>
