<template>
    <items-table/>
</template>

<script>
import ItemsTable from '~/components/Tables/ItemsTable';

export default {
    name: 'ItemsIndex',
    middleware: ['auth', 'can:view-items'],
    components: {
        ItemsTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
