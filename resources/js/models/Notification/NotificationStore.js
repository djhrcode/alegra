import { createStoreModule, useStoreWithNamespace } from "@/helpers/store";
import { computed } from "vue";
import { useStore } from "vuex";
import {
    createNotification,
    createNotificationId,
    createNotificationsState,
} from "./NotificationFactories";

export const NotificationNamespace = "notifications";

export const NotificationMutations = {
    Create: "create",
    Remove: "remove",
};

export const NotificationActions = {
    Create: "create",
    Remove: "remove",
};

export const NotificationStore = createStoreModule(NotificationNamespace, {
    namespaced: true,

    state: () => createNotificationsState({ items: [], delay: 3000 }),

    mutations: {
        [NotificationMutations.Create](state, notification) {
            state.items.push(notification);
        },
        [NotificationMutations.Remove](state, removeId) {
            const indexFound = state.items.findIndex(
                ({ id: notificationId }) => notificationId === removeId
            );

            if (Number.isInteger(indexFound)) state.items.splice(indexFound, 1);
        },
    },

    actions: {
        [NotificationActions.Create](context, payload) {
            const notification = createNotification(payload);
            const delayToUse = notification.delay ?? context.state.delay;

            const removeLater = () =>
                context.dispatch(NotificationActions.Remove, notification.id);

            context.commit(NotificationMutations.Create, notification);

            setTimeout(removeLater, delayToUse);
        },
        [NotificationActions.Remove](context, notificationId) {
            context.commit(NotificationMutations.Remove, notificationId);
        },
    },
});

export const useNotificationStore = (store = useStore()) => {
    const notificationStore = useStoreWithNamespace(
        NotificationNamespace,
        store
    );

    const notifications = computed(() => notificationStore.state().items);

    function notify(notification = createNotification({})) {
        return notificationStore.dispatch(
            NotificationActions.Create,
            createNotification(notification)
        );
    }

    function close(notificationId = Number()) {
        return notificationStore.dispatch(
            NotificationActions.Remove,
            notificationId
        );
    }

    return { notify, notifications, close };
};
