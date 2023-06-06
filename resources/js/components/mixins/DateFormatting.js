import dayjs from 'dayjs';

export default {
    methods: {
        formatDate(date) {
            return date ? dayjs(date).format('DD.MM.YY') : '';
        },
        formatDatetime(date) {
            return date ? dayjs(date).format('DD.MM.YY HH:mm') : '';
        }
    }
};
