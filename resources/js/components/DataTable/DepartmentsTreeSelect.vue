<template>
    <v-dialog
        v-model="isActive"
        max-width="500"
    >
        <template #activator="{  }">
            <v-text-field
                @click="open()"
                :value="activatorFieldContent"
                :loading="$store.state.departments.loading"
                :disabled="$store.state.departments.loading"
                label="Приміщення"
                readonly
                hide-details
                dense
            />
        </template>

        <v-card>
            <v-card-title>
                Виберіть приміщення
            </v-card-title>
            <v-card-subtitle>
                Клік з клавішею <b>alt</b> - вибір з дочірніми.
            </v-card-subtitle>
            <v-card-text class="px-4">
                <v-text-field
                    class="px-4"
                    v-model="search"
                    label="Пошук"
                    hide-details
                    clearable
                />

                <v-treeview
                    v-model="model"
                    :items="departments"
                    :search="search"
                    selection-type="independent"
                    item-key="id"
                    item-text="title"
                    dense
                >
                    <template #prepend="{ item, open, selected }">
                        <v-simple-checkbox
                            @click="select($event, item.id, selected)"
                            @click.alt="selectChild(item.id, selected, item.children)"
                            :ripple="false"
                            :value="selected"
                            color="primary"
                        />
                    </template>
                </v-treeview>
            </v-card-text>

            <dialog-actions
                @close="close()"
                confirm-text="Оновити"
                :loading="isLoading"
                close-only
            />
        </v-card>
    </v-dialog>
</template>

<script>
import { clone } from 'lodash-es';
import DialogActions from '~/components/DataTable/DialogActions';
import InvoiceFileViewButton from '~/components/Inventory/Invoice/InvoiceFileViewButton';

export default {
    name: 'DepartmentsTreeSelect',
    components: {
        InvoiceFileViewButton,
        DialogActions
    },
    props: {
        value: {
            type: Array,
            default: () => []
        }
    },
    data: () => ({
        isActive: false,
        isLoading: false,
        departments: [],
        search: ''
    }),
    computed: {
        activatorFieldContent() {
            return `Вибрано: ${this.model.length ?? 0}`;
        },
        model: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    methods: {
        open() {
            if(this.departments.length === 0) {
                this.departments = this.generateTree(this.$store.state.departments.departments);
            }

            this.isActive = true;
        },
        close() {
            this.isActive = false;
        },
        select(event, itemId, selected) {
            if(event.altKey) {
                return;
            }

            if(selected) {
                const index = this.model.indexOf(itemId);
                this.model.splice(index, 1);
            }
            else {
                this.model.push(itemId);
            }
        },
        selectChild(itemId, selected, childs) {
            let childsId = [];

            let countChilds = (childs1) => {
                childs1.forEach((child) => {
                    childsId.push(child.id)

                    if(child.children.length > 0) {
                        countChilds(child.children);
                    }
                });
            }
            countChilds(childs);

            let missingInSelected = [];
            childsId.forEach((id) => {
                if(!this.model.includes(id)) {
                    missingInSelected.push(id);
                }
            });

            if(selected) {
                if(missingInSelected.length > 0) {
                    // Select unselected childs
                    missingInSelected.forEach(elem => {
                        this.model.push(elem);
                    });
                }
                else {
                    // Unselect clicked and childs
                    let toUnselect = [...childsId];
                    toUnselect.push(itemId);
                    this.model = this.model.filter(elem => !toUnselect.includes(elem));
                }
            }
            else {
                // Select missing and clicked
                let toSelect = [...missingInSelected];
                toSelect.push(itemId);

                toSelect.forEach(elem => this.model.push(elem));
            }
        },

        generateTree(departmentsList) {
            departmentsList.find(elem => elem.id === 1).parent_id = null;

            let nest = (data, parentId = null) => {
                return data.reduce((result, element) => {
                    if(element.parent_id === parentId) {
                        let copy = clone(element);
                        let children = nest(data, element.id);
                        if(children.length) {
                            copy.children = children;
                        } else {
                            copy.children = [];
                        }
                        result.push(copy);
                    }
                    return result;
                }, []);
            };

            return nest(departmentsList);
        }
    },
    async created() {
        await this.$store.dispatch('departments/fetch');
    }
};
</script>
