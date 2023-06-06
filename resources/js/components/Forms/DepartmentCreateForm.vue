<template>
    <validation-observer
        ref="createFormObserver"
    >
        <v-row class="mb-6">
            <v-col
                cols="12"
                md="4"
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
                cols="12"
                md="4"
            >
                <validation-provider
                    v-slot="{ errors }"
                    name="Батьківський департамент"
                    rules="required"
                >
                    <v-autocomplete
                        v-model="newItem.parent_id"
                        :items="$store.state.departments.departments"
                        :error-messages="errors"
                        label="Батьківський департамент"
                        item-text="title"
                        item-value="id"
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
                    text="Додати приміщення"
                />
            </v-col>
        </v-row>
    </validation-observer>
</template>

<script>
import ResourceCreateForm from '~/components/mixins/ResourceCreateForm';
import { EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'DepartmentCreateForm',
    mixins: [
        ResourceCreateForm
    ],
    data() {
        return {
            createdEvent: EventTypes.DEPARTMENT_CREATED,

            apiCreateEndpoint: '/api/departments'
        };
    },
    created() {
        this.$store.dispatch('departments/fetch');
    }
};
</script>
