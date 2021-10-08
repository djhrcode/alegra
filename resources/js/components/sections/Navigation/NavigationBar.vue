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
            <div class="navbar-start">
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

                <button class="navbar-item">
                    Logout
                    <span class="icon is-right">
                        <i class="las la-sign-out-alt"></i>
                    </span>
                </button>
                <img
                    class="my-auto"
                    src="@/assets/img/powered-by-alegra-logo.svg"
                    style="min-height: 24px; max-height: 24px"
                />
            </div>
        </div>
    </nav>
</template>

<script>
import { Routes } from "@/plugins/router";
import { defineComponent, markRaw } from "@vue/runtime-core";

export default defineComponent({
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
});
</script>
