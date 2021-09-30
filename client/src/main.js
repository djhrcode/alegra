import { createApp } from "vue";

import { router } from "./plugins/router";
import { store } from "./plugins/store";

import App from "./App.vue";

const application = createApp(App);

/**
 * Vue Application Plugins 
 */
application.use(router);
application.use(store);

application.mount("#app");
