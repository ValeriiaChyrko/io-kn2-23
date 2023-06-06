<template>
    <div>
        <repair-create-form/>

        <repairs-table/>
    </div>
</template>

<script>
import RepairCreateForm from '~/components/Forms/RepairCreateForm';
import RepairsTable from '~/components/Tables/RepairsTable';

export default {
    name: 'RepairsIndex',
    middleware: ['auth', 'can:view-repairs'],
    components: {
        RepairCreateForm,
        RepairsTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
