<template>
    <div>
        <roles-table/>
    </div>
</template>

<script>
import RolesTable from '~/components/Tables/RolesTable';

export default {
    name: 'RolesIndex',
    middleware: ['auth', 'can:view-roles'],
    components: {
        RolesTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
