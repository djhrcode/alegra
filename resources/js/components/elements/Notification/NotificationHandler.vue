<template>
    <div
        class="container mx-auto is-flex-direction-column px-1-mobile pb-2"
        style="
            position: fixed;
            bottom: 0px;
            width: 100%;
            max-width: 720px;
            left: 50%;
            transform: translateX(-50%);
        "
    >
        <TransitionGroup name="fadeUp">
            <NotificationComponent
                v-for="notification in notifications"
                :key="notification.id"
                :title="notification.title"
                :message="notification.message"
                :color="notification.color"
                :is-light="notification.isLight"
                @close="closeNotification(notification.id)"
            ></NotificationComponent>
        </TransitionGroup>
    </div>
</template>

<script>
import { useNotificationStore } from "@/models/Notification/NotificationStore";
import { computed, defineComponent } from "vue";
import NotificationComponent from "./NotificationComponent.vue";

export default defineComponent({
    components: { NotificationComponent },
    setup() {
        const NotificationStore = useNotificationStore();

        return {
            notifications: NotificationStore.notifications,
            closeNotification: NotificationStore.close,
        };
    },
});
</script>

<style lang="scss" scoped></style>
