import { debounce } from 'lodash-es';

export default function asyncDebounce(func, wait) {
    const debounced = debounce(async (resolve, reject, bindSelf, args) => {
        try {
            const result = await func.bind(bindSelf)(...args);
            resolve(result);
        } catch (error) {
            reject(error);
        }
    }, wait);

    // This is the function that will be bound by the caller, so it must contain the `function` keyword.
    function returnFunc(...args) {
        return new Promise((resolve, reject) => {
            debounced(resolve, reject, this, args);
        });
    }

    return returnFunc;
}
