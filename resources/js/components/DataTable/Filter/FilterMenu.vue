<template>
    <v-menu
        bottom
        close-on-click
        :max-width="750"
        :min-width="500"
        :close-on-content-click="false"
    >
        <template #activator="{ on, attrs }">
            <v-badge
                :value="filters.length"
                :content="filters.length"
                color="indigo"
                bordered
                overlap
            >
                <v-btn
                    v-bind="attrs"
                    v-on="on"
                    text
                >
                    <v-icon>
                        mdi-filter-outline
                    </v-icon>
                    Фільтри
                </v-btn>
            </v-badge>
        </template>

        <filter-form
            v-model="filters"
            :configs="configs"
        />
    </v-menu>
</template>

<script>
import FilterForm from '~/components/DataTable/Filter/FilterForm';

export default {
    name: 'FilterMenu',
    components: {
        FilterForm
    },
    props: {
        value: {
            type: Array,
            required: true
        },
        configs: {
            type: Array,
            required: true
        }
    },
    computed: {
        filters: {
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
