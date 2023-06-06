<template>
    <div>
        <v-simple-table>
            <thead>
            <tr>
                <th class="text-left">
                    Тип
                </th>
                <th class="text-left">
                    Модель
                </th>
                <th class="text-left">
                    Ціна
                </th>
                <th class="min-width"/>
                <th class="min-width"/>
            </tr>
            </thead>
            <tbody>
            <item-parts-table-row
                v-for="(part, index) in parts"
                v-model="parts[index]"
                @delete="deleteByIndex(index)"
                :approved="approved"
                :key="part.uid"
                :item-id="itemId"
            />
            </tbody>
        </v-simple-table>
        <resource-add-button
            @add="addPart()"
            :disabled="!editable"
            button-text="Додати деталь"
        />
    </div>
</template>

<script>
import ItemPartsTableRow from '~/components/Forms/Invoice/ItemPartsEditDialog/ItemPartsTableRow';
import InvoiceCreateFormResourceAddButton from '~/components/Inventory/Invoice/InvoiceCreateFormResourceAddButton';

export default {
    name: 'ItemPartsTable',
    components: {
        'resource-add-button': InvoiceCreateFormResourceAddButton,
        ItemPartsTableRow
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
        parts: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        editable() {
            return !this.approved || this.can('edit-approved-invoice');
        }
    },
    methods: {
        addPart() {
            this.parts.push({
                uid: this.genUID()
            });
        },
        deleteByIndex(index) {
            this.parts.splice(index, 1);
        }
    }
};
</script>
