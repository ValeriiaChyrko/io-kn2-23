import CreateButton from '~/components/Forms/CreateButton';
import FormValidate from '~/components/mixins/FormValidate';
import Snackbar from '~/components/modules/Snackbar';
import { cloneDeep } from 'lodash-es';
import { EventBus } from '~/components/modules/EventBus';
import { EVENT_STUB } from '~/components/modules/EventBus/event-types';

export default {
    mixins: [
        FormValidate
    ],
    components: {
        CreateButton
    },
    data() {
        return {
            createdEvent: EVENT_STUB,

            newItem: null,
            newItemDefault: {},

            apiCreateEndpoint: null
        };
    },
    methods: {
        create() {    //TODO: Add loading
            this.$refs.createFormObserver.validate().then(result => {
                if(!result) {
                    return;
                }

                axios.post(this.apiCreateEndpoint, this.newItem)
                .then(() => {
                    Snackbar.success('Створено');

                    this.resetNewItem();
                    this.$refs.createFormObserver.reset();

                    EventBus.$emit(this.createdEvent);
                });
            });
        },

        resetNewItem() {
            this.newItem = cloneDeep(this.newItemDefault);
        }
    },
    created() {
        this.resetNewItem();
    }
};
