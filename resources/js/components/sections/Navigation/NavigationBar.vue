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
                class="navbar-burger"
                aria-label="menu"
                aria-expanded="false"
                data-target="navbarBasicExample"
            >
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
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
import { Routes } from "@/plugins/router";
import { defineComponent, markRaw } from "@vue/runtime-core";
import ButtonComponent from "@/components/elements/Button/ButtonComponent.vue";
import { useAuthenticationService } from "@/models/Authentication/AuthenticationService";
import { useRouter } from "vue-router";

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
        const router = useRouter();
        const authService = useAuthenticationService();

        const onClickLogoutButton = () => {
            authService
                .logout()
                .then(() => router.push({ name: Routes.Login }));
        };


        return { authService, onClickLogoutButton };
    },
});
</script>
