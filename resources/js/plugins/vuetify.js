import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import uk from 'vuetify/lib/locale/uk';

Vue.use(Vuetify);

const opts = {
    theme: {
        dark: false
    },
    lang: {
        locales: { uk },
        current: 'uk'
    }
};

export default new Vuetify(opts);
