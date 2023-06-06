<template>
    <div>
        <div v-if="isLoading" class="text-center">
            <v-progress-circular
                :size="50"
                color="primary"
                indeterminate
            />
        </div>
        <template v-else>
            <template v-if="showItemsTable">
                <h5>Предмети</h5>
                <v-data-table
                    :headers="itemsHeaders"
                    :items="items"
                    :items-per-page="10"
                    class="elevation-2 mb-3"
                />
            </template>
        </template>
    </div>
</template>

<script>
import { EventBus, EventTypes } from '../../modules/EventBus';

export default {
    name: 'WriteoffFullData',
    props: {
        writeoffId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            writeoff: {},
            items: [],

            isLoadingWriteoff: false,
            isLoadingItems: false,

            itemsHeaders: [
                { text: 'id', align: 'start', value: 'id' },
                { text: 'Інвентарний номер', value: 'inventory_number' },
                { text: 'Тип', value: 'type_title' },
                { text: 'Модель', value: 'hardware_model_title' },
                { text: 'Власник', value: 'owner_name' },
                { text: 'Приміщення', value: 'department_title' },
                { text: 'Причина', value: 'writeoff_description' }
            ]
        };
    },
    computed: {
        isLoading() {
            return this.isLoadingWriteoff || this.isLoadingItems;
        },
        showItemsTable() {
            return this.items.length > 0;
        }
    },
    methods: {
        fetch() {
            this.loadWriteoff();
            this.loadItems();
        },
        async loadWriteoff() {
            this.isLoadingWriteoff = true;

            await new Promise(resolve => setTimeout(resolve, 1000));

            this.writeoff = {
                id: 1,
                number: 77471,
                date: '2021-12-14T00:00:00.000000Z',
                user_id: 1,
                user_name: 'Анатолій Павлович Мініч',
                confirmed: true,
                created_at: '2021-11-14T00:00:00.000000Z'
            };
            this.isLoadingWriteoff = false;
        },
        async loadItems() {
            this.isLoadingItems = true;
            await new Promise(resolve => setTimeout(resolve, 1000));
            this.items = [
                {
                    id: 1,
                    inventory_number: "2123345345435",
                    type_title: "Сервер",
                    hardware_model_title: "HIKVISION DS-2CD2183GO-IS",
                    owner_name: "ІТЦ ТЗН",
                    department_title: "Новоакадемічний корпус",
                    writeoff_description: 'Згоріло'
                },
                {
                    id: 2,
                    inventory_number: "5453564",
                    type_title: "ПК",
                    hardware_model_title: "Canon MF641cw",
                    owner_name: "ІТЦ ТЗН",
                    department_title: "Острозька академія",
                    writeoff_description: 'Згоріло'
                },
                {
                    id: 3,
                    inventory_number: "123132",
                    type_title: "ПК",
                    hardware_model_title: "Logitech C922 ProStream",
                    owner_name: "Олег Серко",
                    department_title: "Новоакадемічний корпус",
                    writeoff_description: 'Застаріло'
                }
            ];
            this.isLoadingItems = false;
        }

        // async loadWriteoff() {
        //     this.isLoadingWriteoff = true;
        //     this.writeoff = (await axios.get(`/api/writeoffs/${ this.writeoffId }`)).data;
        //     this.isLoadingWriteoff = false;
        // },
        // async loadItems() {
        //     this.isLoadingItems = true;
        //     this.items = (await axios.get(`/api/writeoffs/${ this.writeoffId }/items`)).data;
        //     this.isLoadingItems = false;
        // }
    },
    created() {
        this.fetch();

        EventBus.$on(EventTypes.RELOAD_WRITEOFF_FULL_DATA, writeoffId => {
            if(this.writeoffId === writeoffId) {
                this.fetch();
            }
        });
    }
};
</script>
