import axios from 'axios';
import qs from 'qs';
import Snackbar from '~/components/modules/Snackbar';
import router from '~/router';
import store from '~/store';

window.axios = axios;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.paramsSerializer = params => qs.stringify(params, {encode: false});    // TODO: enable encode

axios.interceptors.response.use(response => response, error => {
    if(axios.isCancel(error)) {
        return Promise.reject(error);
    }

    console.warn(error.response?.data);    //TODO: Refactor
    if(error.response) {
        // Сервер повернув помилку
        let errorText;

        switch(error.response.status) {
            case 422:
                errorText = 'Помилка валідації!';
                break;
            case 401:
                if(store.getters['auth/check']) {
                    console.log('Error 401 and auth/check is true');
                    //TODO: Refresh token
                }

                Snackbar.error('Увійдіть у аккаунт щоб продовжити');
                setTimeout(() => {
                    store.commit('auth/logout');

                    router.push({ name: 'login' });
                }, 3000);

                return Promise.reject(error);
            default:
                errorText = 'Помилка ' + error.response.status;
                break;
        }
        Snackbar.error(errorText);
    } else if(error.request) {
        // Сервер не повернув нічого
        Snackbar.error('Не вдалось підключитися до сервера');
    } else {
        Snackbar.error('Сталася помилка при створенні запиту');
    }

    return Promise.reject(error);
});
