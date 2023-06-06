<template>
    <span>
        {{ saving ? 'Збереження...' : (showSavedText ? 'Збережено' : '') }}
    </span>
</template>

<script>

export default {
    name: 'LoadStatusText',
    props: {
        saving: {
            type: Boolean,
            required: true
        }
    },
    data: () => ({
        showSavedText: false
    }),
    watch: {
        saving(newValue) {
            if(newValue === false) {
                this.showSavedText = true;

                setTimeout(() => {
                    this.showSavedText = false;
                }, 3500);
            }
        }
    }
};
</script>
