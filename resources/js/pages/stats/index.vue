<template>
    <stats-controller/>
</template>

<script>
import StatsController from '~/components/Charts/StatsController';

export default {
    name: 'StatsIndex',
    middleware: ['auth', 'can:view-stats'],
    components: {
        StatsController
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
