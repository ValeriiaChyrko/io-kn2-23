<template>
    <v-btn
        @click="login()"
        color="red"
        class="google-login-button pa-5"
    >
        <v-icon class="mr-2">
            mdi-google
        </v-icon>
        Вхід через пошту @oa.edu.ua
    </v-btn>
</template>

<script>
import Cookies from 'js-cookie';
import Snackbar from '~/components/modules/Snackbar';

export default {
    name: 'LoginWithGoogle',

    methods: {
        async login() {
            await axios.get('/sanctum/csrf-cookie');
            const newWindow = openWindow('', 'Вхід');

            // Retrieving google oauth redirect url and redirecting user to google login page
            newWindow.location.href = await this.$store.dispatch('auth/fetchGoogleOauthUrl');
        },
        async onMessage(e) {
            if(e.origin !== window.origin) {
                return;
            }

            if(e.data.success) {
                await this.$store.dispatch('auth/fetchUser');

                const intendedUrl = Cookies.get('intended_url');

                if(intendedUrl) {
                    Cookies.remove('intended_url');
                    await this.$router.push({ path: intendedUrl });
                } else {
                    await this.$router.push({ name: 'dashboard' });
                }
            } else if(e.data.error) {
                Snackbar.error('Сталася помилка при спробі авторизації.')
            }
        }
    },
    mounted() {
        window.addEventListener('message', this.onMessage, false);
    },
    beforeDestroy() {
        window.removeEventListener('message', this.onMessage);
    }
};

function openWindow(url, title, options = {}) {
    if(typeof url === 'object') {
        options = url;
        url = '';
    }

    options = { url, title, width: 600, height: 720, ...options };

    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left;
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top;
    const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width;
    const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height;

    options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft;
    options.top = ((height / 2) - (options.height / 2)) + dualScreenTop;

    const optionsStr = Object.keys(options).reduce((acc, key) => {
        return `${ acc }${ key }=${ options[key] },`;
    }, '');
    optionsStr.slice(0, -1);    // Removing last comma

    const newWindow = window.open(url, title, optionsStr);

    if(window.focus) {
        newWindow.focus();
    }

    return newWindow;
}
</script>

<style scoped>
.google-login-button {
    font-size: 1.125rem;
    color: white;
    text-transform: none;
}
</style>
