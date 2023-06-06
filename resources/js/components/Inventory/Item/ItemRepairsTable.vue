<template>
    <v-data-table
        :headers="headers"
        :items="repairs"
        :items-per-page="10"
        :loading="isLoading"
        class="elevation-2"
    >
        <template #item.start_date="{ item }">
            {{ formatDate(item.start_date) }}
        </template>
        <template #item.end_date="{ item }">
            <repair-end-date
                :end-date="formatDate(item.end_date)"
                :is-unrepairable="item.is_unrepairable"
            />
        </template>
        <template #item.actions="{ item }">
            <repair-complete-menu
                @completed="repairCompleted()"
                :repair-id="item.id"
                :is-uncompleted="!item.is_completed"
            />
        </template>
    </v-data-table>
</template>

<script>
import DateFormatting from '../../mixins/DateFormatting';
import RepairCompleteMenu from '../Repair/RepairCompleteMenu';
import RepairEndDate from '../Repair/RepairEndDate';
import { EventBus } from '../../modules/EventBus';

export default {
    name: 'ItemRepairsTable',
    components: {
        RepairCompleteMenu,
        RepairEndDate
    },
    mixins: [
        DateFormatting
    ],
    props: {
        itemId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            isLoading: false,
            repairs: [],
            headers: [
                { text: 'id', align: 'start', value: 'id' },
                { text: 'Користувач', value: 'user_name' },
                { text: 'Виконавець', value: 'provider_title' },
                { text: 'Дата початку', value: 'start_date' },
                { text: 'Дата кінця', value: 'end_date' },
                {
                    text: 'Дії', value: 'actions', sortable: false, width: '1%',
                    cellClass: 'text-no-wrap', align: 'center'
                }
            ]
        };
    },
    methods: {
        fetch() {
            this.isLoading = true;

            axios.get(`/api/items/${ this.itemId }/repairs`)
            .then(response => {
                this.repairs = response.data;
            }).finally(() => {
                this.isLoading = false;
            });
        },

        //This method reload current table and send event via Event bus to reload main items table
        repairCompleted() {
            EventBus.$emit('items-table-fetch');
            this.fetch();
        }
    },
    created() {
        this.fetch();

        EventBus.$on('reload-item-repairs', itemId => {
            if(this.itemId === itemId) {
                this.fetch();
            }
        });
    }
};
</script>
