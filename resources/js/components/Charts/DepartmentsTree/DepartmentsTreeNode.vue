<template>
    <v-list-item-content>
        <v-list-item-title>
            {{ department.title }}

            <total-items-count-chip
                v-if="activeChips.includes('withNested')"
                :count="department.nested_items_count + department.items_count"
            />
            <child-departments-items-count-chip
                v-if="activeChips.includes('onlyNested')"
                :count="department.nested_items_count"
            />
            <items-count-chip
                v-if="activeChips.includes('withoutNested')"
                :count="department.items_count"
            />
            <child-departments-count-chip
                v-if="activeChips.includes('childrenCount')"
                :count="department.children_count"
            />
        </v-list-item-title>
    </v-list-item-content>
</template>

<script>
import ChildDepartmentsCountChip from '~/components/Charts/DepartmentsTree/ChildDepartmentsCountChip';
import ChildDepartmentsItemsCountChip from '~/components/Charts/DepartmentsTree/ChildDepartmentsItemsCountChip';
import ItemsCountChip from '~/components/Charts/DepartmentsTree/ItemsCountChip';
import TotalItemsCountChip from '~/components/Charts/DepartmentsTree/TotalItemsCountChip';
import TooltippedText from '~/components/Inventory/Invoice/TooltippedText';

export default {
    name: 'DepartmentsTreeNode',
    components: {
        TotalItemsCountChip,
        ChildDepartmentsItemsCountChip,
        ChildDepartmentsCountChip,
        ItemsCountChip,
        TooltippedText
    },
    props: {
        department: {
            type: Object,
            required: true
        },
        activeChips: {
            type: Array,
            required: true
        }
    }
};
</script>
