import store from '~/store';

const Auth = {
    /**
     * Check current user for provided permission.
     *
     * @param {string} permission Permission to check
     */
    can(permission) {
        if(!this.check()) return false;

        const user = store.getters['auth/user'];
        return user.permissions.includes(permission);
    },

    /**
     * Check is user authenticated.
     *
     * @returns {boolean} Is user authenticated.
     */
    check: () => store.getters['auth/check']
};

export default Auth;
