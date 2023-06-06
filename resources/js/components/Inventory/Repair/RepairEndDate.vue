<template>
    <v-tooltip
        v-if="isVisible"
        top
    >
        <template #activator="{ on, attrs }">
            <v-badge
                :color="badgeColor"
                dot
            >
                <span
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ endDate }}
                </span>
            </v-badge>
        </template>

        <span>{{ tooltipText }}</span>
    </v-tooltip>
</template>

<script>
export default {
    name: 'RepairEndDate',    //TODO: Rename?
    props: {
        isUnrepairable: {    //Those props are nullable
            type: Boolean
        },
        endDate: {
            type: String
        }
    },
    computed: {
        badgeColor: function() {
            return this.isUnrepairable ? 'red' : 'green';
        },
        tooltipText: function() {
            return this.isUnrepairable ? 'Невдалий ремонт' : 'Успішний ремонт';    //TODO: Review text
        },
        isVisible: function() {
            return this.isUnrepairable != null;
        }
    }
};
</script>
