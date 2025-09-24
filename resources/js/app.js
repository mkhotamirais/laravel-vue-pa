import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createI18n } from "vue-i18n";
import messages from "./lang";
import Main from "./Layouts/Main.vue";
import DashboardLayout from "./Layouts/DashboardLayout.vue";

const userLang = localStorage.getItem("locale") || "id";
const i18n = createI18n({
    legacy: false, // penting: agar bisa pakai $t
    // locale: window?.locale || "en",
    locale: userLang,
    fallbackLocale: "id",
    messages,
});

createInertiaApp({
    title: (title) => (title ? `${title} - Panorama Alam` : "Panorama Alam"),
    // resolve: (name) => {
    //     // const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
    //     // return pages[`./Pages/${name}.vue`];

    //     const pages = import.meta.glob("./Pages/**/*.vue", {eager: true});
    //     let page = pages[`./Pages/${name}.vue`];
    //     // page.default.layout = page.default.layout || Main;
    //     if (name.startsWith("Dashboard")) {
    //         page.default.layout = [Main, DashboardLayout];
    //     } else {
    //         page.default.layout = page.default.layout || Main;
    //     }
    //     return page;
    // },
    resolve: async (name) => {
        // Baris ini yang diubah
        const pages = import.meta.glob("./Pages/**/*.vue");
        let page = await pages[`./Pages/${name}.vue`]();

        if (name.startsWith("Dashboard")) {
            page.default.layout = [Main, DashboardLayout];
        } else {
            page.default.layout = page.default.layout || Main;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
    progress: {
        // delay: 250,
        delay: 100,
        color: "#29d",
        // color: "#84cc16",
        // includeCSS: true,
        // includeCSS: false,
        showSpinner: false,
    },
});
