<template>
    <div>
        <div class="top-right links">
            <template v-if="authenticated">
                <router-link :to="{ name: 'dashboard' }">
                    Додомцю
                </router-link>
            </template>
            <template v-else>
                <router-link :to="{ name: 'login' }">
                    Вхід :0
                </router-link>
            </template>
        </div>

        <div class="text-center">
            <div class="title mb-4">
                {{ title }}
            </div>

            <div class="links">
                <a href="https://github.com/cretueusebiu/laravel-vue-spa">github.com/cretueusebiu/laravel-vue-spa</a>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    layout: 'basic',

    metaInfo() {
        return { title: "Хоумпейдж" };
    },

    data: () => ({
        title: window.config.appName
    }),

    computed: mapGetters({
        authenticated: 'auth/check'
    })
};
</script>

<style scoped>
.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.title {
    font-size: 85px;
}
</style>
