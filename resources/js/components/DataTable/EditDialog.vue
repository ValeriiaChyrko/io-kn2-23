<template>
    <v-menu
        v-model="isActive"
        :close-on-click="!persistent"
        :close-on-content-click="false"
        :min-width="450"
    >
        <template #activator="{ on, attrs }">
            <div
                @click="show()"
                class="cursor-pointer"
            >
                <slot/>
            </div>
        </template>

        <v-card
            @keydown.enter="save()"
            @keydown.esc="cancel()"
        >
            <v-card-text>
                <slot name="input"/>
            </v-card-text>

            <dialog-actions
                @cancel="cancel()"
                @confirm="save()"
            />
        </v-card>
    </v-menu>
</template>

<script>

import DialogActions from './DialogActions';

export default {
    name: 'EditDialog',
    components: {
        DialogActions
    },
    data() {
        return {
            isActive: false,
            originalValue: null
        };
    },
    props: {
        persistent: Boolean,
        returnValue: {
            default: null
        },
        validator: {
            type: Object,
            default: null
        }
    },
    watch: {
        isActive(val) {
            if(val) {
                this.originalValue = this.returnValue;
                this.$emit('open');
            } else {
                this.$emit('update:return-value', this.originalValue);
                this.$emit('close');
            }
        }
    },
    methods: {
        cancel() {
            this.isActive = false;
            this.$emit('cancel');
        },
        save() {
            this.checkIsCanBeSaved().then(result => {
                if(result) {
                    if(this.originalValue === this.returnValue) {
                        this.isActive = false;
                        this.$emit('changeless-save');
                    } else {
                        this.isActive = false;
                        this.originalValue = this.returnValue;
                        this.$emit('save');
                    }
                } else {
                    this.$emit('save-forbidden');
                }
            });
        },
        show() {
            this.isActive = true;
        },
        async checkIsCanBeSaved() {
            if(!this.validator) {
                return true;
            }

            return this.validator.validate() //await
            .then(result => {
                return result;
            }).catch(() => {
                return false;
            });
        }
    }
};
</script>
