<template>
    <div>
        <v-tabs
            v-model="tab"
            color="primary accent-4"
            right

        >
            <v-tab>Графіки кількості</v-tab>
            <v-tab>Кількість по приміщеннях</v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab" touchless>
            <v-tab-item>
                <v-container fluid>
                    <item-count-chart-wrapper/>
                </v-container>
            </v-tab-item>
            <v-tab-item>
                <v-container fluid>
                    <departments-tree/>
                </v-container>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import DepartmentsTree from '~/components/Charts/DepartmentsTree/DepartmentsTree';
import ItemCountChartWrapper from '~/components/Charts/ItemCountChartWrapper';

export default {
    name: 'StatsController',
    components: {
        DepartmentsTree,
        ItemCountChartWrapper
    },
    data: () => ({
        tab: null
    })
};
</script>
