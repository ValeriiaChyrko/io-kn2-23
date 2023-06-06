<template>
    <table>
        <tbody>
        <tr v-for="rowNumber in rowsCount">
            <td
                v-for="columnNumber in columnsInRow(rowNumber)"
            >
                <item-qr-code
                    :item="itemByRowAndColNumber(rowNumber, columnNumber)"
                    :size="qrcodeSize"
                    class="p-1"
                />

                <div class="text-center">
                    <hr>
                    {{
                        itemByRowAndColNumber(rowNumber, columnNumber).inventory_number
                            ? itemByRowAndColNumber(rowNumber, columnNumber).inventory_number
                            : '_____'
                    }}
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import ItemQrCode from './ItemQRCode';

const SHEET_WIDTH_IN_PX = 793;
//const SHEET_HEIGHT_IN_PX = 1122;

export default {
    name: 'items-qr-code-sheet',
    components: {
        ItemQrCode
    },
    props: {
        items: {
            type: Array,
            required: true
        },
        columnsCount: {
            type: Number,
            default: 6
        }
    },
    computed: {
        itemsCount() {
            return this.items.length;
        },
        rowsCount() {
            return Math.ceil(this.itemsCount / this.columnsCount);
        },
        qrcodeSize() {
            return SHEET_WIDTH_IN_PX / this.columnsCount;
        }
    },
    methods: {
        columnsInRow(rowNumber) {
            if(rowNumber < this.rowsCount) {
                return this.columnsCount;
            }

            //Last table row, rowNumber == this.rowsCount
            return this.itemsCount - (this.columnsCount * (rowNumber - 1));
        },
        itemByRowAndColNumber(rowNumber, colNumber) {
            let itemIndex = (((rowNumber - 1) * this.columnsCount) + colNumber) - 1;

            return this.items[itemIndex];
        }
    }
};
</script>
