<template>
    <div class="text-center">
        <h3 class="mb-4">
            404 Сторінку не знайдено
        </h3>

        <div class="links">
            <router-link :to="{ name: 'dashboard' }">
                Додомцю
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NotFound'
};
</script>
