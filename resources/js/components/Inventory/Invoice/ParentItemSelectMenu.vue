<template>
    <v-menu
        v-model="isActiveMenu"
        @keydown.esc="cancel()"
        @keydown.enter="save()"
        :close-on-content-click="false"
        :nudge-width="450"
        ref="menu"
        offset-x
    >
        <template #activator="{ on: onMenu }">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <v-badge
                        :color="badgeColor"
                        :value="isBadgeVisible"
                        dot
                        overlap
                    >
                        <v-btn
                            icon
                            v-on="onTooltip"
                            @click="openMenu()"
                            :disabled="disabled"
                        >
                            <v-icon
                                medium
                            >
                                mdi-memory
                            </v-icon>
                        </v-btn>
                    </v-badge>
                </template>
                <span>Деталь до</span>
            </v-tooltip>
        </template>

        <v-card>
            <v-card-title>Батьківстький предмет</v-card-title>
            <v-card-subtitle
                class="pb-3"
            >
                Після вибору у предмета зміниться приміщення та власник
            </v-card-subtitle>

            <v-container
                class="py-0"
            >
                <template v-if="selectedParent">
                    <v-icon x-small>mdi-home</v-icon>
                    {{ selectedParent.department_title }}<br>

                    {{ selectedParent.type_title }}
                    &nbsp;-&nbsp;
                    <span class="text--secondary">{{ selectedParent.hardware_model_title }}</span>
                </template>

                <item-autocomplete-with-info
                    v-model="selectedParentId"
                    :items="items"
                    label="Батьківстький предмет"
                />
            </v-container>

            <dialog-actions
                @cancel="cancel()"
                @confirm="save()"
            />
        </v-card>
    </v-menu>
</template>

<script>
import DialogActions from '../../DataTable/DialogActions';
import ItemAutocompleteWithInfo from '../../DataTable/ItemAutocompleteWithInfo';

export default {
    name: 'ParentItemSelectMenu',
    components: {
        ItemAutocompleteWithInfo,
        DialogActions
    },
    props: {
        value: {},

        // Those two props are not used in component code.
        // They exist only for IDE for hinting when using them with .sync prop modifier
        owner: {
            type: Number
        },
        department: {
            type: Number
        },

        disabled: {
            type: Boolean,
            default: false
        },

        items: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        isActiveMenu: false,

        selectedParentId: null
    }),
    computed: {
        isBadgeVisible() {
            return !!this.model;
        },
        badgeColor() {
            return this.disabled ? 'grey' : 'red';
        },

        selectedParent() {
            return this.items.find(item => item.id === this.selectedParentId) ?? null;
        },

        model: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        }
    },
    methods: {
        openMenu() {
            this.isActiveMenu = true;

            this.selectedParentId = this.model ? this.model : null;
        },

        save() {
            this.isActiveMenu = false;

            if(this.selectedParent) {
                this.model = this.selectedParentId;
                this.$emit('update:department', this.selectedParent.department_id);
                this.$emit('update:owner', this.selectedParent.owner_id);
            }
            else {
                this.model = null;
            }
        },
        cancel() {
            this.isActiveMenu = false;
        }
    },
    watch: {
        model() {
            this.$refs.menu.updateDimensions();
        },
        selectedParentId() {
            this.$refs.menu.updateDimensions();
        }
    }
};
</script>
