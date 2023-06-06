<template>
    <v-tooltip top>
        <template #activator="{ on, attrs }">
            <span
                v-bind="attrs"
                v-on="on"
            >
                <slot>
                    {{ textActivator }}
                </slot>
            </span>
        </template>
        <span>{{ tooltipText }}</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'tooltipped-text',
    props: {
        tooltipText: {
            type: String,
            required: true
        },
        textActivator: {
            type: String,
            default: ''
        }
    }
};
</script>
