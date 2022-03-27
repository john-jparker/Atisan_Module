require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Link } from "@inertiajs/inertia-vue3";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {

        let parts = name.split('::')
        let type = false
        if (parts.length > 1) {
            type = parts[0]
        }
        if (type) {
            let nameVue = parts[1].split('.')[0]
            return import("../../modules/" + parts[0] + "/src/resources/js/Pages/" + nameVue + ".vue")
        }else {
            return import(`./Pages/${name}`)
        }
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueSweetalert2)
            .component("Link", Link)
            .mixin({ methods: { route } })
            .mount(el);
    },
});
InertiaProgress.init({ color: '#4B5563' });
