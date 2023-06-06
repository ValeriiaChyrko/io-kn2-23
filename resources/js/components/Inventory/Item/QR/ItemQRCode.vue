<template>
    <div>
        <qrcode-vue
            :value="qrValue"
            :size="size"
            level="H"
            render-as="svg"
        />
    </div>
</template>

<script>
import QrcodeVue from 'qrcode.vue';

export default {
    name: 'item-qr-code',
    components: {
        QrcodeVue
    },
    props: {
        item: {
            type: Object,
            required: true
        },
        size: {
            type: Number,
            default: 100
        }
    },
    computed: {
        qrValue: function() {
            return `${ this.item.type_title } ${ this.item.hardware_model_title }\n${ this.item.inventory_number ?? '' }\n${ document.location.origin }/qr/items/${ this.item.id }`;
        }
    }
};
</script>
