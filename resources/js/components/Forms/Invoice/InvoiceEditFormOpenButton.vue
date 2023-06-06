<template>
    <v-tooltip top>
        <template #activator="{ on: onTooltip }">
            <v-badge
                :value="!approved"
                class="data-table-expandable-row-badge"
                color="blue"
                overlap
                dot
            >
                <v-btn
                    icon
                    @click="openForm()"
                >
                    <v-icon
                        v-on="{ ...onTooltip }"
                        dense
                    >
                        mdi-file-edit
                    </v-icon>
                </v-btn>
            </v-badge>
        </template>
        <span>Редагувати накладну</span>
    </v-tooltip>
</template>

<script>
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'InvoiceEditFormOpenButton',
    props: {
        invoiceId: {
            type: Number,
            required: true
        },
        approved: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        openForm() {
            EventBus.$emit(EventTypes.OPEN_INVOICE_EDIT_FORM, {
                invoiceId: this.invoiceId
            });
        }
    }
};
</script>
