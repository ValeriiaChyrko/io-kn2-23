<template>
    <v-tooltip top>
            <template #activator="{ on, attrs }">
                <v-btn
                    icon
                    @click="openFile()"
                >
                    <v-icon
                        v-bind="attrs"
                        v-on="on"

                        dense
                    >
                        mdi-eye
                    </v-icon>
                </v-btn>
            </template>
      <span>Переглянути файл</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'TransferFileViewButton',
    props: {
        transferId: {
            type: Number,
            required: true
        }
    },
    methods: {
        openFile() {
            window.open(`/api/transfers/${ this.transferId }/file`, '_blank');
        }
    }
};
</script>
