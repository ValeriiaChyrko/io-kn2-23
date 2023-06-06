<template>
    <validation-observer
        ref="formObserver"
    >
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
                        :errors="errors"
                        :disabled="isLoading"
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
                    rules="required|numeric|max:100"
                >
                    <v-text-field
                        v-model="writeoff.number"
                        :counter="100"
                        :disabled="isLoading"
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
                        :disabled="isLoading"
                        :error-messages="errors"
                        input-label="Відповідальна особа"
                    />
                </validation-provider>
            </v-col>
            <!--            <v-col-->
            <!--                cols="12"-->
            <!--                md="2"-->
            <!--            >-->
            <!--                <validation-provider-->
            <!--                    v-slot="{ errors }"-->
            <!--                    name="Файл списання"-->
            <!--                    rules="required|ext:pdf,jpg,jpeg,png"-->
            <!--                >-->
            <!--                    <v-file-input-->
            <!--                        v-model="file"-->
            <!--                        :error-messages="errors"-->
            <!--                        label="Файл накладної"-->
            <!--                        ref="fileInput"-->
            <!--                        truncate-length="23"-->
            <!--                        show-size-->
            <!--                    />-->
            <!--                </validation-provider>-->
            <!--            </v-col>-->
            <v-col
                class="d-flex align-center"
                cols="12"
                md="2"
            >
                <create-button
                    @click="create()"
                    :loading="isLoading"
                    text="Додати списання"
                />
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import ProviderAutocomplete from '~/components/DataTable/ProviderAutocomplete';
import UserAutocomplete from '~/components/DataTable/UserAutocomplete';
import DatepickerDropdown from '~/components/DatepickerDropdown';
import CreateButton from '~/components/Forms/CreateButton';
import FormValidate from '~/components/mixins/FormValidate';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'WriteoffCreateForm',
    mixins: [
        FormValidate
    ],
    components: {
        UserAutocomplete,
        CreateButton,
        DatepickerDropdown,
        ProviderAutocomplete
    },
    data: () => ({
        isLoading: false,

        file: null,
        writeoff: {}
    }),
    methods: {
        async create() {
            // if(!await this.$refs.formObserver.validate()) {
            //     return;
            // }
            // this.isLoading = true;
            // let writeoff = (await axios.post('/api/writeoffs', this.createData(), {
            //     headers: {
            //         'Content-Type': 'multipart/form-data'
            //     }
            // })).data;
            //
            // EventBus.$emit(EventTypes.WRITEOFF_CREATED);
            // EventBus.$emit(EventTypes.OPEN_WRITEOFF_EDIT_FORM, {
            //     writeoffId: writeoff.id
            // });
            //
            // this.resetForm();
            // this.isLoading = false;

            if(!await this.$refs.formObserver.validate()) {
                return;
            }
            this.isLoading = true;

            await new Promise(resolve => setTimeout(resolve, 2000));

            EventBus.$emit(EventTypes.WRITEOFF_CREATED);
            EventBus.$emit(EventTypes.OPEN_WRITEOFF_EDIT_FORM, {
                writeoffId: 1
            });

            this.resetForm();
            this.isLoading = false;
        },
        createData() {
            let formData = new FormData();
            formData.append('date', this.writeoff.date);
            formData.append('number', this.writeoff.number);
            formData.append('user_id', this.writeoff.user_id);
            // formData.append('file', this.file);

            return formData;
        },
        resetForm() {
            this.writeoff = {};
            this.file = null;
            this.$refs.formObserver.reset();
        }
    }
};
</script>
