import Auth from '~/components/modules/Auth';
import Snackbar from '~/components/modules/Snackbar';

/**
 * This is middleware to check for user permission.
 */
export default (to, from, next, permission) => {
    if(!Auth.can(permission)) {
        Snackbar.warn('Недостанньо прав для перегляду');
        next('/');
    }

    next();
}
