<template>
    <delete-dialog
        @confirm="deleteItem()"
        :active.sync="isActive"
        :loading.sync="isLoading"
        :disabled="disabled"
    >
        <template #dialog-title>
            Видалити предмет?
        </template>

        <template #dialog-text>
            Після підтвердженя предмет буде видалений разом із дочірнім обладнанням.<br/>
            Ви справді бажаєте продовжити?
        </template>
    </delete-dialog>
</template>

<script>
import DeleteDialog from '~/components/DataTable/DeleteDialog';

export default {
    name: 'ItemDeleteButton',
    components: {
        DeleteDialog
    },
    props: {
        itemId: {
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
        deleteItem() {
            this.isLoading = true;

            axios.delete(`/api/items/${this.itemId}`)
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
