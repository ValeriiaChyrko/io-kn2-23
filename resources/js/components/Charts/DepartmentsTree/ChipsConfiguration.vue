<template>
    <v-menu
        :close-on-content-click="false"
        offset-y
        left
    >
        <template #activator="{ on, attrs }">
            <v-btn
                v-on="on"
                v-bind="attrs"
                icon
            >
                <v-icon>
                    mdi-dots-vertical
                </v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-text>
                <v-switch
                    v-model="activeChips"
                    v-for="variant in variants"
                    :key="variant.value"
                    :color="variant.color"
                    :label="variant.label"
                    :value="variant.value"
                    hide-details
                    dense
                />
            </v-card-text>
        </v-card>
    </v-menu>
</template>

<script>
export default {
    name: 'ChipsConfiguration',
    props: {
        value: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        variants: [
            {
                color: 'green',
                label: 'Кількість разом з дочірніми',
                value: 'withNested'
            },
            {
                color: 'teal',
                label: 'Кількість лише в дочірніх',
                value: 'onlyNested'
            },
            {
                color: 'indigo',
                label: 'Кількість в приміщені',
                value: 'withoutNested'
            },
            {
                color: 'deep-purple',
                label: 'Кількість дочірніх приміщень',
                value: 'childrenCount'
            },
        ]
    }),
    computed: {
        activeChips: {
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
