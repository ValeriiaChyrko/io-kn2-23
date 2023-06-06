<template>
    <validation-observer ref="formObserver">
        <v-row>
            <v-col
                cols="12"
                md="3"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Дата списання"
                    rules="required"
                >
                    <datepicker-dropdown
                        v-model="writeoff.date"
                        @input="input()"
                        :disabled="!editable"
                        :errors="errors"
                        input-label="Дата списання"
                    />
                </validation-provider>
            </v-col>

            <v-col
                cols="12"
                md="3"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Номер"
                    rules="required|max:100"
                >
                    <v-text-field
                        v-model="writeoff.number"
                        @input="input()"
                        :counter="100"
                        :disabled="!editable"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Номер списання"
                        required
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="3"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Відповідальна особа"
                    rules="required|numeric"
                >
                    <user-autocomplete
                        v-model="writeoff.user_id"
                        @input="input()"
                        :disabled="!editable"
                        :error-messages="errors"
                        input-label="Відповідальна особа"
                    />
                </validation-provider>
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import { debounce } from 'lodash-es';
import ProviderAutocomplete from '~/components/DataTable/ProviderAutocomplete';
import UserAutocomplete from '~/components/DataTable/UserAutocomplete';
import DatepickerDropdown from '~/components/DatepickerDropdown';
import FormValidate from '~/components/mixins/FormValidate';

export default {
    name: 'OnlyWriteoffEdit',
    mixins: [
        FormValidate
    ],
    components: {
        UserAutocomplete,
        DatepickerDropdown,
        ProviderAutocomplete
    },
    props: {
        value: {},

        writeoffId: {
            type: Number,
            required: true
        }
    },
    data: () => ({
        file: null    // Create separate component
    }),
    computed: {
        writeoff: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },

        editable() {
            return !this.writeoff.confirmed;
        },
        isFilled() {
            return !!this.writeoff.date
                && !!this.writeoff.number
                && !!this.writeoff.user_id;
        }
    },
    methods: {
        input: debounce(function() {
            if(!this.isFilled) {
                return;
            }

            this.$refs.formObserver.validate()
                .then(result => {
                    if(result) {
                        this.updateWriteoff();
                    }
                });
        }, 350),
        async updateWriteoff() {
            this.writeoff.isSaving = true;

            await new Promise(resolve => setTimeout(resolve, 2000));

            this.writeoff.isSaving = false;
        }

        /*        updateWriteoff() {
                    this.writeoff.isSaving = true;

                    axios.patch(`/api/writeoffs/${this.writeoffId}`, this.writeoff)
                    .then(response => {
                        let writeoff = response.data;
                        writeoff.isSaving = this.writeoff.isSaving;

                        this.writeoff = writeoff;
                    }).finally(() => {
                        this.writeoff.isSaving = false;
                    });
                }*/
    }
};
</script>
