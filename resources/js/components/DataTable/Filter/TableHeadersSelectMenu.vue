<template>
    <v-menu
        :close-on-content-click="false"
        right
    >
        <template #activator="{ on, attrs }">
            <v-btn
                v-on="on"
                v-bind="attrs"
                text
            >
                <v-icon>
                    mdi-format-columns
                </v-icon>
                Колонки
            </v-btn>
        </template>

        <v-card>
            <v-card-text>
                <template v-for="(header, index) in headers">
                    <v-switch
                        v-model="headers[index].disabled"
                        v-if="header.disableable"
                        :key="header.value"
                        :label="header.text"
                        class="mt-3"
                        color="primary"
                        :true-value="false"
                        :false-value="true"
                        hide-details
                        dense
                    />
                </template>
            </v-card-text>
        </v-card>
    </v-menu>
</template>

<script>
export default {
    name: 'TableHeadersSelectMenu',
    props: {
        value: {
            type: Array,
            required: true
        }
    },
    computed: {
        headers: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    }
};
</script>
