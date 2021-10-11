<template>
    <nav
        class="navbar p-1 p-0-touch"
        role="navigation"
        aria-label="main navigation"
    >
        <div class="navbar-brand">
            <a class="navbar-item">
                <img
                    src="@/assets/img/worldwideimages-logo.svg"
                    style="min-height: 30px"
                />
            </a>

            <a
                role="button"
                aria-label="menu"
                :aria-expanded="isMenuExpanded"
                :class="buttonMenuClasses"
                @click="toggleNavigationMenu"
            >
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div :class="expandibleMenuClasses">
            <div v-if="authService.status()" class="navbar-start">
                <RouterLink
                    v-for="(link, index) in links"
                    :key="index"
                    :to="link.to"
                    class="navbar-item"
                >
                    {{ link.text }}
                </RouterLink>
            </div>

            <div class="navbar-end">
                <ButtonComponent
                    v-if="authService.status()"
                    @click="onClickLogoutButton"
                    type="inverted"
                    color="secondary"
                    icon-right="la-sign-out-alt"
                >
                    Cerrar sesión
                </ButtonComponent>
            </div>
        </div>
    </nav>
</template>

<script>
import { computed, defineComponent, markRaw, ref } from "@vue/runtime-core";
import { Routes } from "@/plugins/router";
import { useAuthenticationService } from "@/models/Authentication/AuthenticationService";
import { useRouter } from "vue-router";
import ButtonComponent from "@/components/elements/Button/ButtonComponent.vue";

export default defineComponent({
    components: {
        ButtonComponent,
    },
    data: () => ({
        links: markRaw([
            {
                text: "Explorar",
                to: { name: Routes.Explore },
            },
            {
                text: "Resultados",
                to: { name: Routes.Progress },
            },
        ]),
    }),

    setup() {
        /**
         * External services & features
         */
        const router = useRouter();
        const authService = useAuthenticationService();

        /**
         * Internal component state & methods
         */
        const isMenuExpanded = ref(false);

        const onClickLogoutButton = () => {
            authService
                .logout()
                .then(() => router.push({ name: Routes.Login }));
        };

        const toggleNavigationMenu = () => {
            isMenuExpanded.value = !isMenuExpanded.value;
        };

        const buttonMenuClasses = computed(() => ({
            "navbar-burger": true,
            "is-active": isMenuExpanded.value,
        }));

        const expandibleMenuClasses = computed(() => ({
            "navbar-menu": true,
            "is-active": isMenuExpanded.value,
        }));

        return {
            authService,
            onClickLogoutButton,

            isMenuExpanded,
            buttonMenuClasses,
            expandibleMenuClasses,
            toggleNavigationMenu,
        };
    },
});
</script>
