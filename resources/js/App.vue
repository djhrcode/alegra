<script setup>
import LayoutHandler from "@/layouts/_handler.vue";
import SuspenseComponent from "./components/helpers/SuspenseComponent.vue";
import { useAuthenticationService } from "./models/Authentication/AuthenticationService";
import { useBearerTokenStorage } from "./models/Authentication/BearerTokenStorage";
import LoadingStatusView from "./pages/_status/loading.vue";

if (useBearerTokenStorage().hasToken())
    useAuthenticationService().checkStatus();
</script>

<template>
    <LayoutHandler>
        <SuspenseComponent>
            <template #default>
                <router-view v-slot="{ Component, route }">
                    <transition
                        :name="route?.meta?.transition ?? 'fade'"
                        mode="out-in"
                    >
                        <component :is="Component"></component>
                    </transition>
                </router-view>
            </template>
            <template #fallback>
                <LoadingStatusView></LoadingStatusView>
            </template>
        </SuspenseComponent>
    </LayoutHandler>
</template>
