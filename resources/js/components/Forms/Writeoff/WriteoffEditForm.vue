<template>
    <v-dialog
        v-model="formActive"
        fullscreen
        no-click-animation
        persistent
        transition="dialog-bottom-transition"
    >
        <v-card>
            <v-toolbar
                class="mb-5 rounded-0"
                color="primary"
                dark
                elevation="7"
            >
                <v-btn
                    dark
                    icon
                    @click="closeForm()"
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-toolbar-title>Редагування списання</v-toolbar-title>
                <v-spacer/>
                <load-status-text
                    :saving="isSavingAny"
                />

                <writeoff-confirmation-dialog
                    v-if="!isLoadingWriteoff"
                    :writeoff-id="writeoffId"
                    :confirmed="writeoff.confirmed"
                />
            </v-toolbar>

            <v-card-text>
                <div v-show="isLoading">
                    <v-skeleton-loader
                        class="mx-auto"
                        type="table-row"
                    />
                    <v-skeleton-loader
                        class="mx-auto"
                        type="table"
                    />
                </div>

                <div v-if="!isLoading">
                    <only-writeoff-edit
                        v-model="writeoff"
                        :writeoff-id="writeoffId"
                    />

                    <items-table
                        v-model="items"
                        :writeoff-id="writeoffId"
                        :confirmed="writeoff.confirmed"
                    />
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import ItemsTable from '~/components/Forms/Writeoff/ItemsTable/ItemsTable';
import LoadStatusText from '~/components/Forms/Invoice/LoadStatusText';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import WriteoffConfirmationDialog from "~/components/Forms/Writeoff/WriteoffConfirmationDialog.vue";
import OnlyWriteoffEdit from "~/components/Forms/Writeoff/OnlyWriteoffEdit.vue";

export default {
    name: 'WriteoffEditForm',
    components: {
        OnlyWriteoffEdit,
        WriteoffConfirmationDialog,
        ItemsTable,
        LoadStatusText
    },
    data: () => ({
        formActive: false,
        writeoffId: null,

        isLoadingWriteoff: false,
        isLoadingItems: false,

        writeoff: {},
        items: []
    }),
    computed: {
        isLoading() {
            return this.isLoadingItems || this.isLoadingWriteoff;
        },
        isSavingAny() {
            let checkArray = arr => arr.some(elem => elem.isSaving === true);

            return checkArray(this.items) || !!this.writeoff.isSaving;
        }
    },
    methods: {
        closeForm() {
            //TODO: Wait for save all data?
            this.formActive = false;
            EventBus.$emit(EventTypes.RELOAD_WRITEOFFS_TABLE);
            // EventBus.$emit(EventTypes.RELOAD_INVOICE_FULL_DATA, this.writeoffId);
        },
        /*async loadWriteoff() {
            this.isLoadingWriteoff = true;

                let { data: writeoff } = await axios.get(`/api/writeoffs/${ this.writeoffId }`);

            writeoff.isSaving = false;
            this.writeoff = writeoff;

            this.isLoadingWriteoff = false;
        },*/
        async loadWriteoff() {
            this.isLoadingWriteoff = true;
            await new Promise(resolve => setTimeout(resolve, 1000));

            this.writeoff = {
                id: 6,
                number: 73496,
                date: '2021-12-20T00:00:00.000000Z',
                user_id: 1,
                user_name: 'Любов Іванівна Дідик',
                confirmed: false,
                created_at: '2021-11-20T00:00:00.000000Z',

                isSaving: false
            };

            this.isLoadingWriteoff = false;
        },
        async loadItems(withLoader = true) {
            if(withLoader) {
                this.isLoadingItems = true;
            }

            // let { data: items } = await axios.get(`/api/writeoffs/${ this.writeoffId }/items`);
            // items.forEach(item => {
            //     item.uid = this.genUID();
            //     item.isSaving = false;
            // });
            // this.items = items;

            if(withLoader) {
                this.isLoadingItems = false;
            }
        }
    },
    created() {
        this.$store.dispatch('types/fetch');
        this.$store.dispatch('users/fetch');
        this.$store.dispatch('departments/fetch');
        this.$store.dispatch('hardwareModels/fetch');
        this.$store.dispatch('softwareModels/fetch');

        EventBus.$on(EventTypes.OPEN_WRITEOFF_EDIT_FORM, data => {
            this.writeoffId = data.writeoffId;
            this.formActive = true;
            this.loadWriteoff();
            this.loadItems();
        });

        EventBus.$on(EventTypes.CLOSE_WRITEOFF_EDIT_FORM, () => this.closeForm());
    }
};
</script>
