import './bootstrap';
import '../css/app.css';
import "vue-toastification/dist/index.css";
import "@fortawesome/fontawesome-free/css/all.min.css";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Toast, { POSITION } from "vue-toastification";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const options = {
    position: POSITION.TOP_CENTER
    // You can set your default options here
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast, options)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
