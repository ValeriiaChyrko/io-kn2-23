<template>
    <v-tooltip
        :disabled="hideTooltip"
        top
    >
        <template #activator="{ on }">
            <v-icon
                v-on="on"
                class="rotating"
            >
                mdi-cached
            </v-icon>
        </template>
        <span>Збереження...</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'LoadingIcon',
    props: {
        hideTooltip: {
            type: Boolean,
            default: false
        }
    }
};
</script>

<style scoped>
.rotating {
    animation: rotating 1s infinite;
    display: flex;
}

@-moz-keyframes rotating {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}

@-webkit-keyframes rotating {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}

@-o-keyframes rotating {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes rotating {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
