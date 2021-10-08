<script setup>
import LayoutHandler from "@/layouts/_handler.vue";
</script>

<template>
    <LayoutHandler>
        <router-view v-slot="{ Component, route }">
            <transition :name="route?.meta?.transition ?? 'fade'" mode="out-in">
                <component :is="Component"></component>
            </transition>
        </router-view>
    </LayoutHandler>
</template>
