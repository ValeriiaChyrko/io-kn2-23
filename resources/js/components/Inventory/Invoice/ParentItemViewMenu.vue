<template>
    <v-menu
        v-model="isActiveMenu"
        @keydown.esc="close()"
        :close-on-content-click="false"
        :min-width="450"
        ref="menu"
        offset-x
    >
        <template #activator="{ on: onMenu }">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <v-badge
                        :value="isExistsItemId"
                        color="red"
                        dot
                        overlap
                    >
                        <span v-on="{ ...onTooltip }">
                            <v-icon
                                v-on="{ ...onMenu }"
                                @click="open()"
                                :disabled="!isExistsItemId"
                                medium
                            >
                                mdi-memory
                            </v-icon>
                        </span>
                    </v-badge>
                </template>
                <span>{{ tooltipText }}</span>
            </v-tooltip>
        </template>

        <v-card>
            <v-card-title>Батьківстький предмет</v-card-title>
            <v-card-subtitle class="pb-3">
                Інформація про предмет
            </v-card-subtitle>

            <v-card-text class="py-0">
                <div v-if="isLoading" class="text-center">
                    <v-progress-circular
                        :size="50"
                        color="primary"
                        indeterminate
                    />
                </div>
                <template v-else>
                    id: {{ item.id }}<br>
                    Інвентарний номер: {{ item.inventory_number }}<br>
                    Приміщення: {{ item.department_title }}<br>
                    Тип: {{ item.type_title }}<br>
                    Модель: {{ item.hardware_model_title }}<br>
                    Матеріально відповідальна особа: {{ item.owner_name }}<br>
                    Статус: {{ item.status_title }}<br>
                    Номер накладної: {{ item.invoice_number }}<br>
                    Створено запис в системі: {{ formatDatetime(item.created_at) }}<br>
                    Остання зміна: {{ formatDatetime(item.updated_at) }}<br>
                </template>
            </v-card-text>

            <dialog-actions
                @close="close"
                close-only
            />
        </v-card>
    </v-menu>
</template>

<script>

import DialogActions from '../../DataTable/DialogActions';
import DateFormatting from '../../mixins/DateFormatting';

export default {
    name: 'ParentItemViewMenu',
    mixins: [
        DateFormatting
    ],
    components: {
        DialogActions
    },
    props: {
        itemId: {
            type: Number
        }
    },
    data: () => ({
        isActiveMenu: false,
        isLoading: false,
        item: {}
    }),
    computed: {
        isExistsItemId() {
            return !!this.itemId;
        },
        tooltipText() {
            return this.isExistsItemId ? 'Переглянути батьківський предмет' : 'Батьківський предмет відсутній';
        }
    },
    methods: {
        open() {
            this.isActiveMenu = true;
            this.loadItemData();
        },
        close() {
            this.isActiveMenu = false;
        },
        async loadItemData() {
            this.isLoading = true;

            this.item = await (await axios.get(`/api/items/${ this.itemId }`)).data;

            this.$refs.menu.updateDimensions();    // Update menu position

            this.isLoading = false;
        }
    }
};
</script>
