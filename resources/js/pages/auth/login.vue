<template>
    <div class="login-page d-flex flex-column align-center justify-center text-center">
        <v-img
            alt="Герб Національного університету 'Острозька академія'"
            max-height="150"
            max-width="150"
            src="/img/logo.svg"
        />
        <h1 class="mb-3">Інвентаризація ОА</h1>

        <login-with-google/>

        <p class="text--secondary mt-3">© 2020 - {{ new Date().getFullYear() }}</p>
    </div>
</template>

<script>
import LoginWithGoogle from '~/components/LoginWithGoogle';

export default {
    layout: 'basic',
    middleware: 'guest',
    components: {
        LoginWithGoogle
    },

    metaInfo() {
        return { title: 'Логін' };
    }
};
</script>

<style scoped>
.login-page {
    font-family: "Nunito", sans-serif;
}
</style>
