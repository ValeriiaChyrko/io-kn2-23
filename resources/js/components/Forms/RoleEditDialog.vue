<template>
    <v-dialog
        v-model="isActive"
        max-width="750px"
    >
        <template #activator="{ on, attrs }">
            <v-btn
                @click="open()"
                icon
            >
                <v-icon>
                    mdi-pencil
                </v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-text v-if="isLoading">
                <v-skeleton-loader
                    class="mx-auto"
                    type="card-heading, paragraph, actions"
                />
            </v-card-text>
            <template v-else>
                <v-card-title>
                <span
                    class="text-h5"
                >
                    Роль {{ role.name }}
                </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-switch
                            v-model="rolePermissions"
                            v-for="permission in allPermissions"
                            :key="permission.name"
                            :label="permission.name"
                            :value="permission.id"
                            hide-details
                            dense
                        />
                    </v-container>
                </v-card-text>

                <dialog-actions
                    @cancel="close()"
                    @confirm="update()"
                    :loading="isLoading"
                />
            </template>
        </v-card>
    </v-dialog>
</template>

<script>
import DialogActions from '~/components/DataTable/DialogActions';
import Snackbar from '~/components/modules/Snackbar';

export default {
    name: 'RoleEditDialog',
    components: {
        DialogActions
    },
    props: {
        roleId: {
            type: Number,
            required: true
        }
    },
    data: () => ({
        isActive: false,
        isLoading: false,
        isLoadingPermissions: false,

        role: {},
        rolePermissions: [],

        allPermissions: []
    }),
    methods: {
        open() {
            this.isActive = true;

            this.loadRole();
            this.loadPermissions();
        },
        close() {
            this.isActive = false;
        },

        async loadRole() {
            this.isLoading = true;

            this.role = (await axios.get(`/api/roles/${ this.roleId }`)).data;
            this.rolePermissions = this.role.permissions.map(permission => permission.id);

            this.isLoading = false;
        },
        async loadPermissions() {
            this.isLoadingPermissions = true;

            this.allPermissions = (await axios.get('/api/permissions', {
                params: {
                    perPage: -1
                }
            })).data.data;

            this.isLoadingPermissions = false;
        },

        update() {
            this.isLoading = true;

            axios.patch(`/api/roles/${this.roleId}`, {
                permissions: this.rolePermissions
            });

            Snackbar.success("Зміни збережено.");

            this.isLoading = false;
            this.close();
        }
    }
};
</script>
