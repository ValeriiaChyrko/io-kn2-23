<template>
    <v-tabs
        color="primary accent-4"
        right
    >
        <v-tab>Дочірні</v-tab>
        <v-tab>Ремонти</v-tab>

        <v-tab-item>
            <v-container fluid>
                <item-parts-and-licenses-tables
                    :item-id="itemId"
                />
            </v-container>
        </v-tab-item>
        <v-tab-item>
            <v-container fluid>
                <item-repairs-table
                    :item-id="itemId"
                />
            </v-container>
        </v-tab-item>
    </v-tabs>
</template>

<script>
import ItemRepairsTable from './ItemRepairsTable';
import ItemPartsAndLicensesTables from './QR/ItemPartsAndLicensesTables';

export default {
    name: 'ItemFullData',
    components: {
        ItemPartsAndLicensesTables,
        ItemRepairsTable
    },
    props: {
        itemId: {
            type: Number,
            required: true
        }
    }
};
</script>
