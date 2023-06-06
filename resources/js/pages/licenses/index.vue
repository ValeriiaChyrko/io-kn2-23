<template>
    <licenses-table/>
</template>

<script>
import LicensesTable from '~/components/Tables/LicensesTable';

export default {
    name: 'LicensesIndex',
    middleware: ['auth', 'can:view-licenses'],
    components: {
        LicensesTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
