<template>
    <v-dialog
        v-model="isActive"
        @keydown.enter="confirm()"
        max-width="310"
    >
        <template #activator="{ on: onDialog}">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <v-btn
                        v-on="{ ...onDialog, ...onTooltip }"
                        :disabled="disabled"
                        icon
                    >
                        <v-icon>
                            mdi-delete
                        </v-icon>
                    </v-btn>
                </template>
                <span>{{ tooltipText }}</span>
            </v-tooltip>
        </template>


        <v-card>
            <v-card-title>
                <slot name="dialog-title"/>
            </v-card-title>
            <v-card-text>
                <slot name="dialog-text"/>
            </v-card-text>

            <dialog-actions
                @cancel="closeMenu()"
                @confirm="confirm()"
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

export default {
    name: 'DeleteDialog',
    components: {
        DialogActions
    },
    props: {
        active: {
            type: Boolean,
            required: true
        },
        loading: {
            type: Boolean,
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        },
        tooltipText: {
            type: String,
            default: 'Видалити'
        }
    },
    computed: {
        isActive: {
            get() { return this.active; },
            set(val) { this.$emit('update:active', val); }
        },
        isLoading: {
            get() { return this.loading; },
            set(val) { this.$emit('update:loading', val); }
        }
    },
    methods: {
        closeMenu() {
            this.isActive = false;
        },
        confirm() {
            this.$emit('confirm');
        }
    }
};
</script>
