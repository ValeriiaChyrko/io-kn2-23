<template>
    <v-btn
        @click="$emit('add')"
        :disabled="disabled"
        class="ma-2"
        color="indigo"
        outlined
    >
        {{ buttonText }}
        <v-icon>mdi-plus</v-icon>
    </v-btn>
</template>

<script>
export default {
    name: 'InvoiceCreateFormResourceAddButton',
    props: {
        buttonText: {
            type: String,
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        }
    }
};
</script>
