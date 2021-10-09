import { useAuthenticationService } from "@/models/Authentication/AuthenticationService";
import { useBearerTokenStorage } from "@/models/Authentication/BearerTokenStorage";
import { ActiveContestMustBeClosed } from "@/models/Contest/guards/ActiveContestMustBeClosed";
import { ActiveContestMustBeOpen } from "@/models/Contest/guards/ActiveContestMustBeOpen";
import { createNavigationGuard } from "@/router/helpers/guards";
import { createRoute } from "@/router/helpers/routes";
import { readonly } from "vue";
import { createRouter, createWebHistory } from "vue-router";

export const Routes = readonly({
    Register: "register",
    Login: "login",
    Welcome: "welcome",
    Progress: "progress",
    Explore: "explore",
    Finished: "finished",
});

const UserMustBeAuthenticated = createNavigationGuard((from, to, next) => {
    console.log("UserMustBeAuthenticated");
    if (!useBearerTokenStorage().hasToken()) {
        return next({ name: Routes.Login });
    } else {
        return next();
    }
});

const UserMustBeGuest = createNavigationGuard((from, to, next) => {
    console.log("UserMustBeGuest");
    if (useBearerTokenStorage().hasToken()) {
        return next({ name: Routes.Welcome });
    } else {
        return next();
    }
});

export const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: "is-active",
    linkExactActiveClass: "is-active",
    routes: [
        {
            path: "/",
            redirect: "/welcome",
        },

        createRoute({
            path: "/register",
            component: () => import("@/pages/register/index.vue"),
        })
            .withName(Routes.Register)
            .withGuardsBeforeEnter([UserMustBeGuest]),

        createRoute({
            path: "/login",
            component: () => import("@/pages/login/index.vue"),
        })
            .withName(Routes.Login)
            .withGuardsBeforeEnter([UserMustBeGuest]),

        createRoute({
            path: "/welcome",
            component: () => import("@/pages/welcome/index.vue"),
        })
            .withName(Routes.Welcome)
            .withGuardsBeforeEnter([
                UserMustBeAuthenticated,
                ActiveContestMustBeOpen,
            ]),

        createRoute({
            path: "/progress",
            component: () => import("@/pages/progress/index.vue"),
        })
            .withName(Routes.Progress)
            .withGuardsBeforeEnter([
                UserMustBeAuthenticated,
                ActiveContestMustBeOpen,
            ]),

        createRoute({
            path: "/explore",
            component: () => import("@/pages/explore/index.vue"),
        })
            .withName(Routes.Explore)
            .withGuardsBeforeEnter([
                UserMustBeAuthenticated,
                ActiveContestMustBeOpen,
            ]),

        createRoute({
            path: "/finished",
            component: () => import("@/pages/finished/index.vue"),
        })
            .withName(Routes.Finished)
            .withGuardsBeforeEnter([
                UserMustBeAuthenticated,
                ActiveContestMustBeClosed,
            ]),
    ],
});

export const useRouterInstance = () => router;
