<template>
    <div>
        <writeoff-edit-form/>

        <writeoff-create-form/>

        <writeoffs-table className="mt-2"/>
    </div>
</template>

<script>
import WriteoffsTable from '~/components/Tables/WriteoffsTable';
import WriteoffCreateForm from "~/components/Forms/Writeoff/WriteoffCreateForm.vue";
import WriteoffEditForm from "~/components/Forms/Writeoff/WriteoffEditForm.vue";

export default {
    name: 'InvoicesIndex',
    components: {
        WriteoffEditForm,
        WriteoffCreateForm,
        WriteoffsTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
