<template>
    <v-footer
        app
        absolute
        padless
    >
        <v-card
            class="app-footer text-center"
            color="#343a40"
            flat
            tile
            width="100%"
        >
            <v-card-text class="mt-4">
                Інвентаризація ОА
            </v-card-text>

            <v-divider></v-divider>

            <v-card-text>
                © 2020 - {{ new Date().getFullYear() }}
            </v-card-text>
        </v-card>
    </v-footer>
</template>

<script>
export default {
    name: 'AppFooter'
};
</script>

<style scoped>
.app-footer * {
    color: #6c757d!important;
}
</style>
