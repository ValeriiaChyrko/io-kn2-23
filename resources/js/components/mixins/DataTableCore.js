import { debounce } from 'lodash-es';
import Snackbar from '~/components/modules/Snackbar';
import DeleteButton from '../DataTable/DeleteButton';
import EditDialog from '../DataTable/EditDialog';
import { EventBus } from '../modules/EventBus';
import FormValidate from './FormValidate';

export default {
    mixins: [
        FormValidate
    ],
    components: {
        EditDialog,
        DeleteButton
    },
    data: () => ({
        //singleSelect: false,
        isSelectableByDefault: true,
        selected: [],

        pagination: {},
        search: '',
        filters: [],
        items: [],

        fetchRequest: null,

        loading: true,
        options: {
            itemsPerPage: 10
        },
        footerOptions: {
            itemsPerPageOptions: [10, 25, 50, 100]
        },

        crudApiEndpoint: '',
        headers: [],
        defaultSortByField: 'id',
        isDefaultSortDirectionDesc: false
    }),
    computed: {
        sortBy() {
            if(this.options.sortBy.length === 0) {    // If no column is selected for sorting, return the default value
                return this.defaultSortByField;
            }

            return this.options.sortBy[0];
        },
        sortDirection() {
            if(this.sortBy == null) {
                return null;
            }

            return this.options.sortDesc[0] ? 'desc' : 'asc';
        },
        isSelectedAny() {
            return this.selected.length !== 0;
        },
        activeHeaders() {
            return this.headers.filter((header) => !header.disabled);
        }
    },
    watch: {
        options: {
            handler() {
                this.fetch();
            },
            deep: true
        },
        search: debounce(function() {
            this.options.page = 1;
            this.fetch();
        }, 80),
        filters: debounce(function() {
            this.fetch();
        }, 80),
    },
    methods: {
        // Обробка подій від edit-dialog

        //@changeless-save
        changeless() {
            Snackbar.warn('Дані не оновлено');
        },

        // Взаємодія з даними

        // Завантаження даних з сервера
        fetch() {
            if(this.fetchRequest) {    //If fetch request is in process, cancel it
                this.fetchRequest.cancel();
            }

            this.loading = true;
            this.fetchRequest = axios.CancelToken.source();

            let requestConfig = {
                cancelToken: this.fetchRequest.token,
                params: {
                    search: (this.search === '' ? null : this.search),

                    page: this.options.page,
                    perPage: this.options.itemsPerPage,

                    sortBy: this.sortBy,
                    sortDirection: this.sortDirection,

                    filters: this.filters
                }
            };

            axios.get(this.crudApiEndpoint, requestConfig).then(response => {
                this.items = response.data.data;
                this.pagination.total = response.data.total;

                //TODO: Create separate function for manipulating with data after fetch
                if(this.isSelectableByDefault) {
                    this.items.forEach(item => item.isSelectable = true);
                }

                EventBus.$emit('dt-fetched');    //TODO: Rename
            }).catch(error => {
                if(!axios.isCancel(error)) {
                    console.error(error);
                }
            }).finally(() => {
                this.loading = false;
            });
        },

        // Редагування полей
        update(item) {
            axios.patch(`${ this.crudApiEndpoint }/${ item.id }`, item)
            .then(() => {
                Snackbar.success('Збережено');
                EventBus.$emit('dt-item-updated');    //TODO: Rename
            }).finally(() => {
                this.fetch();
            });
        },

        // Видалення вибраних
        deleteSelectedItems() {
            if(!this.isSelectedAny)
                return Snackbar.error('Виберіть елементи для видалення');

            this.massDelete(this.selected.map(item => item.id));
        },
        // Видалення одного об'єкта
        deleteSingleItem(id) {
            this.massDelete([id]);
        },
        // Видалення за массивом ідентифікаторів
        massDelete(itemsIdArray) {
            axios.delete(`${ this.crudApiEndpoint }/destroy`, {
                params: {
                    idList: itemsIdArray
                }
            }).then(() => {
                this.fetch();
                Snackbar.success('Успішно видалено');

                EventBus.$emit('dt-item-deleted');    //TODO: Rename

                this.selected = [];
            });
        },


        //Генерує назву для посилання на валідатор
        getValidatorRef(itemFieldName, itemId) {    //TODO: Review
            return 'itemsValidator.' + itemFieldName + '.' + itemId;
        }
    },
    created() {
        this.options.sortBy = [this.defaultSortByField];

        if(this.isDefaultSortDirectionDesc) {
            this.options.sortDesc = [true];
        }

        this.headers.map((header) => {
            if(!('disabled' in header)) {
                this.$set(header, 'disabled', false);
            }
            if(!('disableable' in header)) {
                this.$set(header, 'disableable', true);
            }
        })
    }
};
