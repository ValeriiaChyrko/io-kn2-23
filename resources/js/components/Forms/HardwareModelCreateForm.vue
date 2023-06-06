<template>
    <validation-observer
        ref="createFormObserver"
    >
        <v-row>
            <v-col
                cols="12"
                md="6"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Назва"
                    rules="required|max:200"
                >
                    <v-text-field
                        v-model="newItem.title"
                        :counter="200"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Назва"
                        required
                    />
                </validation-provider>
            </v-col>
            <v-col
                class="d-flex align-center"
                cols="12"
                md="4"
            >
                <create-button
                    @click="create()"
                    text="Додати модель"
                />
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import ResourceCreateForm from '~/components/mixins/ResourceCreateForm';
import { EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'HardwareModelCreateForm',
    mixins: [
        ResourceCreateForm
    ],
    data() {
        return {
            createdEvent: EventTypes.HARDWARE_MODEL_CREATED,

            apiCreateEndpoint: '/api/hardware-models'
        };
    }
};
</script>
