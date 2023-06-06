<template>
    <v-card>
        <v-toolbar
            color="indigo"
            dense
            dark
        >
            <v-toolbar-title>Статистика приміщень</v-toolbar-title>
            <v-spacer/>
            <v-btn @click="reload()" icon>
                <v-icon>
                    mdi-refresh
                </v-icon>
            </v-btn>
            <chips-configuration
                v-model="activeChips"
            />
        </v-toolbar>

        <v-row
            class="pa-4"
            justify="space-between"
        >
            <v-col cols="4" class="departments-tree">
                <v-skeleton-loader
                    v-show="isLoading"
                    class="mx-auto"
                    type="list-item@7"
                />
                <v-treeview
                    v-show="!isLoading"
                    :active.sync="active"
                    :items="departments"
                    activatable
                    transition
                    dense
                    hoverable
                    item-key="id"
                    item-text="title"
                >
                    <template #label="{ item: department }">
                        <departments-tree-node
                            :active-chips="activeChips"
                            :department="department"
                        />
                    </template>
                </v-treeview>
            </v-col>

            <v-divider vertical/>

            <v-col cols="8">
                <department-info
                    :department="selected"
                />
            </v-col>
        </v-row>
    </v-card>
</template>

<script>

// TODO: Fixed minimal height
import { clone } from 'lodash-es';
import ChipsConfiguration from '~/components/Charts/DepartmentsTree/ChipsConfiguration';
import DepartmentInfo from '~/components/Charts/DepartmentsTree/DepartmentInfo';
import DepartmentsTreeNode from '~/components/Charts/DepartmentsTree/DepartmentsTreeNode';
import TooltippedText from '~/components/Inventory/Invoice/TooltippedText';

export default {
    name: 'DepartmentsTree',
    components: {
        DepartmentInfo,
        ChipsConfiguration,
        DepartmentsTreeNode,
        TooltippedText
    },
    data: () => ({
        isLoading: false,

        departments: [],
        activeChips: ['withNested', 'childrenCount'],
        active: []
    }),
    computed: {
        selected() {
            if (!this.active.length) {
                return null;
            }

            let findDepartment = (element, id) => {
                if(element.id === id) {
                    return element;
                }
                else if(element.children) {
                    let result = null;
                    for(let i = 0; result == null && i < element.children.length; i++) {
                        result = findDepartment(element.children[i], id);
                    }

                    return result;
                }
            };

            return findDepartment(this.departments[0], this.active[0]);
        }
    },
    methods: {
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
        },

        generateNestedItemsCount(departmentsTree) {
            let setNestedCount = (department) => {
                let childSum = 0;
                department.children.forEach((child) => {
                    if(!child.nested_items_count) {
                        setNestedCount(child);
                    }
                    childSum += child.items_count + child.nested_items_count;
                });

                department.nested_items_count = childSum;
            };
            departmentsTree.forEach(rootTreeDepartment => setNestedCount(rootTreeDepartment));

            return departmentsTree;
        },

        async reload() {
            this.isLoading = true;

            let departments = (await axios.get('/api/departments', {
                params: {
                    perPage: -1
                }
            })).data.data;

            departments = this.generateTree(departments);
            this.departments = this.generateNestedItemsCount(departments);

            this.isLoading = false;
        }
    },
    created() {
        this.reload();
    }
};
</script>

<style scoped>
.departments-tree {
    overflow-y: scroll;
    height: 85vh;
}
</style>
