require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import route from "ziggy-js";
import { Ziggy } from './ziggy';

createInertiaApp({
    title: title => `${title} - Media Fix`,
    resolve: (name) => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .component('inertia-link', Link)
            .use(plugin)
            .mixin({ methods: { route } })
            .use(Ziggy)
            .mount(el);
    },
});

InertiaProgress.init({
    delay: 250,
    color: '#29d',
    includeCSS: true,
    showSpinner: false,
});
