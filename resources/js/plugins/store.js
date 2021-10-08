import { createModulesTree } from "@/helpers/store";
import { AuthenticationStore } from "@/models/Authentication/AuthenticationStore";
import { NotificationStore } from "@/models/Notification/NotificationStore";
import { createStore } from "vuex";

export const store = createStore({
    modules: createModulesTree([AuthenticationStore, NotificationStore]),
});
