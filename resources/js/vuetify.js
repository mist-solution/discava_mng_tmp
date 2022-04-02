// Styles
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

// Vuetify
import { createVuetify } from "vuetify";

const vuetifyOpt = {
    components,
    directives,
}

const vuetify = createVuetify(vuetifyOpt)

export default vuetify;