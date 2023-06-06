<template>
    <div class="behind-the-screen">
        <div :id="sheetId">
            <items-qr-code-sheet
                :items="items"
            />
        </div>
    </div>
</template>

<script>
import htmlPrint from '~/shared/html-print';
import ItemsQrCodeSheet from './ItemsQRCodeSheet';

export default {
    name: 'items-qr-code-sheet-printer',
    components: {
        ItemsQrCodeSheet
    },
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        elementUIDToPrint: null
    }),
    computed: {
        sheetId() {
            return `sheet-to-print-${ this.elementUIDToPrint }`;
        }
    },
    methods: {
        renewElementId() {
            this.elementUIDToPrint = Math.floor(Math.random() * 10000000);    //TODO: Refactor
        },
        async print() {
            await htmlPrint(this.sheetId, {
                windowTitle: 'Друк QR кодів для пердметів накладної',
                timeout: 1000,
                name: '_blank',
                specs: [
                    'fullscreen=yes',
                    'titlebar=yes',
                    'scrollbars=yes',
                    'width=1000',
                    'height=1000'
                ],
                styles: [
                    '/css/print.css'
                ]
            });
        }
    },
    created() {
        this.renewElementId();
    }
};
</script>

<style scoped>
.behind-the-screen {
    position: absolute;
    left: -9000px;
    top: -9000px;
}
</style>
