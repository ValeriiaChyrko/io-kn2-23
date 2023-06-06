<template>
    <v-tooltip
        :disabled="hideTooltip"
        top
    >
        <template #activator="{ on }">
            <v-icon v-on="on">
                mdi-cloud-alert
            </v-icon>
        </template>
        <span>Не існує на сервері</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'MissingOnServerIcon',
    props: {
        hideTooltip: {
            type: Boolean,
            default: false
        }
    }
};
</script>
