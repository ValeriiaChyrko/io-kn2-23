<template>
    <div>
        <v-skeleton-loader
            v-if="isLoading"
            class="mx-auto"
            type="table"
        />
        <template v-else>
            <template v-if="showItemsTable">
                <h5>Обладнання</h5>
                <v-data-table
                    :headers="itemsHeaders"
                    :items="parts"
                    :items-per-page="10"
                    class="elevation-2"
                />
            </template>

            <template v-if="showLicensesTable">
                <h5 class="mt-4">Ліцензії</h5>
                <v-data-table
                    :headers="licensesHeaders"
                    :items="licenses"
                    :items-per-page="10"
                    class="elevation-2"
                />
            </template>
        </template>
    </div>
</template>

<script>
export default {
    name: 'ItemPartsAndLicensesTables',
    props: {
        itemId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            parts: [],
            licenses: [],

            isLoadingParts: false,
            isLoadingLicenses: false,

            itemsHeaders: [
                { text: 'id', align: 'start', value: 'id' },
                { text: 'Тип', value: 'type_title' },
                { text: 'Модель', value: 'hardware_model_title' },
                { text: 'Власник', value: 'owner_name' }
            ],
            licensesHeaders: [
                { text: 'id', align: 'start', value: 'id' },
                { text: 'Назва', value: 'software_model_title' },
                { text: 'Предмет', value: 'item_inventory_number' },
                { text: 'Власник', value: 'owner_name' }
            ]
        };
    },
    computed: {
        isLoading() {
            return this.isLoadingParts || this.isLoadingLicenses
        },
        showItemsTable() {
            return this.parts.length > 0;
        },
        showLicensesTable() {
            return this.licenses.length > 0;
        }
    },
    methods: {
        async loadParts() {
            this.isLoadingParts = true;
            this.parts = (await axios.get(`/api/items/${ this.itemId }/parts`)).data;
            this.isLoadingParts = false;
        },
        async loadLicenses() {
            this.isLoadingLicenses = true;
            this.licenses = (await axios.get(`/api/items/${ this.itemId }/licenses`)).data;
            this.isLoadingLicenses = false;
        }
    },
    created() {
        this.loadParts();
        this.loadLicenses();
    }
};
</script>
