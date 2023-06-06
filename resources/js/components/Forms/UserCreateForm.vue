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
                    name="Ім'я"
                    rules="required|min:5|max:100"
                >
                    <v-text-field
                        v-model="newItem.name"
                        :counter="100"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Ім'я"
                        required
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Ел.пошта"
                    rules="required|email"
                >
                    <v-text-field
                        v-model="newItem.email"
                        :error-messages="errors"
                        autocomplete="off"
                        label="Ел.пошта"
                        required
                    />
                </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="2"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Роль"
                    rules="required"
                >
                    <role-autocomplete
                        v-model="newItem.role_id"
                        :error-messages="errors"
                    />
                </validation-provider>
            </v-col>
            <v-col
                class="d-flex align-center"
                cols="12"
                md="5"
            >
                <create-button
                    @click="create()"
                    text="Додати користувача"
                    class="mr-3"
                />
                <google-users-sync-button/>

            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import RoleAutocomplete from '~/components/Inputs/RoleAutocomplete';
import GoogleUsersSyncButton from '~/components/Inventory/User/GoogleUsersSyncButton';
import ResourceCreateForm from '~/components/mixins/ResourceCreateForm';
import { EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'UserCreateForm',
    components: {
        RoleAutocomplete,
        GoogleUsersSyncButton
    },
    mixins: [
        ResourceCreateForm
    ],
    data: () => ({
        createdEvent: EventTypes.USER_CREATED,
        apiCreateEndpoint: '/api/users'
    })
};
</script>
