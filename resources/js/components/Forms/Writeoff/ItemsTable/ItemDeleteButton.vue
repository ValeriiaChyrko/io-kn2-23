<template>
    <delete-dialog
        @confirm="deleteItem()"
        :active.sync="isActive"
        :loading.sync="isLoading"
        :disabled="disabled"
    >
        <template #dialog-title>
            Видалити предмет<br>зі списання?
        </template>

        <template #dialog-text>
            Після підтвердженя предмет буде видалений зі списання.<br/>
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

            setTimeout(() => {
                this.$emit('delete');
                this.isLoading = false;
                this.isActive = false;
            }, 750);
        }
    }
};
</script>
