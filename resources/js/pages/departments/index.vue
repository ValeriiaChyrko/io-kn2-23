<template>
    <div>
        <department-create-form/>

        <departments-table/>
    </div>
</template>

<script>
import DepartmentCreateForm from '~/components/Forms/DepartmentCreateForm';
import DepartmentsTable from '~/components/Tables/DepartmentsTable';

export default {
    name: 'DepartmentsIndex',
    middleware: ['auth', 'can:view-departments'],
    components: {
        DepartmentCreateForm,
        DepartmentsTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
