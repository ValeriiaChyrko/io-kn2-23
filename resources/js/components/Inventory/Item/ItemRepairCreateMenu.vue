<template>
    <v-menu
        v-model="isActive"
        @keydown.esc="close()"
        :close-on-content-click="false"
    >
        <template #activator="{ ...onMenu }">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <span v-on="{ ...onTooltip }">
                        <v-btn
                            icon
                            @click="open()"
                            :disabled="!repairable"
                        >
                            <v-icon
                                dense
                            >
                                mdi-hammer-wrench
                            </v-icon>
                        </v-btn>
                    </span>
                </template>

                <span>{{ tooltipText }}</span>
            </v-tooltip>
        </template>

        <v-card>
            <v-card-title>
                Ремонт обладнання
            </v-card-title>
            <v-card-text class="px-4">
                <validation-observer
                    ref="repairCreateObserver"
                >
                    <v-row>
                        <v-col class="py-0">
                            <validation-provider
                                v-slot="{ errors }"
                                name="Виконавець ремонту"
                                rules="required|numeric"
                            >
                                <v-autocomplete
                                    v-model="repair.provider_id"
                                    :error-messages="errors"
                                    :items="$store.state.providers.providers"
                                    item-text="title"
                                    item-value="id"
                                    label="Виконавець ремонту"
                                />
                            </validation-provider>
                        </v-col>

                        <v-col class="py-0">
                            <validation-provider
                                v-slot="{ errors }"
                                name="Дата початку"
                                rules="required"
                            >
                                <datepicker-dropdown
                                    :errors="errors"
                                    v-model="repair.start_date"
                                    input-label="Дата початку"
                                />
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col class="py-0">
                            <validation-provider
                                v-slot="{ errors }"
                                name="Відповідальна особа"
                                rules="required|numeric"
                            >
                                <v-autocomplete
                                    v-model="repair.user_id"
                                    :error-messages="errors"
                                    :items="$store.state.users.users"
                                    item-text="name"
                                    item-value="id"
                                    label="Відповідальна особа"
                                />
                            </validation-provider>
                        </v-col>
                    </v-row>
                </validation-observer>
            </v-card-text>

            <dialog-actions
                @cancel="close()"
                @confirm="save()"
                :loading="isLoading"
            />
        </v-card>
    </v-menu>
</template>

<script>
import DatepickerDropdown from '../../DatepickerDropdown';
import DialogActions from '../../DataTable/DialogActions';
import FormValidate from '../../mixins/FormValidate';
import Snackbar from '~/components/modules/Snackbar';

export default {
    name: 'ItemRepairMenu',
    components: {
        DialogActions,
        DatepickerDropdown
    },
    mixins: [
        FormValidate
    ],
    data() {
        return {
            isActive: false,
            isLoading: false,

            repair: {
                start_date: null,
                item_id: null,
                provider_id: null,
                user_id: null
            }
        };
    },
    props: {
        repairable: {
            type: Boolean,
            required: true
        },
        itemId: {
            type: Number,
            required: true
        }
    },
    computed: {
        tooltipText: function() {
            return this.repairable ? 'Відправити у ремонт' : 'Статус не передбачає ремонт';
        }
    },
    methods: {
        open() {
            this.isActive = true;
            this.resetForm();
        },
        close() {
            this.isActive = false;
            this.$refs.repairCreateObserver.reset();
        },
        save() {
            this.$refs.repairCreateObserver.validate().then(result => {
                if(!result) {
                    return;
                }
                this.isLoading = true;
                //TODO: axios.post(`/api/items/${this.itemId}/repairs`, this.repair)
                axios.post(`/api/repairs`, this.repair)
                .then(() => {
                    Snackbar.success('Обладнання відправлено у ремонт');

                    this.$emit('created');

                    this.close();
                    this.resetForm();
                }).finally(() => {
                    this.isLoading = false;
                });
            });
        },

        resetForm() {
            this.repair = {
                start_date: new Date().toISOString().substr(0, 10),
                item_id: this.itemId,
                provider_id: null,
                user_id: this.$store.getters['auth/userId']
            };
        }
    },
    created() {
        this.$store.dispatch('providers/fetch');
        this.$store.dispatch('users/fetch');
    }
};
</script>
