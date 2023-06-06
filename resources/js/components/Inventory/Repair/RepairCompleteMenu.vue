<template>
    <v-menu
        v-model="isActive"
        @keydown.esc="close()"
        :close-on-content-click="false"
        min-width="500"
    >
        <template #activator="{ on: onMenu }">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <span v-on="{ ...onTooltip }">
                        <v-btn
                            icon
                            @click="open()"
                            :disabled="! isUncompleted"
                        >
                            <v-icon
                                dense
                            >
                                mdi-progress-wrench
                            </v-icon>
                        </v-btn>
                    </span>
                </template>

                <span>{{ tooltipText }}</span>
            </v-tooltip>
        </template>

        <v-card>
            <v-card-title>
                Завершення ремонту
            </v-card-title>
            <v-card-text class="px-4">
                <validation-observer
                    ref="repairCompleteObserver"
                >
                    <v-row>
                        <v-col class="py-0">
                            <validation-provider
                                v-slot="{ errors }"
                                :rules="{
                                    required: true,
                                    repair_end_date_after_or_equal_to_start_date: {
                                        start_date: repair.start_date
                                    }
                                }"
                                name="Дата завершення"
                            >
                                <datepicker-dropdown
                                    v-model="form.end_date"
                                    :disabled="isLoading"
                                    :errors="errors"
                                    input-label="Дата завершення"
                                />
                            </validation-provider>
                        </v-col>

                        <v-col class="py-0">
                            <validation-provider
                                v-slot="{ errors }"
                                rules="required"
                                name="Не підлягає ремонту"
                            >
                                <v-checkbox
                                    v-model="form.is_unrepairable"
                                    :error-messages="errors"
                                    :disabled="isLoading"
                                    class="mb-0"
                                    color="red"
                                    label="Не підлягає ремонту"
                                />
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="py-0">
                            <validation-provider
                                v-slot="{ errors }"
                                name="Коментар"
                                rules="max:255"
                            >
                                <v-textarea
                                    v-model="form.comment"
                                    :counter="255"
                                    :disabled="isLoading"
                                    :error-messages="errors"
                                    :rows="2"
                                    label="Коментар"
                                    no-resize
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
    name: 'RepairCompleteMenu',
    mixins: [
        FormValidate
    ],
    components: {
        DatepickerDropdown,
        DialogActions
    },
    props: {
        repairId: {
            type: Number,
            required: true
        },

        isUncompleted: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            isActive: false,
            isLoading: false,

            repair: {},
            form: {
                is_unrepairable: null,
                end_date: null,
                comment: null
            }
        };
    },
    computed: {
        tooltipText: function() {
            return this.isUncompleted ? 'Завершення ремонту' : 'Ремонт вже завершений';
        }
    },
    methods: {
        open() {
            this.isActive = true;
            this.resetForm();
            this.loadRepairData();
        },
        close() {
            this.isActive = false;
            this.$refs.repairCompleteObserver.reset();
        },
        save() {
            this.$refs.repairCompleteObserver.validate().then(result => {
                if(!result) {
                    return;
                }

                this.isLoading = true;
                axios.patch(`/api/repairs/${ this.repairId }/complete`, this.form)
                .then(() => {
                    this.$emit('completed');

                    Snackbar.success('Ремонт закінчено');

                    this.close();
                    this.resetForm();
                }).finally(() => {
                    this.isLoading = false;
                });
            });
        },

        loadRepairData() {
            this.isLoading = true;
            axios.get(`/api/repairs/${ this.repairId }`)
            .then(response => {
                this.repair = response.data;
                this.form.comment = this.repair.comment;
            }).finally(() => {
                this.isLoading = false;
            });
        },

        resetForm() {
            this.form = {
                is_unrepairable: false,
                end_date: new Date().toISOString().substr(0, 10),
                comment: null
            };
        }
    }
};
</script>
