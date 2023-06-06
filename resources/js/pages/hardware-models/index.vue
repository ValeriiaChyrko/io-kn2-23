<template>
    <div>
        <hardware-model-create-form/>

        <hardware-models-table/>
    </div>
</template>

<script>
import HardwareModelCreateForm from '~/components/Forms/HardwareModelCreateForm';
import HardwareModelsTable from '~/components/Tables/HardwareModelsTable';

export default {
    name: 'HardwareModelsIndex',
    middleware: ['auth', 'can:view-hardware-models'],
    components: {
        HardwareModelsTable,
        HardwareModelCreateForm
    },
    metaInfo() {
        return {
            title: this.$route.meta.title
        };
    }
};
</script>
