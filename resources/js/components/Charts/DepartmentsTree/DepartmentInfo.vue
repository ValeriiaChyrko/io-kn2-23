<template>
    <v-container fluid>
        <v-scroll-y-transition mode="out-in">
            <div
                v-if="department"
            >
                <template v-if="isLoading">
                    <v-skeleton-loader
                        class="mx-auto"
                        type="card-heading, table"
                    />
                </template>
                <template v-else>
                    <v-card-title>{{ department.title }}</v-card-title>
                    <v-card-subtitle v-if="department.parent_id"><v-icon x-small>mdi-home</v-icon>{{ department.parent_title }}</v-card-subtitle>

                    <v-data-table
                        :items="items"
                        :headers="headers"
                    />
                </template>
            </div>
            <div class="text-h6 grey--text text--lighten-1 font-weight-light" v-else>
                Виберіть приміщення
            </div>
        </v-scroll-y-transition>
    </v-container>
</template>

<script>
export default {
    name: 'DepartmentInfo',
    props: {
        department: {
            type: Object,
            default: null
        }
    },
    data: () => ({
        isLoading: false,
        headers: [
            { text: 'id', align: 'start', value: 'id', width: '100px' },
            { text: 'Номер', value: 'inventory_number' },
            { text: 'Тип', value: 'type_title' },
            { text: 'Модель', value: 'hardware_model_title' },
            { text: 'Накладна', value: 'invoice_number' },
            { text: 'Дата накладної', value: 'invoice_date' },
            { text: 'Власник', value: 'owner_name' },
            { text: 'Приміщення', value: 'department_title' },
            { text: 'Статус', value: 'status_title' },
            { text: 'Ціна', value: 'price' },
        ],
        items: []
    }),
    methods: {
        async reload() {
            this.isLoading = true;
            this.items = [];

            this.items = (await axios.get(`/api/items`, {
                params: {
                    filters: [
                        {
                            field: 'items.department_id',
                            operator: 'eq',
                            value: this.department.id
                        }
                    ],
                    perPage: -1
                }
            })).data.data;

            this.isLoading = false;
        }
    },
    watch: {
        department(newValue) {
            if(newValue) {
                this.reload();
            }
        }
    }
};
</script>
