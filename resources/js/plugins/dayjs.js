import dayjs from 'dayjs';
import 'dayjs/locale/uk';
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter';
import isSameOrBefore from 'dayjs/plugin/isSameOrBefore';

dayjs.locale('uk');

dayjs.extend(isSameOrAfter);
dayjs.extend(isSameOrBefore);
