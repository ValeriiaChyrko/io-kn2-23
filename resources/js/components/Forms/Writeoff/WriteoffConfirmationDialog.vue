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
                            :disabled="confirmed"
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
                Підтвердження списанння
            </v-card-title>
            <v-card-text>
                Після затвердження списання буде закрите для змін, предмети стануть недоступні для взаємодії.<br/>
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
    name: 'WriteoffConfirmationDialog',
    components: {
        DialogActions
    },
    props: {
        writeoffId: {
            type: Number,
            required: true
        },
        confirmed: {
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
            return this.confirmed ? "Списання вже підтверджене" : "Підтвердити списання";
        }
    },
    methods: {
        close() {
            this.isActive = false;
        },
        async approve() {
            this.isLoading = true;

            // await axios.post(`/api/writeoffs/${this.writeoffId}/confirm`);

            setTimeout(() => {
                this.isLoading = false;
                EventBus.$emit(EventTypes.CLOSE_WRITEOFF_EDIT_FORM);
                Snackbar.success('Списання підтверджене');
                this.close();
            }, 750);
        }
    }
};
</script>
