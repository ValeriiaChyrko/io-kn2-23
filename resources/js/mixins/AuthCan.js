import Auth from '~/components/modules/Auth';

export default {
    methods: {
        /**
         * Check current user for provided permission.
         *
         * @param {string} permission Permission to check
         */
        can: permission => Auth.can(permission)
    }
};
