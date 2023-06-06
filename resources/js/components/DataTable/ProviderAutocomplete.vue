<template>
    <div>
        <v-autocomplete
            v-model="internalValue"
            :disabled="isDisabled"
            :error-messages="errorMessages"
            :items="$store.state.providers.providers"
            :loading="isLoadingProviders"
            item-text="title"
            item-value="id"
            label="Постачальник"
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
                        Додати постачальника
                    </v-list-item-content>
                </v-list-item>
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
                    <span class="headline">Додавання постачальників</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <validation-observer
                            :disabled="!isActiveMenu"
                            ref="providerCreateFormObserver"
                        >
                            <v-row>
                                <v-col cols="12">
                                    <validation-provider
                                        v-slot="{ errors }"
                                        rules="required|min:3|max:40"
                                        name="Назва"
                                    >
                                        <v-text-field
                                            v-model="provider.title"
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
                                        rules="required|min:5|max:50"
                                        name="Адреса"
                                    >
                                        <v-text-field
                                            v-model="provider.address"
                                            :counter="50"
                                            :error-messages="errors"
                                            label="Адреса"
                                            autocomplete="off"
                                        />
                                    </validation-provider>
                                </v-col>
                                <v-col cols="12">
                                    <validation-provider
                                        v-slot="{ errors }"
                                        rules="required|min:5|max:20"
                                        name="Номер телефону"
                                    >
                                        <v-text-field
                                            v-model="provider.phone"
                                            :counter="20"
                                            :error-messages="errors"
                                            label="Номер телефону"
                                            autocomplete="off"
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
                    :loading="isLoadingWhileCreating"
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
    name: 'ProviderAutocomplete',
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
        errorMessages: {}
    },

    data: () => ({
        provider: {},
        isActiveMenu: false,
        isLoadingWhileCreating: false
    }),
    computed: {
        isDisabled() {
            return this.isLoadingProviders || this.disabled;
        },
        isLoadingProviders() {
            return this.$store.state.providers.loading;
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
            this.provider = {};
            this.$refs.providerCreateFormObserver.reset();
        },

        create() {
            this.$refs.providerCreateFormObserver.validate()
            .then(result => {
                if(result) {
                    this.isLoadingWhileCreating = true;
                    axios.post('/api/providers', this.provider)
                    .then(response => {
                        this.$store.commit('providers/unshift', response.data);
                        this.internalValue = response.data.id;

                        this.close();
                        Snackbar.success('Додано');
                    }).finally(() => {
                        this.isLoadingWhileCreating = false;
                    });
                }
            });
        }
    },
    created() {
        this.$store.dispatch('providers/fetch');
    }
};
</script>
