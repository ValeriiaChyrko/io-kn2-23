<template>
    <v-menu
        v-model="isActive"
        @keydown.esc="close()"
        :close-on-content-click="false"
        min-width="500"
    >
        <template #activator="{ ...onMenu }">
            <span
                @click="open()"
                v-on="{ ...onMenu }"
                class="cursor-pointer"
            >
                <slot/>
            </span>
        </template>

        <v-card>
            <v-card-title>
                Редагування завершеного ремонту
            </v-card-title>
            <v-card-text
                class="px-4 pb-0"
            >
                <validation-observer
                    ref="repairUpdateObserver"
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
                                    :disabled="isFormDisabled"
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
                                    :disabled="isFormDisabled"
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
                                    :disabled="isFormDisabled"
                                    :error-messages="errors"
                                    :rows="2"
                                    label="Коментар"
                                    no-resize
                                />
                            </validation-provider>
                        </v-col>
                    </v-row>
                </validation-observer>

                <span
                    v-if="isForbidMessageShown"
                    class="text--primary"
                >
                    Редагування цих полів заборонене статусом обладнання.
                </span>
            </v-card-text>

            <dialog-actions
                @cancel="close()"
                @close="close()"
                @confirm="update()"
                :close-only="!repair.is_completion_data_editable"
                :loading="isLoading"
            />
        </v-card>
    </v-menu>
</template>

<script>
//TODO: Add message about change of status of related item

import DatepickerDropdown from '../../DatepickerDropdown';
import DialogActions from '../../DataTable/DialogActions';
import FormValidate from '../../mixins/FormValidate';
import Snackbar from '~/components/modules/Snackbar';

export default {
    name: 'CompletedRepairEditMenu',
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
        //Form fields must be disabled when data is loading OR when completion data in NOT editable
        isFormDisabled: function() {
            return this.isLoading || !this.repair.is_completion_data_editable;
        },
        //Forbid message must be when completion data in NOT editable.
        //But when repair data is not loaded yet, it will be null.
        //In this case message must be hidden.
        isForbidMessageShown: function() {
            return !(this.repair.is_completion_data_editable ?? true);
        }
    },
    methods: {
        open() {
            this.isActive = true;
            this.repair = {};
            this.loadRepairData();
        },
        close() {
            this.isActive = false;
            this.$refs.repairUpdateObserver.reset();
        },
        update() {
            this.$refs.repairUpdateObserver.validate().then(result => {
                if(!result) {
                    return;
                }

                this.isLoading = true;
                axios.patch(`/api/repairs/completed/${ this.repairId }`, this.form)
                .then(() => {
                    this.$emit('updated');

                    Snackbar.success('Зміни збережено');

                    this.close();
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

                this.form.end_date = response.data.end_date;
                this.form.is_unrepairable = response.data.is_unrepairable;
                this.form.comment = response.data.comment;
            }).finally(() => {
                this.isLoading = false;
            });
        }
    }
};
</script>
