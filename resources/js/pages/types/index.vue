<template>
    <div>
        <type-create-form/>

        <types-table/>
    </div>
</template>

<script>
import TypeCreateForm from '~/components/Forms/TypeCreateForm';
import TypesTable from '~/components/Tables/TypesTable';

export default {
    name: 'TypesIndex',
    middleware: ['auth', 'can:view-types'],
    components: {
        TypesTable,
        TypeCreateForm
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
