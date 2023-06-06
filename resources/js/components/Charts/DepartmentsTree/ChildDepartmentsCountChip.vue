<template>
    <tooltipped-text
        v-if="count"
        tooltip-text="Кількість дочірніх приміщень"
    >
        <v-chip
            color="deep-purple"
            text-color="white"
            small
        >
            <v-icon small left>
                mdi-file-tree
            </v-icon>
            {{ count }}
        </v-chip>
    </tooltipped-text>
</template>

<script>
import TooltippedText from '~/components/Inventory/Invoice/TooltippedText';

export default {
    name: 'ChildDepartmentsCountChip',
    components: {
        TooltippedText
    },
    props: {
        count: {
            type: Number,
            required: true
        }
    }
};
</script>
