<template>
    <delete-dialog
        @confirm="deleteLicense()"
        :active.sync="isActive"
        :loading.sync="isLoading"
        :disabled="disabled"
    >
        <template #dialog-title>
            Видалити ліцензію?
        </template>

        <template #dialog-text>
            Після підтвердженя ліцензія буде видалена.<br/>
            Ви справді бажаєте продовжити?
        </template>
    </delete-dialog>
</template>

<script>
import DeleteDialog from '~/components/DataTable/DeleteDialog';

export default {
    name: 'LicenseDeleteButton',
    components: {
        DeleteDialog
    },
    props: {
        licenseId: {
            type: Number,
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
        isActive: false,
        isLoading: false
    }),
    methods: {
        deleteLicense() {
            this.isLoading = true;

            axios.delete(`/api/licenses/${this.licenseId}`)
            .then(response => {
                if(response.data) {    // TODO: Create one format for delete endpoint response
                    this.$emit('delete');
                }
            }).finally(() => {
                this.isLoading = false;
                this.isActive = false;
            });
        }
    }
};
</script>
