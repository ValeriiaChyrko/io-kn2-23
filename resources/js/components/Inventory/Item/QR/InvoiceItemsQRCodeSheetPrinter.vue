<template>
        <span>
            <items-qr-code-sheet-printer
                :items="items"
                ref="sheet"
            />
            <v-tooltip top>
                <template #activator="{ on, attrs }">
                    <v-btn
                        icon
                        @click="print()"
                        :loading="isLoading"
                    >
                        <v-icon
                            v-bind="attrs"
                            v-on="on"
                            dense
                        >
                            mdi-qrcode
                        </v-icon>
                    </v-btn>
                </template>
                <span>Друкувати QR коди</span>
            </v-tooltip>
        </span>
</template>

<script>
import ItemsQrCodeSheetPrinter from './ItemsQRCodeSheetPrinter';

export default {
    name: 'invoice-items-qr-code-sheet-printer',
    components: {
        ItemsQrCodeSheetPrinter
    },
    props: {
        invoiceId: {
            type: Number,
            required: true
        }
    },
    data: () => ({
        isLoading: false,
        items: []
    }),
    methods: {
        async print() {
            await this.fetch();

            await this.$refs.sheet.print();
        },
        async fetch() {
            this.isLoading = true;

            let items = (await axios.get(`/api/invoices/${ this.invoiceId }/items`)).data;
            this.items = items.filter(item => item.inventory_number)

            this.isLoading = false;
        }
    }
};
</script>
