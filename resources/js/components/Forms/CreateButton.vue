<template>
    <v-btn
        @click="$emit('click')"
        :loading="loading"
        color="success"
    >
        <v-icon>
            mdi-plus
        </v-icon>
        <span>{{ text }}</span>
    </v-btn>
</template>

<script>
export default {
    name: 'CreateButton',
    props: {
        text: {
            type: String,
            default: 'Створити'
        },
        loading: {
            type: Boolean,
            default: false
        }
    }
};
</script>
