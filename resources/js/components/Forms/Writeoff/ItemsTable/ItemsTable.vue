<template>
    <div>
        <v-simple-table>
            <thead>
            <tr>
                <th class="min-width"/>
                <th>Предмет</th>
                <th>Причина списання</th>
                <th class="min-width"/>
                <th class="min-width"/>
            </tr>
            </thead>
            <tbody>
            <items-table-row
                v-for="(item, index) in items"
                v-model="items[index]"
                @delete="deleteByIndex(index)"
                :confirmed="confirmed"
                :writeoff-id="writeoffId"
                :key="item.uid"
                :index="index + 1"
            />
            </tbody>
        </v-simple-table>

        <resource-add-button
            @add="addItem()"
            :disabled="!editable"
            button-text="Додати предмет"
        />
    </div>
</template>

<script>
import ItemsTableRow from '~/components/Forms/Writeoff/ItemsTable/ItemsTableRow';
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
        writeoffId: {
            type: Number,
            required: true
        },
        confirmed: {
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
            return !this.confirmed
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
            EventBus.$emit(EventTypes.WRITEOFF_ITEM_ROW_ACTIVATED, {
                uid
            });
        },
        deleteByIndex(index) {
            this.items.splice(index, 1);
        }
    }
};
</script>
