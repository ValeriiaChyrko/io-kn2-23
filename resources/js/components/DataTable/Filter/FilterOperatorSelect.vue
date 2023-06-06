<template>
    <v-select
        v-model="operator"
        :items="selectedOperators"
        label="Оператор"
        item-text="title"
        item-value="code"
        dense
        hide-details
    />
</template>

<script>
export default {
    name: 'FilterOperatorSelect',
    props: {
        value: {
            required: true
        },
        operators: {
            type: Array,
            required: true
        }

    },
    data: () => ({
        allOperators: [
            { code: 'gt', title: '>' },
            { code: 'gte', title: '≥' },
            { code: 'lt', title: '<' },
            { code: 'lte', title: '≤' },
            { code: 'eq', title: '=' },
            { code: 'neq', title: '≠' },
            { code: 'in', title: 'Є в списку' },
            { code: 'nin', title: 'Відсутнє в списку' }
        ]
    }),
    computed: {
        operator: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        },

        selectedOperators() {
            return this.allOperators.filter(op => this.operators.includes(op.code));
        }
    },
    created() {
        this.operator = this.selectedOperators[0].code;
    }
};
</script>
