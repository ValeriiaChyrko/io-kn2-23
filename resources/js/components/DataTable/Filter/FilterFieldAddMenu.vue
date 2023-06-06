<template>
    <v-menu
        bottom
        close-on-click
    >
        <template #activator="{ on, attrs }">
            <v-btn
                :disabled="!unselectedConfigs.length"
                v-bind="attrs"
                v-on="on"
                text
            >
                <v-icon>
                    mdi-plus
                </v-icon>
                Додати поле
            </v-btn>
        </template>

        <v-list>
            <v-list-item
                v-for="(config, index) in unselectedConfigs"
                :key="index"
                @click="select(config.field)"
            >
                <v-list-item-title>{{ config.title }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script>
import { cloneDeep } from 'lodash-es';

export default {
    name: 'FilterFieldAddMenu',
    props: {
        configs: {
            type: Array,
            required: true
        },
        selected: {
            type: Array,
            required: true
        }
    },
    computed: {
        unselectedConfigs() {    // Return only unselected filter configurations
            return this.configs.filter(filter => !this.internalSelected.some(s => s.field === filter.field));
        },
        internalSelected: {
            get() {
                return this.selected;
            },
            set(val) {
                this.$emit('update:selected', val);
            }
        }
    },
    methods: {
        select(field) {
            this.internalSelected.push(cloneDeep(this.configs.find(conf => conf.field === field)));
        }
    }
};
</script>
