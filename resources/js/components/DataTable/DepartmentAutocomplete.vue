<template>
    <div>
        <v-autocomplete
            v-model="internalValue"
            :disabled="isDisabled"
            :error-messages="errorMessages"
            :items="$store.state.departments.departments"
            :label="inputLabel"
            :loading="isLoadingDepartments"
            item-text="title"
            item-value="id"
            menu-props="closeOnContentClick"
        >
            <template slot="prepend-item">
                <v-list-item
                    @click="openMenu()"
                >
                    <v-list-item-icon class="mr-1">
                        <v-icon medium>
                            mdi-plus
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        Додати приміщення
                    </v-list-item-content>
                </v-list-item>
            </template>

            <template #item="data">
                <v-list-item-content>
                    <v-list-item-title>
                        {{ data.item.title }}
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        <v-icon x-small>mdi-home</v-icon>
                        {{ data.item.parent_title }}
                    </v-list-item-subtitle>
                </v-list-item-content>
            </template>
        </v-autocomplete>

        <v-dialog
            v-model="isActiveMenu"
            @keydown.esc="close()"
            @keydown.enter="create()"
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">Додавання приміщень</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <validation-observer
                            :disabled="!isActiveMenu"
                            ref="departmentCreateFormObserver"
                        >
                            <v-row>
                                <v-col cols="12">
                                    <validation-provider
                                        v-slot="{ errors }"
                                        rules="required|max:200"
                                        name="Назва"
                                    >
                                        <v-text-field
                                            v-model="department.title"
                                            :counter="40"
                                            :error-messages="errors"
                                            label="Назва"
                                            autocomplete="off"
                                        />
                                    </validation-provider>
                                </v-col>
                                <v-col cols="12">
                                    <validation-provider
                                        v-slot="{ errors }"
                                        rules="required|numeric"
                                        name="Батьківське приміщення"
                                    >
                                        <v-autocomplete
                                            v-model="department.parent_id"
                                            :items="$store.state.departments.departments"
                                            :error-messages="errors"
                                            label="Батьківський департамент"
                                            item-text="title"
                                            item-value="id"
                                        />
                                    </validation-provider>
                                </v-col>
                            </v-row>
                        </validation-observer>
                    </v-container>
                </v-card-text>

                <dialog-actions
                    @cancel="close()"
                    @confirm="create()"
                    :loading="isLoading"
                    confirm-text="Створити"
                />
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import Snackbar from '~/components/modules/Snackbar';
import FormValidate from '../mixins/FormValidate';
import DialogActions from './DialogActions';

export default {
    name: 'DepartmentAutocomplete',
    components: {
        DialogActions
    },
    mixins: [
        FormValidate
    ],
    props: {
        value: {
            required: true
        },

        disabled: {
            type: Boolean,
            default: false
        },

        errorMessages: {},
        inputLabel: {
            type: String,
            default: ''
        }
    },
    data: () => ({
        isActiveMenu: false,
        isLoading: false,

        department: {}
    }),
    computed: {
        isDisabled() {
            return this.isLoadingDepartments || this.disabled;
        },
        isLoadingDepartments() {
            return this.$store.state.departments.loading;
        },
        internalValue: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        }
    },
    methods: {
        openMenu() {
            this.isActiveMenu = true;
        },
        close() {
            this.isActiveMenu = false;
            this.department = {};
            this.$refs.departmentCreateFormObserver.reset();
        },

        create() {
            this.$refs.departmentCreateFormObserver.validate()
            .then(result => {
                if(result) {
                    this.isLoading = true;
                    axios.post('/api/departments', this.department)
                    .then(response => {
                        this.$store.commit('departments/unshift', response.data);
                        this.internalValue = response.data.id;

                        this.close();
                        Snackbar.success('Додано');
                    }).finally(() => {
                        this.isLoading = false;
                    });
                }
            });
        }
    },
    created() {
        this.$store.dispatch('departments/fetch');
    }
};
</script>
