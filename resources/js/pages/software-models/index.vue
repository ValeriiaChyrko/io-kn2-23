<template>
    <div>
        <software-model-create-form/>

        <software-models-table/>
    </div>
</template>

<script>
import SoftwareModelCreateForm from '~/components/Forms/SoftwareModelCreateForm';
import SoftwareModelsTable from '~/components/Tables/SoftwareModelsTable';

export default {
    name: 'SoftwareModelsIndex',
    middleware: ['auth', 'can:view-software-models'],
    components: {
        SoftwareModelsTable,
        SoftwareModelCreateForm
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
