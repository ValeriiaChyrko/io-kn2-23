<template>
    <tooltipped-text
        v-if="count"
        tooltip-text="Кількість предметів у цьому приміщені"
    >
        <v-chip
            color="indigo"
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
    name: 'ItemsCountChip',
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
