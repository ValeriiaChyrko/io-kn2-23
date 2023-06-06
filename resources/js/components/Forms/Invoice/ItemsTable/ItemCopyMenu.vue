<template>
    <v-menu
        v-model="isActive"
        :close-on-content-click="false"
        :close-on-click="!isLoading"
        :min-width="370"
        :max-width="560"
        ref="menu"
        offset-y
        left
    >
        <template #activator="{ on: onMenu }">
            <v-tooltip top>
                <template #activator="{ on: onTooltip }">
                    <v-btn
                        v-on="{ ...onTooltip }"
                        @click="openMenu()"
                        :disabled="disabled"
                        icon
                    >
                        <v-icon
                            dense
                        >
                            mdi-content-copy
                        </v-icon>
                    </v-btn>
                </template>
                <span>Копіювати</span>
            </v-tooltip>
        </template>

        <v-card>
            <v-card-text>
                <template v-if="enableNumberRange">
                    <v-checkbox
                        v-model="useRange"
                        :disabled="isLoading"
                        class="mb-0"
                        color="red"
                        label="Генерувати діапазон номерів"
                    />

                    <validation-observer
                        v-slot="{ valid: observerValid }"
                        v-if="useRange"
                        ref="formObserver"
                    >
                        <v-row>
                            <v-col>
                                <validation-provider
                                    v-slot="{ errors }"
                                    rules="required"
                                >
                                    <v-text-field
                                        v-model="rangeBase"
                                        :disabled="isLoading"
                                        :error-messages="errors"
                                        autocomplete="off"
                                        label="Основа"
                                    >
                                        <template #append-outer>
                                            <v-btn
                                                @click="moveCharToStart()"
                                                icon
                                            >
                                                <v-icon>mdi-chevron-down</v-icon>
                                            </v-btn>
                                        </template>
                                    </v-text-field>
                                </validation-provider>
                            </v-col>
                            <v-col>
                                <validation-provider
                                    v-slot="{ errors }"
                                    rules="required|numeric"
                                >
                                    <v-text-field
                                        v-model="maskLength"
                                        :disabled="isLoading"
                                        :error-messages="errors"
                                        autocomplete="off"
                                        label="Довжина закінчення"
                                        min="0"
                                        type="number"
                                        required
                                    />
                                </validation-provider>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <validation-provider
                                    v-slot="{ errors }"
                                    rules="required|numeric"
                                >
                                    <v-text-field
                                        v-model="rangeStart"
                                        :disabled="isLoading"
                                        :error-messages="errors"
                                        :prefix="rangeBase"
                                        autocomplete="off"
                                        class="copy-menu-range-input"
                                        label="Від"
                                        min="0"
                                        type="number"
                                    >
                                        <template #append-outer>
                                            <v-btn
                                                @click="moveCharToBase()"
                                                icon
                                            >
                                                <v-icon>mdi-chevron-up</v-icon>
                                            </v-btn>
                                        </template>
                                    </v-text-field>
                                </validation-provider>
                            </v-col>

                            <v-col>
                                <validation-provider
                                    v-slot="{ errors }"
                                    :rules="{
                                            required: true,
                                            numeric: true,
                                            min_value: rangeStart
                                        }"
                                >
                                    <v-text-field
                                        v-model="rangeEnd"
                                        :disabled="isLoading"
                                        :error-messages="errors"
                                        :prefix="rangeBase"
                                        autocomplete="off"
                                        class="copy-menu-range-input"
                                        label="До"
                                        min="0"
                                        type="number"
                                    />
                                </validation-provider>
                            </v-col>
                        </v-row>

                        <div v-show="observerValid && isFieldsFilled">
                            Буде створено копій: <b>{{ willCreateCopies }}</b><br/>
                            Діапазон номерів {{ rangeBase }}<u>{{ firstRangeNumberEnding }}</u> - {{
                                rangeBase
                            }}<u>{{ lastRangeNumberEnding }}</u>
                        </div>

                        <div v-show="unavailableNumbers.length > 0">
                            <span class="red--text text--accent-2">Деякі номери вже використовуються:</span>
                            <span v-for="(number, index) in unavailableNumbers">
                                <span class="red--text text--accent-2">{{
                                        number.number
                                    }}</span>{{ (unavailableNumbers.length - 1) !== index ? ',' : '.' }}
                            </span>
                        </div>
                    </validation-observer>
                </template>

                <validation-observer
                    v-if="!useRange"
                    tag="div"
                    ref="formObserver"
                >
                    <validation-provider
                        v-slot="{ errors }"
                        rules="required|min_value:1"
                    >
                        <v-text-field
                            v-model="count"
                            :disabled="isLoading"
                            :error-messages="errors"
                            autocomplete="off"
                            label="Кількість копій"
                            min="1"
                            type="number"
                            required
                        />
                    </validation-provider>
                    <v-alert
                        class="alert-centered-icon"
                        icon="mdi-alert-circle-outline"
                        type="warning"
                        dense
                        text
                    >
                        При копіюванні без вказання діапазону інвентарних номерів, інвентарний номер у копій <b>не буде
                        встановлений</b>.
                    </v-alert>
                </validation-observer>
            </v-card-text>

            <dialog-actions
                @cancel="close()"
                @confirm="duplicate()"
                :loading="isLoading"
                confirm-text="Створити"
            />
        </v-card>
    </v-menu>
