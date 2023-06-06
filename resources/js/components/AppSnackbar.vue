<template>
    <v-snackbar
        v-model="snack.visible"
        :color="snack.color"
        :timeout="3000"
        class="pb-0"
    >
        {{ snack.text }}

        <template #action="{ attrs }">
            <v-btn
                v-bind="attrs"
                @click="snack.visible = false"
                text

            >
                Закрити
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>

import { EventBus, EventTypes } from './modules/EventBus';

export default {
    name: 'AppSnackbar',
    data() {
        return {
            snack: {
                visible: false,
                color: '',
                text: ''
            }
        };
    },
    methods: {
        show(message, color) {
            this.snack.visible = true;
            this.snack.color = color;
            this.snack.text = message;
        }
    },
    created() {
        EventBus.$on(EventTypes.SNACKBAR_SHOW, data => {
            this.show(data.message, data.color);
        });
    }
};
</script>
