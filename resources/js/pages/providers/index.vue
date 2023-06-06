<template>
    <div>
        <provider-create-form/>

        <providers-table/>
    </div>
</template>

<script>
import ProviderCreateForm from '~/components/Forms/ProviderCreateForm';
import ProvidersTable from '~/components/Tables/ProvidersTable';

export default {
    name: 'ProvidersIndex',
    middleware: ['auth', 'can:view-providers'],
    components: {
        ProvidersTable,
        ProviderCreateForm
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
