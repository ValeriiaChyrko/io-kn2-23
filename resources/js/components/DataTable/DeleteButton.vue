<template>
    <v-tooltip top>
        <template #activator="{ on }">
            <span v-on="on">
                <v-btn
                    icon
                    v-if="deletable"
                    @click="$emit('delete')"
                >
                    <v-icon
                        dense
                    >
                        mdi-delete
                    </v-icon>
                </v-btn>
                <v-btn
                    icon
                    v-else
                    disabled
                >
                    <v-icon
                        color="grey lighten-1"
                        dense
                    >
                        mdi-delete
                    </v-icon>
                </v-btn>
            </span>
        </template>
        <span>{{ this.tooltipText }}</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'DeleteButton',
    props: {    //TODO: Add delay?
        deletable: {
            type: Boolean,
            default: true
        },
        hintText: {
            type: String,
            default: 'Видалити'
        },
        forbiddenText: {
            type: String,
            default: 'Неможливо видалити'
        }
    },
    computed: {
        tooltipText: function() {
            return this.deletable ? this.hintText : this.forbiddenText;
        }
    }
};
</script>
