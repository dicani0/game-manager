import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import Toast from "vue-toastification";
import VueFeather from 'vue-feather';
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import "vue-toastification/dist/index.css";
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import Layout from "@/Layouts/Layout.vue";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Game Manager';


createInertiaApp({
    title: (title) => !!title ? `${appName} | ` + title : appName,
    resolve: async (name) => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
        if (page.default.layout === undefined) {
            page.default.layout = Layout; // Set default layout if none is defined
        }
        return page;
    },
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueSweetalert2)
            .use(Toast, {
                transition: "Vue-Toastification__slideBlurred",
                maxToasts: 20,
                newestOnTop: true,
                timeout: 10000,
                icon: true,
            })
            .component(VueFeather.name, VueFeather)
            .mount(el);
    },
    progress: {
        delay: 0,
        color: '#02f1fd',
        includeCss: true,
        showSpinner: false,
    },
});
