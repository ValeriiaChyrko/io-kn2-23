<template>
    <div>
        <invoice-edit-form/>

        <invoice-create-form/>

        <invoices-table/>
    </div>
</template>

<script>
import InvoiceCreateForm from '~/components/Forms/Invoice/InvoiceCreateForm';
import InvoiceEditForm from '~/components/Forms/Invoice/InvoiceEditForm';
import InvoicesTable from '~/components/Tables/InvoicesTable';

export default {
    name: 'InvoicesIndex',
    middleware: ['auth', 'can:view-invoices'],
    components: {
        InvoiceCreateForm,
        InvoiceEditForm,
        InvoicesTable
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
