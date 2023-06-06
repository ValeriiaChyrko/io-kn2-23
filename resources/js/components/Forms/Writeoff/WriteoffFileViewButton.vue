<template>
    <v-tooltip top>
        <template #activator="{ on, attrs }">
            <v-btn
                @click="openFile()"
                :disabled="disabled"
                icon
            >
                <v-icon
                    v-bind="attrs"
                    v-on="on"
                    dense
                >
                    mdi-file-image
                </v-icon>
            </v-btn>
        </template>
        <span>Переглянути файл</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'WriteoffFileViewButton',
    props: {
        writeoffId: {
            type: Number,
            required: true
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        openFile() {
            window.open(`/api/writeoffs/${ this.writeoffId }/file`, '_blank');
        }
    }
};
</script>
