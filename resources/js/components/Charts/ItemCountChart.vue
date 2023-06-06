<script>
import { Bar, mixins } from 'vue-chartjs';

export default {
    name: 'ItemCountChart',
    mixins: [
        mixins.reactiveProp,
        Bar
    ],
    data: () => ({
        options: {
            scales: {
                yAxes: [
                    {
                        ticks: {
                            min: 0
                        }
                    }
                ]
            },
            responsive: true,
            maintainAspectRatio: false
        }
    }),
    mounted() {
        this.renderChart(this.chartData, this.options);
    }
};
</script>
