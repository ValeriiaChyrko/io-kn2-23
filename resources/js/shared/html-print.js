import { defaults } from 'lodash-es';

/**
 * Add styles to opened printer window.
 *
 * @param {Window} window Window where styles should be inserted
 * @param {Array<string>} styles Array of links to css files
 */
const addStyles = (window, styles) => {
    styles.forEach((style) => {
        let link = window.document.createElement('link');
        link.setAttribute('rel', 'stylesheet');
        link.setAttribute('type', 'text/css');
        link.setAttribute('href', style);
        window.document.getElementsByTagName('head')[0].appendChild(link);
    });
};

/**
 * Prepare options.
 *
 * @param {Object} options User provided options
 * @param {object} [options] Options object.
 * @param {string} [options.target='_blank'] Window target.
 * @param {Array<string>} [options.specs=[]] Windows features, {@link https://developer.mozilla.org/en-US/docs/Web/API/Window/open#window_features MDN}.
 * @param {Array<string>} [options.styles=[]] Array of links to css files.
 * @param {Number} [options.timeout=0] Set timeout in ms for print start after window successful render.
 * @param {Boolean} [options.autoClose=true] Should window automatically close after print dialog close.
 * @param {string} [options.windowTitle=''] Window title
 * @returns {{
        target: string,
        specs: Array<string>,
        styles: Array<string>,
        timeout: Number,
        autoClose: Boolean,
        windowTitle: string
    }}
 */
const parseOptions = (options) => {
    const defaultOptions = {
        target: '_blank',
        specs: [],
        styles: [],
        timeout: 0,
        autoClose: true,
        windowTitle: ''
    };

    return defaults({}, options, defaultOptions);
};

/**
 * Insert html to print into opened window and applies styles.
 *
 * @param {Window} printerWindow Window to render.
 * @param {string} title Window title.
 * @param {string} body Window body InnerHTML.
 * @param {Array<string>} styles Array of links to css files.
 */
const renderWindow = (printerWindow, title, body, styles) => {
    printerWindow.document.write(`
        <html lang="uk">
            <head>
                <title>${ title }</title>
            </head>
            <body>
                ${ body }
            </body>
        </html>
    `);
    addStyles(printerWindow, styles);
};

/**
 * Print html element.
 *
 * @param {String} elementId Id attribute of element to print.
 * @param {object} [options] Options object.
 * @param {string} [options.target='_blank'] Window target.
 * @param {Array<string>} [options.specs=[]] Windows features, {@link https://developer.mozilla.org/en-US/docs/Web/API/Window/open#window_features MDN}.
 * @param {Array<string>} [options.styles=[]] Array of links to css files.
 * @param {Number} [options.timeout=0] Set timeout in ms for print start after window successful render.
 * @param {Boolean} [options.autoClose=true] Should window automatically close after print dialog close.
 * @param {string} [options.windowTitle=''] Window title
 * @param {function} [callback] Callback function to execute after successful print.
 * @return {Promise<boolean>} Return false in case of error, and true if all in case of success.
 */
const htmlPrint = async(elementId, options, callback) => {
    if(typeof elementId !== 'string') {
        console.error(`html-print: elementId param must be type string, ${ typeof elementId } provided.`);
        return false;
    }

    let element = window.document.getElementById(elementId),
        config = parseOptions(options),
        specs = !!config.specs.length ? config.specs.join(',') : '';
    const printerWindow = window.open('', config.target, specs);

    renderWindow(printerWindow, config.windowTitle, element.innerHTML, config.styles);

    await new Promise((resolve) => {
        setTimeout(() => {
            printerWindow.focus();
            printerWindow.print();
            if(config.autoClose) {
                printerWindow.document.close();
                printerWindow.close();
            }
            if(callback) {
                callback();
            }
            resolve();
        }, config.timeout);
    });

    return true;
};

export default htmlPrint;
