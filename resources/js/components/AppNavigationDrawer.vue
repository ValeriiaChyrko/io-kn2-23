<template>
    <v-navigation-drawer
        v-model="sidebar"
        absolute
        temporary
        app
    >
        <v-menu offset-y v-if="user">
            <template v-slot:activator="{ on, attrs }">
                <v-list>
                    <v-list-item>
                        <v-list-item-avatar>
                            <v-img :src="user.avatar"></v-img>
                        </v-list-item-avatar>
                        <v-chip
                            color="green"
                            text-color="white"
                            label
                            small
                        >
                            {{ user.role.name }}
                        </v-chip>
                    </v-list-item>
                    <v-list-item
                        link
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-list-item-content>
                            <v-list-item-title class="text-subtitle-1">
                                {{ user.name }}
                            </v-list-item-title>
                            <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
                        </v-list-item-content>

                        <v-list-item-action>
                            <v-icon>mdi-menu-down</v-icon>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </template>
            <v-list>
                <v-list-item
                    v-for="item in profileMenuItems"
                    :key="item.title"
                    :to="item.path"
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
                <v-list-item @click="logout"
                >
                    <v-list-item-icon>
                        <v-icon>
                            mdi-logout
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Вийти</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>

        <!-- Guest -->
        <template v-else>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon>
                        mdi-login
                    </v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    <router-link :to="{ name: 'login' }">
                        Залогінитись
                    </router-link>
                </v-list-item-title>
            </v-list-item>
        </template>

        <v-divider></v-divider>

        <v-list>
            <v-list-item-group
                v-model="group"
                color="primary"
            >
                <v-list-item
                    v-for="item in menuItems"
                    :key="item.title"
                    :to="item.path"
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list-item-group>
        </v-list>

        <v-divider v-if="settingsMenuItems.length > 0 && menuItems.length > 0"/>

        <v-list v-if="settingsMenuItems.length > 0">
            <v-list-group
                prepend-icon="mdi-cog"
                no-action
            >
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title>Налаштування</v-list-item-title>
                    </v-list-item-content>
                </template>
                <v-list-item
                    v-for="item in settingsMenuItems"
                    :key="item.title"
                    :to="item.path"
                >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                </v-list-item>
            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import { mapGetters } from 'vuex';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import * as NavigationMenu from '~/components/navigation';

export default {
    name: 'AppNavbar',
    data: () => ({
        appName: window.config.appName,
        sidebar: false,
        group: null
    }),

    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        menuItems() {
            return NavigationMenu.menuItems.filter(elem => elem.permission && this.can(elem.permission));
        },
        profileMenuItems() {
            return NavigationMenu.profileMenuItems.filter(elem => elem.permission && this.can(elem.permission));
        },
        settingsMenuItems() {
            return NavigationMenu.settingsMenuItems.filter(elem => elem.permission && this.can(elem.permission));
        }
    },

    methods: {
        async logout() {
            // Log out the user.
            await this.$store.dispatch('auth/logout');

            // Redirect to login.
            this.$router.push({ name: 'login' });
        }
    },
    created() {
        EventBus.$on(EventTypes.OPEN_DRAWER, () => {
            this.sidebar = true;
        });
    }
};

</script>
