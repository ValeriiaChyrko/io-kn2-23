<template>
    <tooltipped-text
        v-if="count"
        tooltip-text="Загальна кількість предметів у приміщенні і в дочірніх"
    >
        <v-chip
            color="green"
            text-color="white"
        >
            <v-avatar
                left
                class="green darken-4"
            >
                <v-icon small>
                    mdi-laptop
                </v-icon>
            </v-avatar>
            {{ count }}
        </v-chip>
    </tooltipped-text>
</template>

<script>
import TooltippedText from '~/components/Inventory/Invoice/TooltippedText';

export default {
    name: 'TotalItemsCountChip',
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
