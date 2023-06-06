<template>
    <v-dialog
        v-model="isActive"
        max-width="80%"
        @keydown.esc="close()"
        @click:outside="close()"
    >
        <template #activator="{ on: onDialog }">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <v-badge
                        :content="partsCount"
                        :value="isHasParts"
                        color="green"
                        overlap
                    >
                        <span v-on="{ ...onTooltip }">
                            <v-btn
                                icon
                                v-on="{ ...onDialog }"
                                @click="open()"
                                :disabled="!isHasParts"
                            >
                                <v-icon
                                    dense
                                >
                                    mdi-file-tree
                                </v-icon>
                            </v-btn>
                        </span>
                    </v-badge>
                </template>
                <span>{{ tooltipText }}</span>
            </v-tooltip>
        </template>

        <v-card>
            <template v-if="!isLoadingItem">
                <v-card-subtitle class="pt-4 pb-0 mb-n2">
                    Деталі обладнання
                </v-card-subtitle>
                <v-card-title class="pt-0">
                    <tooltipped-text
                        :text-activator="item.inventory_number ? item.inventory_number : '???'"
                        tooltip-text="Інвентарний номер"
                    />
                    <span>&nbsp;-&nbsp;</span>
                    <tooltipped-text
                        :text-activator="item.type_title"
                        tooltip-text="Тип обладнання"
                    />
                    ,&nbsp;<tooltipped-text
                    :text-activator="item.hardware_model_title"
                    tooltip-text="Модель обладнання"
                />
                </v-card-title>
                <v-card-subtitle>
                    <v-icon x-small>mdi-home</v-icon>
                    {{ item.department_title }}
                </v-card-subtitle>
            </template>
            <template v-else>
                <v-card-title>Завантаження...</v-card-title>
            </template>
            <v-card-text>
                <item-parts-and-licenses-tables
                    :item-id="itemId"
                />
            </v-card-text>

            <dialog-actions
                @close="close()"
                close-only
            />
        </v-card>
    </v-dialog>
</template>

<script>

import DialogActions from '../../DataTable/DialogActions';
import TooltippedText from '../Invoice/TooltippedText';
import ItemPartsAndLicensesTables from './QR/ItemPartsAndLicensesTables';

export default {
    name: 'ItemPartsViewDialog',
    components: {
        ItemPartsAndLicensesTables,
        DialogActions,
        TooltippedText
    },
    props: {
        itemId: {
            type: Number,
            required: true
        },
        partsCount: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            isActive: false,
            item: {},

            isLoadingItem: false
        };
    },
    methods: {
        open() {
            this.loadItem();

            this.isActive = true;
        },
        close() {
            this.isActive = false;
        },

        async loadItem() {
            this.isLoadingItem = true;
            this.item = (await axios.get(`/api/items/${ this.itemId }`)).data;
            this.isLoadingItem = false;
        }
    },
    computed: {
        isHasParts: function() {
            return this.partsCount > 0;
        },
        tooltipText: function() {
            return this.isHasParts ? 'Переглянути деталі' : 'Деталі відсутні';
        }
    }
};
</script>
