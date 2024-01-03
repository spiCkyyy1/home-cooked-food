import {createApp, h, onBeforeMount} from 'vue';
import {createInertiaApp, Link} from '@inertiajs/vue3';
import { Ziggy } from './ziggy';
import {ZiggyVue} from 'ziggy';
import Layout from "@/Layouts/Layout.vue";
import 'flowbite';
import { StripePlugin } from '@vue-stripe/vue-stripe';
import VueGoogleMaps from '@fawmi/vue-google-maps';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const GOOGLE_MAPS_API_KEY = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
const STRIPE_KEY = import.meta.env.VITE_STRIPE_KEY;
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        //conditional layout
        page.default.layout = name.startsWith('Auth/') ? undefined : Layout
        // page.default.layout = page.default.layout || Layout

        return page
    },
    setup({ el, App, props, plugin }) {
        onBeforeMount(() => {
            const stripeLoaded = ref(false)
            const stripePromise = loadStripe(STRIPE_KEY)
            stripePromise.then(() => {
                stripeLoaded.value = true
            })
        })
        const VueApp = createApp({ render: () => h(App, props) });
            VueApp.config.globalProperties.$route = route
            VueApp.use(plugin)
                .use(ZiggyVue, Ziggy)
                .use(VueGoogleMaps, {
                    load: {
                        key: GOOGLE_MAPS_API_KEY,
                        libraries: "places"
                    },
                })
                .component("Link", Link)
                .component('VueDatePicker', VueDatePicker)
                .mixin({ methods: { route }})
                .mount(el)
    },
    progress: {
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,

        // The color of the progress bar...
        color: '#29d',

        // Whether to include the default NProgress styles...
        includeCSS: true,

        // Whether the NProgress spinner will be shown...
        showSpinner: false,
    },

});
