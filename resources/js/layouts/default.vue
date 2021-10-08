<template>
    <NavigationBar></NavigationBar>
    <main class="container is-fullwidth"><slot></slot></main>

    <NotificationHandler></NotificationHandler>
</template>

<script>
import { defineComponent } from "@vue/runtime-core";
import NavigationBar from "@/components/sections/Navigation/NavigationBar.vue";
import NotificationHandler from "@/components/elements/Notification/NotificationHandler.vue";

export default defineComponent({
    components: { NavigationBar, NotificationHandler },
});
</script>

<style></style>
