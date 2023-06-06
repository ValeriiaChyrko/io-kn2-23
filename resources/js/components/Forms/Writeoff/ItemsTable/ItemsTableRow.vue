<template>
    <validation-observer
        ref="formObserver"
        tag="tr"
    >
        <td>{{ index }}</td>
        <template v-if="isExpanded">
            <validation-provider
                v-slot="{ errors }"
                name="Предмет"
                rules="required|numeric"
                tag="td"
            >
                <item-autocomplete-with-info
                    v-model="item.item_id"
                    :error-messages="errors"
                    :items="avalItems"
                    disable-unrepairable
                    label="Предмет"
                    ref="itemsField"
                />
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="Причина списання"
                rules="required|max:100"
                tag="td"
            >
                <v-text-field
                    v-model="item.comment"
                    @input="input()"
                    :disabled="!editable"
                    :error-messages="errors"
                    :counter="100"
                    autocomplete="off"
                    ref="commentField"
                />
            </validation-provider>
        </template>
        <template v-else>
            <td @click="activate('itemsField')" class="cursor-pointer text-body-1">
                {{ itemInfo.inventory_number }} - {{ itemInfo.type_title }} {{ itemInfo.hardware_model_title }}
            </td>
            <td @click="activate('commentField')" class="cursor-pointer text-body-1">
                {{ item.comment }}
            </td>
        </template>
        <td
            class="text-no-wrap"
        >
            <item-delete-button
                v-if="isExists"
                @delete="deleteLocally()"
                :disabled="!editable"
                :item-id="item.id"
            />
            <delete-button
                v-else
                :deletable="!!editable"
                @delete="deleteLocally()"
            />

        </td>
        <td class="text-no-wrap">
            <load-status-icon
                :saving="item.isSaving"
                :exists="isExists"
            />
        </td>
    </validation-observer>
</template>

<script>
import { debounce } from 'lodash-es';
import DeleteButton from '~/components/DataTable/DeleteButton';
import ItemDeleteButton from '~/components/Forms/Writeoff/ItemsTable/ItemDeleteButton';
import LoadStatusIcon from '~/components/Forms/Invoice/LoadStatusIcon/LoadStatusIcon';
import FormValidate from '~/components/mixins/FormValidate';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import ItemAutocompleteWithInfo from "~/components/DataTable/ItemAutocompleteWithInfo.vue";

export default {
    name: 'ItemsTableRow',
    mixins: [
        FormValidate
    ],
    components: {
        ItemAutocompleteWithInfo,
        DeleteButton,
        ItemDeleteButton,
        LoadStatusIcon
    },
    props: {
        value: {
            type: Object,
            required: true
        },
        writeoffId: {
            type: Number,
            required: true
        },
        confirmed: {
            type: Boolean,
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },
    data: () => ({
        isActive: false,

        avalItems: [
            {
                id: 1,
                inventory_number: '101462343',
                type_title: 'БФП',
                owner_name: "Кулеша Сергій Олексійович",
                department_title: "Серверна СК",
                hardware_model_title: "Canon MF641cw"
            },
            {
                id: 2,
                inventory_number: '101462394',
                type_title: "Моноблок",
                owner_name: 'Кулеша Сергій Олексійович',
                department_title: "311",
                hardware_model_title: "Dell Inspiron All-in-One 3477"
            },
            {
                id: 3,
                inventory_number: '101462230',
                type_title: "Мережевий комутатор",
                owner_name: "Василь Володимирович Павельчук",
                department_title: "Новоакадемічний корпус",
                hardware_model_title: "MIKROTIK Enternet CRS328-24P-4S+RM"
            }
        ]
    }),
    computed: {
        item: {
            get() { return this.value; },
            set(val) { this.$emit('input', val); }
        },
        itemInfo() {
            return this.avalItems.filter(itm => itm.id == this.item.item_id)[0];
        },
        editable() {
            return !this.confirmed;
        },
        isExpanded() {
            return this.isActive || !this.isExists;
        },
        isExists() {
            return !!this.item.id;
        },
        isFilled() {
            return !!this.item.item_id
                && !!this.item.comment;
        }
    },
    methods: {
        activate(fieldRef = null) {
            this.isActive = true;
            EventBus.$emit(EventTypes.WRITEOFF_ITEM_ROW_ACTIVATED, {
                uid: this.item.uid
            });

            if(fieldRef) {
                setTimeout(() => {
                    this.$refs[fieldRef].$el.querySelector('input').click();
                });
            }
        },
        deactivate() {
            this.isActive = false;
        },
        deleteLocally() {
            this.$emit('delete');
        },
        input: debounce(async function() {
            if(!this.isFilled || !await this.$refs.formObserver.validate()) {
                return;
            }

            if(this.isExists) {
                this.updateItem();
            } else {
                this.isActive = true;
                this.createItem();
            }
        }, 350),
        createItem() {
            this.item.isSaving = true;

            setTimeout(() => {
                this.$set(this.item, 'id', 1);
                this.item.isSaving = false;
            }, 750);
        },
        updateItem() {
            this.item.isSaving = true;

            setTimeout(() => {
                this.item.isSaving = false;
            }, 750);
        },
    },
    created() {
        EventBus.$on(EventTypes.WRITEOFF_ITEM_ROW_ACTIVATED, payload => {
            if(payload.uid !== this.item.uid) {
                this.deactivate();
            }
        });
    }
};
</script>
