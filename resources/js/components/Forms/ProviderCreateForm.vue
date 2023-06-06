<template>
    <validation-observer
        ref="createFormObserver"
    >
        <v-row>
            <v-col
                cols="12"
                md="3"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Назва"
                    rules="required|min:3|max:40"
                >
                    <v-text-field
                        v-model="newItem.title"
                        :counter="40"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Назва"
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
                    name="Адреса"
                    rules="required|min:5|max:50"
                >
                    <v-text-field
                        v-model="newItem.address"
                        :counter="50"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Адреса"
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
                    name="Номер телефону"
                    rules="required|min:5|max:20"
                >
                    <v-text-field
                        v-model="newItem.phone"
                        :counter="20"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Номер телефону"
                        required
                    />
                </validation-provider>
            </v-col>
            <v-col
                class="d-flex align-center"
                cols="12"
                md="3"
            >
                <create-button
                    @click="create()"
                    text="Додати постачальника"
                />
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import ResourceCreateForm from '~/components/mixins/ResourceCreateForm';
import { EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'ProviderCreateForm',
    mixins: [
        ResourceCreateForm
    ],
    data() {
        return {
            createdEvent: EventTypes.PROVIDER_CREATED,

            apiCreateEndpoint: '/api/providers'
        };
    }
};
</script>
