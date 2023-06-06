<template>
    <v-dialog
        v-model="isActive"
        @keydown.enter="confirm()"
        max-width="310"
    >
        <template #activator="{ on: onDialog }">
            <v-tooltip
                left
            >
                <template #activator="{ on: onTooltip }">
                    <span v-on="onTooltip">
                        <v-btn
                            v-on="{ ...onDialog }"
                            :disabled="approved"
                            icon
                        >
                        <v-icon>
                            mdi-text-box-check-outline
                        </v-icon>
                    </v-btn>
                    </span>
                </template>
                <span>{{ tooltipText }}</span>
            </v-tooltip>
        </template>


        <v-card>
            <v-card-title>
                Затвердження накладної
            </v-card-title>
            <v-card-text>
                Після затвердження накладна буде закрита для змін, предмети стануть доступні для взаємодії.<br/>
                Ви справді бажаєте продовжити?
            </v-card-text>

            <dialog-actions
                @cancel="close()"
                @confirm="approve()"
                :loading="isLoading"
                confirm-color="red darken-1"
                cancel-text="Ні"
                confirm-text="Так"
            />
        </v-card>
    </v-dialog>
</template>

<script>
import DialogActions from '~/components/DataTable/DialogActions';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import Snackbar from '~/components/modules/Snackbar';

export default {
    name: 'InvoiceApprovalDialog',
    components: {
        DialogActions
    },
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
    data: () => ({
        isActive: false,
        isLoading: false
    }),
    computed: {
        tooltipText() {
            return this.approved ? "Накладна вже затверджена" : "Затвердити накладну";
        }
    },
    methods: {
        close() {
            this.isActive = false;
        },
        async approve() {
            this.isLoading = true;

            await axios.post(`/api/invoices/${this.invoiceId}/approve`);    // Check is approved

            this.isLoading = false;
            EventBus.$emit(EventTypes.CLOSE_INVOICE_EDIT_FORM);
            Snackbar.success('Накладна затверджена');
            this.close();
        }
    }
};
</script>
