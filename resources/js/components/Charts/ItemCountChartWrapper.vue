<template>
    <div>
        <v-row>
            <v-col style="max-width: 500px; min-width: 450px">
                <filter-form
                    v-model="filters"
                    :configs="filterConfig"
                >
                    <template #header-append>
                        <v-autocomplete
                            v-model="groupBy"
                            @input="reloadData()"
                            class="ml-4"
                            label="Групувати за"
                            :items="groupByConfig"
                            hide-details
                            dense
                        />
                    </template>
                </filter-form>
            </v-col>
            <v-col>
                <item-count-chart
                    :chart-data="chartData"
                />
            </v-col>
        </v-row>
    </div>
</template>

<script>
import { debounce } from 'lodash-es';
import ItemCountChart from '~/components/Charts/ItemCountChart';
import FilterForm from '~/components/DataTable/Filter/FilterForm';

export default {
    name: 'ItemCountChartWrapper',
    components: {
        FilterForm,
        ItemCountChart
    },
    data: () => ({
        filterConfig: [
            {
                title: 'Тип',
                field: 'items.type_id',
                operators: ['in', 'nin'],
                type: 'types',
                initial: true
            },
            {
                title: 'Модель',
                field: 'items.hardware_model_id',
                operators: ['in', 'nin'],
                type: 'hardwareModels',
                initial: true
            },
            // { TODO
            //     title: 'Накладна',
            //     field: 'items.invoice_id',
            //     operators: ['in', 'nin']
            // },
            {
                title: 'Власник',
                field: 'items.owner_id',
                operators: ['in', 'nin'],
                type: 'users',
                initial: true
            },
            {
                title: 'Приміщення',
                field: 'items.department_id',
                operators: ['in', 'nin'],
                type: 'departmentsTree',
                initial: true
            },
            {
                title: 'Ціна',
                field: 'items.price',
                operators: ['gt', 'gte', 'lt', 'lte', 'eq', 'neq'],
                type: 'text'
            }
        ],
        groupByConfig: [
            { text: 'Тип', value: 'type' },
            { text: 'Модель', value: 'hardware_model' },
            { text: 'Приміщення', value: 'department' },
            { text: 'Власник', value: 'owner' },
        ],
        groupBy: null,

        filters: [],

        chartData: {}
    }),
    methods: {
        reloadData: debounce(async function() {
            let stats = (await axios.get('/api/items/stats', {
                params: {
                    group_by: this.groupBy,
                    filters: this.filters
                }
            })).data;

            this.updateData(stats);
        }, 200),
        updateData(response) {
            let labels = response.map(elem => elem.joined_title);
            let data = response.map(elem => elem['count']);

            this.chartData = {
                labels,
                datasets: [
                    {
                        label: 'Кількість предметів',
                        backgroundColor: '#545c97',
                        data
                    }
                ]
            }
        }
    },
    watch: {
        filters: debounce(function() {
            this.reloadData();
        }, 200)
    },
    created() {
        this.groupBy = this.groupByConfig[0].value;
        this.updateData([]);

        this.$store.dispatch('types/fetch');
        this.$store.dispatch('hardwareModels/fetch');
        this.$store.dispatch('users/fetch');
        this.$store.dispatch('departments/fetch');
    }
};
</script>
