import { createApp } from "vue";

import { router, Routes } from "./plugins/router";
import { store } from "./plugins/store";
import masonry from "vue-next-masonry";

import App from "./App.vue";

import "./styles/main.scss";

const application = createApp(App);

application.config.globalProperties.$routes = Routes;

/**
 * Vue Application Plugins
 */
application.use(router);
application.use(store);
application.use(masonry);


application.mount("#app");
