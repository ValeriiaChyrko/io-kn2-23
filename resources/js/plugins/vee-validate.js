import dayjs from 'dayjs';
import { extend, setInteractionMode } from 'vee-validate';
import { email, ext, is_not, max, max_value, min, min_value, numeric, required } from 'vee-validate/dist/rules';
import asyncDebounce from '~/shared/async-debounce';

setInteractionMode('eager');

extend('required', {
    ...required,
    message: 'Не може бути порожнє',
    computesRequired: true,

    validate(value) {
        return {
            required: true,
            valid: ['', null, undefined].indexOf(value) === -1
        };
    }
});

extend('required_checkbox', {
    ...required,
    message: 'Виберіть значення'
});

extend('email', {
    ...email,
    message: 'Неправильний email'
});

extend('max', {
    ...max,
    message: 'Не може містити більше {length} символів'
});

extend('max_value', {
    ...max_value,
    message: 'Не можи бути більше за {max}'
});

extend('min', {
    ...min,
    message: 'Не може містити менше {length} символів'
});

extend('min_value', {
    ...min_value,
    message: 'Не можи бути менше за {min}'
});

extend('ext', {
    ...ext,
    message: 'Вибране розширення файлу не підтримується'
});

extend('numeric', {
    ...numeric,
    message: 'Може містити виключно цифри'
});

extend('price', {
    validate: (value) => (
        /^\d+(\.\d{1,2})?$/.test(value)
    ),
    message: 'Може містити тільки додатні дробові числа'
});

extend('item_number_regex', {
    validate: (value) => (
            /^\d+(?:[-\/]\d+)*$/.test(value)
    ),
    message: 'Неправильний формат'
});

extend('repair_end_date_after_or_equal_to_start_date', {
    validate: (value, { start_date }) => (
        dayjs(value).isSameOrAfter(start_date, 'day')
    ),
    params: [
        {
            name: 'start_date'
        }
    ],
    message: 'Не може бути раніше за дату початку'
});

extend('repair_start_date_before_or_equal_to_end_date', {
    validate: (value, { end_date }) => (
        dayjs(value).isSameOrBefore(end_date, 'day')
    ),
    params: [
        {
            name: 'end_date'
        }
    ],
    message: 'Не може бути пізніше за кінцеву дату'
});

extend('item_number_unique', {
    validate: asyncDebounce(async function(value, { ignoreId } = {}) {
        let available, request = [{
            number: value,
            ignoreId
        }];

        try {
            available = (await axios.post('/api/items/number-availability', request)).data[0].available;
        } catch (e) {
            available = false;
        }

        return available;
    }, 350),
    params: [
        {
            name: 'ignoreId'
        }
    ],
    message: 'Номер вже використовується'
});

extend('distinct', {
    validate: async(value, args) => (
        args.filter(elem => (elem === value)).length <= 1
    ),
    message: 'Значення повторюється у кількох полях'
});

extend('receiver_is_not_owner', {
    ...is_not,
    message: 'Отримувач не може бути відправником'
});


