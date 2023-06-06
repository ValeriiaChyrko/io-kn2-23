<template>
    <div>
        <v-autocomplete
            v-model="internalValue"
            :disabled="isDisabled"
            :error-messages="errorMessages"
            :items="$store.state.users.users"
            :label="inputLabel"
            :loading="isLoadingUsers"
            item-text="name"
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
                        Додати користувача
                    </v-list-item-content>
                </v-list-item>
            </template>
        </v-autocomplete>

        <v-dialog
            v-model="isActiveMenu"
            max-width="600px"
            @keydown.esc="close()"
            @keydown.enter="create()"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">Додавання користувачів</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <validation-observer
                            ref="userCreateFormObserver"
                            :disabled="!isActiveMenu"
                        >
                            <v-row>
                                <v-col cols="12">
                                    <validation-provider
                                        v-slot="{ errors }"
                                        name="Ім'я"
                                        rules="required|min:5|max:100"
                                    >
                                        <v-text-field
                                            v-model="user.name"
                                            :counter="40"
                                            :error-messages="errors"
                                            autocomplete="off"
                                            label="Ім'я"
                                        />
                                    </validation-provider>
                                </v-col>
                                <v-col cols="12">
                                    <validation-provider
                                        v-slot="{ errors }"
                                        name="Ел.пошта"
                                        rules="required|email"
                                    >
                                        <v-text-field
                                            v-model="user.email"
                                            :counter="50"
                                            :error-messages="errors"
                                            autocomplete="off"
                                            label="Ел.пошта"
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
    name: 'UserAutocomplete',
    mixins: [
        FormValidate
    ],
    components: {
        DialogActions
    },
    props: {
        value: {
            required: true
        },

        disabled: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            default: ''
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

        user: {}
    }),
    computed: {
        isDisabled() {
            return this.isLoadingUsers || this.disabled;
        },
        isLoadingUsers() {
            return this.$store.state.users.loading;
        },
        internalValue: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    methods: {
        openMenu() {
            this.isActiveMenu = true;
        },
        close() {
            this.isActiveMenu = false;
            this.user = {};
            this.$refs.userCreateFormObserver.reset();
        },

        create() {
            this.$refs.userCreateFormObserver.validate()
            .then(result => {
                if(!result) {
                    return;
                }
                this.isLoading = true;

                axios.post('/api/users', this.user)
                .then(response => {
                    this.$store.commit('users/unshift', response.data);
                    this.internalValue = response.data.id;

                    this.close();
                    Snackbar.success('Додано');
                }).finally(() => {
                    this.isLoading = false;
                });
            });
        }
    },
    created() {
        this.$store.dispatch('users/fetch');
    }
};
</script>
