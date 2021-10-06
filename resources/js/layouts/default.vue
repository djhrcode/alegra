<template>
    <NavigationBar></NavigationBar>
    <main class="container is-fullwidth"><slot></slot></main>
</template>

<script>
import { defineComponent } from "@vue/runtime-core";
import NavigationBar from "@/components/sections/Navigation/NavigationBar.vue";

export default defineComponent({
    components: { NavigationBar },
});
</script>

<style></style>
