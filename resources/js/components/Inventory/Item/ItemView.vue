<template>
    <item-full-data
        :item-id="itemId"
    />
</template>

<script>
import ItemFullData from './ItemFullData';

export default {
    name: 'ItemView',
    components: {
        ItemFullData
    },
    props: {
        itemId: {
            type: [String, Number],
            required: true
        }
    }
};
</script>
