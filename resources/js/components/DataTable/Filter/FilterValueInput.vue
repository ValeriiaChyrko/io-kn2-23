<template>
    <type-multiple-autocomplete
        v-if="type === 'types'"
        v-model="model"
        :label="label"
    />

    <hardware-model-multiple-autocomplete
        v-else-if="type === 'hardwareModels'"
        v-model="model"
        :label="label"
    />

    <department-multiple-autocomplete
        v-else-if="type === 'departments'"
        v-model="model"
        :label="label"
    />

    <departments-tree-select
        v-else-if="type === 'departmentsTree'"
        v-model="model"
        :label="label"
    />

    <user-multiple-autocomplete
        v-else-if="type === 'users'"
        v-model="model"
        :label="label"
    />

    <v-text-field
        v-else-if="type === 'text'"
        v-model="model"
        :label="label"
        hide-details
        dense
    />
</template>

<script>
import DepartmentsTreeSelect from '~/components/DataTable/DepartmentsTreeSelect';
import DepartmentMultipleAutocomplete from '~/components/Inputs/DepartmentMultipleAutocomplete';
import HardwareModelMultipleAutocomplete from '~/components/Inputs/HardwareModelMultipleAutocomplete';
import TypeMultipleAutocomplete from '~/components/Inputs/TypeMultipleAutocomplete';
import UserMultipleAutocomplete from '~/components/Inputs/UserMultipleAutocomplete';

export default {
    name: 'FilterValueInput',
    components: {
        DepartmentsTreeSelect,
        UserMultipleAutocomplete,
        DepartmentMultipleAutocomplete,
        HardwareModelMultipleAutocomplete,
        TypeMultipleAutocomplete
    },
    props: {
        value: {
            required: true
        },
        label: {
            type: String,
            default: ''
        },
        /**
         * Type of the input
         * @values types, hardwareModels, users, departments, departmentsTree
         */
        type: {
            type: String,
            default: 'text',
            validator(value) {
                return ['types', 'hardwareModels', 'users', 'departments', 'departmentsTree', 'text'].indexOf(value) !== -1;
            }
        }
    },
    computed: {
        model: {
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
