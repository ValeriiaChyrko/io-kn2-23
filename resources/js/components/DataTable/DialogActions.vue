<template>
    <v-card-actions>
        <v-spacer v-if="stickToRight"/>

        <template v-if="closeOnly">
            <v-btn
                @click="close()"
                :loading="loading"
                :disabled="loading"
                text
            >
                {{ closeText }}
            </v-btn>
        </template>
        <template v-else>
            <v-btn
                v-if="!hideCancel"
                @click="cancel()"
                :disabled="loading"
                :loading="isLoadingCancelButton"
                :color="cancelColor"
                text
            >
                {{ cancelText }}
            </v-btn>
            <v-btn
                v-if="!hideConfirm"
                @click="confirm()"
                :disabled="loading"
                :loading="loading"
                :color="confirmColor"
                text
            >
                {{ confirmText }}
            </v-btn>
        </template>
    </v-card-actions>
</template>

<script>
export default {
    name: 'DialogActions',
    props: {
        loading: {
            type: Boolean,
            default: false
        },

        stickToLeft: {
            type: Boolean,
            default: false
        },

        closeOnly: {
            type: Boolean,
            default: false
        },
        closeText: {
            type: String,
            default: 'Закрити'
        },

        hideCancel: {
            type: Boolean,
            default: false
        },
        hideConfirm: {
            type: Boolean,
            default: false
        },

        cancelColor: {
            type: String,
            default: ''
        },
        confirmColor: {
            type: String,
            default: 'primary'
        },


        cancelText: {
            type: String,
            default: 'Відмінити'
        },
        confirmText: {
            type: String,
            default: 'Зберегти'
        }
    },
    computed: {
        stickToRight: function() {
            return !this.stickToLeft;
        },
        isLoadingCancelButton: function() {
            if(this.loading === false) {
                return false;
            }

            return this.hideConfirm;
            //If confirm button is hidden, then loading animation must be shown in a cancel button
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        cancel() {
            this.$emit('cancel');
        },
        confirm() {
            this.$emit('confirm');
        }
    }
};
</script>
