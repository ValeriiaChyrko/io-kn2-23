<template>
    <div class="main-layout">
        <app-navigation-drawer/>
        <app-toolbar/>

        <v-main class="app-main">
            <div class="text-h4 px-6 mt-5 mb-2">{{ $store.state.route.meta.title }}</div>

            <v-container
                class="pa-6 white elevation-3"
                fluid
            >
                <child ref="child"/>
            </v-container>
        </v-main>

        <app-footer/>
    </div>
</template>

<script>
import AppFooter from '~/components/AppFooter';
import AppToolbar from '~/components/AppToolbar';
import AppNavigationDrawer from '~/components/AppNavigationDrawer';

export default {
    name: 'MainLayout',

    components: {
        AppNavigationDrawer,
        AppToolbar,
        AppFooter,
    }
};
</script>

<style scoped>
.main-layout {
    background: #f8f9fa;
    min-height: 100vh;
}
</style>
