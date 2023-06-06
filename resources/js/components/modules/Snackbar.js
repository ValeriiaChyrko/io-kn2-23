import { EventBus, EventTypes } from '~/components/modules/EventBus';

const Snackbar = {
    /**
     * Activate snackbar with selected message and color.
     *
     * @param {string} message Message to show
     * @param {string} color Snackbar color
     */
    show(message, color) {
        EventBus.$emit(EventTypes.SNACKBAR_SHOW, {
            message: message,
            color: color
        });
    },

    /**
     * Activate snackbar with selected message and color "error".
     *
     * @param {string} message Message to show
     */
    error(message) {
        this.show(message, 'error');
    },

    /**
     * Activate snackbar with selected message and color "success".
     *
     * @param {string} message Message to show
     */
    success(message) {
        this.show(message, 'success');
    },

    /**
     * Activate snackbar with selected message and color "warning".
     *
     * @param {string} message Message to show
     */
    warn(message) {
        this.show(message, 'warning');
    }
};

export default Snackbar;