</template>

<script>
import { clone, padStart } from 'lodash-es';
import DialogActions from '~/components/DataTable/DialogActions';
import FormValidate from '~/components/mixins/FormValidate';
import { EventBus, EventTypes } from '~/components/modules/EventBus';
import Snackbar from '~/components/modules/Snackbar';

export default {
    name: 'ItemCopyMenu',
    mixins: [
        FormValidate
    ],
    components: {
        DialogActions
    },
    props: {
        disabled: {
            type: Boolean,
            default: false
        },
        enableNumberRange: {
            type: Boolean,
            default: false
        },
        itemId: {
            type: Number,
            default: 0
        },

        inventoryNumber: {
            type: String,
            default: ''
        }
    },
    data: () => ({
        isActive: false,
        isLoading: false,

        unavailableNumbers: [],

        count: 1,
        useRange: false,

        rangeBase: '',
        rangeStart: '',
        rangeEnd: '',
        maskLength: 1
    }),
    computed: {
        numbersRange() {
            if(this.willCreateCopies <= 0 || this.willCreateCopies >= 1000 || !this.rangeStart || !this.rangeEnd || !this.rangeBase) {
                return [];
            }

            let range = [];
            let maskLength = clone(this.maskLength);
            let base = clone(this.rangeBase);
            let rangeEnd = parseInt(clone(this.rangeEnd));

            let ending = parseInt(clone(this.rangeStart));
            while(ending <= rangeEnd) {
                let number = ''.concat(base, padStart(ending.toString(), maskLength, '0'));
                range.push(number);
                ending++;
            }

            return range;
        },
        firstRangeNumberEnding() {
            return padStart(this.rangeStart, this.maskLength, '0');
        },
        lastRangeNumberEnding() {
            return padStart(this.rangeEnd, this.maskLength, '0');
        },
        willCreateCopies() {
            return (this.rangeEnd - this.rangeStart) + 1;
        },
        isFieldsFilled() {
            return !!this.rangeBase
                && !!this.rangeStart
                && !!this.rangeEnd
                && !!this.maskLength;
        }
    },
    watch: {
        rangeStart(newValue) {
            if(!!this.rangeStart && this.rangeEnd <= newValue) {
                this.rangeEnd = parseInt(newValue) + 1;
            }
        },
        useRange() {
            this.$refs.menu.updateDimensions();
        }
    },
    methods: {
        async checkIsNumbersAvailable() {
            let params = [];
            this.numbersRange.forEach(number => {
                params.push({
                    number
                });
            });

            let numberAvailability = (await axios.post('/api/items/number-availability', params)).data;
            this.unavailableNumbers = numberAvailability.filter(elem => !elem.available);

            return this.unavailableNumbers.length === 0;
        },
        moveCharToBase() {
            if(this.rangeStart.length > 0) {
                this.rangeBase += this.rangeStart[0];
                this.rangeStart = this.rangeStart.substring(1);
            }
        },
        moveCharToStart() {
            let isLastCharNumber = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9].includes(parseInt(this.rangeBase[this.rangeBase.length - 1]));
            if(this.rangeBase.length > 0 && isLastCharNumber) {
                this.rangeStart = this.rangeBase[this.rangeBase.length - 1] + this.rangeStart;
                this.rangeBase = this.rangeBase.substring(0, this.rangeBase.length - 1);
            }
        },
        close() {
            this.isActive = false;
        },
        openMenu() {
            this.isActive = true;
            this.rangeBase = this.inventoryNumber;

            // Clean fields
            this.count = 1;
            this.rangeStart = '';
            this.rangeEnd = '';
            this.maskLength = 1;
        },
        async duplicate() {
            this.unavailableNumbers = [];

            if(!await this.$refs.formObserver.validate()) {
                return;
            } else if(this.useRange && !await this.checkIsNumbersAvailable()) {
                return;
            }
            this.isLoading = true;

            let params = this.useRange ? {
                numbersRange: this.numbersRange
            } : {
                count: this.count
            };
            params.useRange = this.useRange;

            await axios.post(`/api/items/${ this.itemId }/copy`, params);

            Snackbar.success('Копії створено');

            EventBus.$emit(EventTypes.RELOAD_INVOICE_ITEMS_TABLE);
            this.isLoading = false;
            this.isActive = false;
        }
    }
};
</script>

<style>
.alert-centered-icon .v-icon {
    align-self: center;
}

.copy-menu-range-input .v-text-field__prefix {
    color: #BDBDBD;
}
</style>

