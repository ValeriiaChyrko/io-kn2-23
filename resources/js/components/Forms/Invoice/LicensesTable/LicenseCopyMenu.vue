<template>
    <v-menu
        v-model="isActive"
        :close-on-content-click="false"
        :close-on-click="!isLoading"
        :min-width="370"
        :max-width="560"
        offset-y
        left
    >
        <template #activator="{ on: onMenu }">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <v-btn
                        icon
                        v-on="{...onMenu, ...onTooltip}"
                        :disabled="disabled"
                    >
                        <v-icon
                            dense
                        >
                            mdi-content-copy
                        </v-icon>
                    </v-btn>
                </template>
                <span>Копіювати</span>
            </v-tooltip>
        </template>

        <v-card>
            <v-card-text>
                <validation-observer ref="formObserver">
                    <v-list-item-content>
                        <validation-provider
                            v-slot="{ errors }"
                            rules="required|min_value:1"
                        >
                            <v-text-field
                                v-model="count"
                                :error-messages="errors"
                                autocomplete="off"
                                label="Кількість копій"
                                min="1"
                                type="number"
                                required
                            />
                        </validation-provider>
                    </v-list-item-content>
                </validation-observer>
            </v-card-text>

            <dialog-actions
                @cancel="cancel()"
                @confirm="duplicate()"
                confirm-text="Створити"
            />
        </v-card>
    </v-menu>
</template>

<script>
import DialogActions from '~/components/DataTable/DialogActions';
import FormValidate from '~/components/mixins/FormValidate';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import Snackbar from '~/components/modules/Snackbar';

export default {
    name: 'LicenseCopyMenu',
    mixins: [
        FormValidate
    ],
    components: {
        DialogActions
    },
    props: {
        disabled: {
            type: Boolean,
            default: false
        },
        licenseId: {
            type: Number,
            default: 0
        }
    },
    data: () => ({
        isActive: false,
        isLoading: false,

        count: 1
    }),
    methods: {
        cancel() {
            this.isActive = false;
        },
        async duplicate() {
            if(!await this.$refs.formObserver.validate()) {
                return;
            }
            this.isLoading = true;

            await axios.post(`/api/licenses/${ this.licenseId }/copy`, { count: this.count });

            Snackbar.success('Копії створено');

            EventBus.$emit(EventTypes.RELOAD_INVOICE_LICENSES_TABLE);
            this.isLoading = false;
            this.isActive = false;
        }
    }
};
</script>


