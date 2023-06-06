<template>
    <div>
        <transfer-create-form/>

        <transfers-table/>
    </div>
</template>

<script>
import TransferCreateForm from '~/components/Forms/TransferCreateForm';
import TransfersTable from '~/components/Tables/TransfersTable';

export default {
    name: 'TransfersIndex',
    middleware: ['auth', 'can:view-transfers'],
    components: {
        TransferCreateForm,
        TransfersTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
