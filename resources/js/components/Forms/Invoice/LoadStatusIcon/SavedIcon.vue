<template>
    <v-tooltip
        :disabled="hideTooltip"
        top
    >
        <template #activator="{ on }">
            <v-icon v-on="on">
                mdi-cloud-check
            </v-icon>
        </template>
        <span>Збережено</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'SavedIcon',
    props: {
        hideTooltip: {
            type: Boolean,
            default: false
        }
    }
};
</script>
