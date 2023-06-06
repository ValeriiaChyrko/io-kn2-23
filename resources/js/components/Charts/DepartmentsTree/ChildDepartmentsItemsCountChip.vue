<template>
    <tooltipped-text
        v-if="count"
        tooltip-text="Кількість предметів у дочірніх"
    >
        <v-chip
            color="teal"
            text-color="white"
            small
        >
            <v-icon small left>
                mdi-laptop
            </v-icon>
            {{ count }}
        </v-chip>
    </tooltipped-text>
</template>

<script>
import TooltippedText from '~/components/Inventory/Invoice/TooltippedText';

export default {
    name: 'ChildDepartmentsItemsCountChip',
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
