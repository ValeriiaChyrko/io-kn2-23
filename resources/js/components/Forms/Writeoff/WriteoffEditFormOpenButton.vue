<template>
    <v-tooltip top>
        <template #activator="{ on: onTooltip }">
            <v-badge
                :value="!confirmed"
                class="data-table-expandable-row-badge"
                color="blue"
                overlap
                dot
            >
                <v-btn
                    icon
                    @click="openForm()"
                >
                    <v-icon
                        v-on="{ ...onTooltip }"
                        dense
                    >
                        mdi-file-edit
                    </v-icon>
                </v-btn>
            </v-badge>
        </template>
        <span>Редагувати списання</span>
    </v-tooltip>
</template>

<script>
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import {OPEN_WRITEOFF_EDIT_FORM} from "~/components/modules/EventBus/event-types";

export default {
    name: 'WriteoffEditFormEditButton',
    props: {
        writeoffId: {
            type: Number,
            required: true
        },
        confirmed: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        openForm() {
            EventBus.$emit(EventTypes.OPEN_WRITEOFF_EDIT_FORM, {
                writeoffId: this.writeoffId
            });
        }
    }
};
</script>
