<template>
    <v-card>
        <v-card-text>
            <div class="d-flex align-center mr-4">
                <filter-field-add-menu
                    :selected.sync="selected"
                    :configs="configs"
                />
                <slot name="header-append"/>
            </div>

            <v-list v-if="selected.length">
                <v-list-item v-for="(filter, index) in selected" :key="index">
                    <v-list-item-content>
                        <v-row>
                            <v-col>
                                <filter-operator-select
                                    v-model="selected[index].operator"
                                    :operators="filter.operators"
                                />
                            </v-col>
                            <v-col>
                                <filter-value-input
                                    v-model="selected[index].value"
                                    :label="filter.title"
                                    :type="filter.type"
                                />
                            </v-col>
                        </v-row>
                    </v-list-item-content>
                    <v-list-item-action>
                        <v-btn
                            @click="removeFromSelected(index)"
                            icon
                        >
                            <v-icon>
                                mdi-close
                            </v-icon>
                        </v-btn>
                    </v-list-item-action>
                </v-list-item>
            </v-list>
        </v-card-text>
    </v-card>
</template>

<script>
import { cloneDeep, isArray } from 'lodash-es';
import FilterFieldAddMenu from '~/components/DataTable/Filter/FilterFieldAddMenu';
import FilterOperatorSelect from '~/components/DataTable/Filter/FilterOperatorSelect';
import FilterValueInput from '~/components/DataTable/Filter/FilterValueInput';

export default {
    name: 'FilterForm',
    components: {
        FilterValueInput,
        FilterOperatorSelect,
        FilterFieldAddMenu
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
    data: () => ({
        selected: [],
        previousEmitValue: []
    }),
    computed: {
        completedConfigs() {
            return this.selected
            .filter(conf => {
                if(isArray(conf.value)) {
                    return conf.operator && conf.value.length > 0;
                }
                return conf.operator && conf.value;
            }).map(elem => ({
                field: elem.field,
                operator: elem.operator,
                value: elem.value
            }));
        }
    },
    methods: {
        removeFromSelected(index) {
            this.selected.splice(index, 1);
        },
        compareIsFiltersChanged(newArr, oldArr) {
            if(newArr.length !== oldArr.length) {
                return true;
            }
            if(newArr.length === 0 && oldArr.length === 0) {
                return false;
            }

            let i = 0, l = newArr.length;
            for(; i < l; i++) {
                if(newArr[i].field !== oldArr[i].field
                    || newArr[i].operator !== oldArr[i].operator
                    || newArr[i].value !== oldArr[i].value
                ) {
                    return true;
                }
            }

            return false;
        }
    },
    watch: {
        completedConfigs(newValue, oldValue) {
            if(this.compareIsFiltersChanged(newValue, oldValue)) {
                this.$emit('input', newValue);
            }
        }
    },
    created() {
        this.configs.forEach(config => {
            if(config.initial) {
                this.selected.push(cloneDeep(config));
            }
        });
    }
};
</script>
