<template>
    <v-toolbar :color="isDevelopment ? 'teal': 'white'">
            <span class="hidden-md-and-up">
                <v-app-bar-nav-icon @click="sidebar"></v-app-bar-nav-icon>
            </span>
        <v-toolbar-title class="d-flex align-content-center">
            <v-list-item-icon class="mr-0">
                <img class="my-1" src="/img/logo.svg" alt="Інвентаризація Острозька академія" width="50px">
            </v-list-item-icon>
            <v-list-item-title>
                <router-link :to="{ name: 'dashboard' }" style="cursor: pointer" v-slot="{ navigate }" custom>
                    <span @click="navigate" role="link" class="text-h5">{{ appName }}</span>
                </router-link>
            </v-list-item-title>
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-toolbar-items class="d-none d-md-flex">
            <v-btn
                text
                v-for="item in menuItems"
                :key="item.title"
                :to="item.path">
                <v-icon left dark>{{ item.icon }}</v-icon>
                {{ item.title }}
            </v-btn>
            <v-menu v-if="settingsMenuItems.length > 0" offset-y>
                <template #activator="{ on, attrs }" >
                    <v-btn
                        text
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon right dark>mdi-cog</v-icon><v-icon right dark>mdi-menu-down</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item
                        v-for="item in settingsMenuItems"
                        :key="item.title"
                        :to="item.path"
                    >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-menu offset-y v-if="user">
                <template #activator="{ on, attrs }" >
                    <v-list-item
                        text
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-list-item-avatar>
                            <v-img :src="user.avatar"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content class="hidden-md-and-down d-lg-block">
                            <v-list-item-title class="text-subtitle-1">
                                {{ user.name }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{ user.email }}
                                <v-chip
                                    color="green"
                                    text-color="white"
                                    label
                                    x-small
                                >
                                    {{ user.role.name }}
                                </v-chip>
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
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
                <v-btn text>
                    <router-link :to="{ name: 'login' }">
                        Залогінся
                    </router-link> <!-- TODO: Check how it's look -->
                </v-btn>
            </template>
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
import { mapGetters } from 'vuex';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import * as NavigationMenu from '~/components/navigation';

export default {
    name: 'AppToolbar',
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
        appName()  {
            return this.isDevelopment ? 'DEV.IO' : window.config.appName
        },
        isDevelopment() {
            return process.env.NODE_ENV === 'development';
        },
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
            await this.$router.push({ name: 'login' });
        },
        sidebar(){
            EventBus.$emit(EventTypes.OPEN_DRAWER);
        }
    }
};

</script>
