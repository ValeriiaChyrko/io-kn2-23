<template>
    <v-btn
        @click="syncUsers()"
        :disabled="isLoading"
        :loading="isLoading"
        class="mr-4"
        color="info"
    >
        <v-icon>mdi-refresh</v-icon>
        <span class="d-none d-md-inline">Оновити користувачів GSuite</span>
        <template #loader>
            <span class="loader">
                <v-icon light>mdi-cached</v-icon>
            </span>
        </template>
    </v-btn>
</template>

<script>

import Snackbar from '~/components/modules/Snackbar';
import { EventBus, EventTypes } from '~/components/modules/EventBus';

export default {
    name: 'GoogleUsersSyncButton',
    data: function() {
        return {
            isLoading: false
        };
    },
    methods: {
        syncUsers() {
            this.isLoading = true;
            axios.get('/api/users/addusers').then(() => {
                Snackbar.success('GSuite користувачі оновлено');
            }).finally(() => {
                this.isLoading = false;
                EventBus.$emit(EventTypes.GOOGLE_WORKSPACE_USERS_LOADED);
            });
        }
    }
};
</script>

<style scoped>
.loader {
    animation: loader 1s infinite;
    display: flex;
}

@-moz-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}

@-webkit-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}

@-o-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
