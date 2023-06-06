<template>
    <div>
        <user-create-form/>

        <users-table/>
    </div>
</template>

<script>
import UserCreateForm from '~/components/Forms/UserCreateForm';
import UsersTable from '~/components/Tables/UsersTable';

export default {
    name: 'UsersIndex',
    middleware: ['auth', 'can:view-users'],
    components: {
        UserCreateForm,
        UsersTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
