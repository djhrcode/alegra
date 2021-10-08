import { useNavigationGuards } from "./guards";

/**
 *
 * @param {import("vue-router").RouteRecordRaw} routeOptions
 */
export const createRoute = (routeOptions) => {
    /**
     * Defines the layout you want to use with this route
     *
     * @param {string} layout
     */
    function withLayout(layout) {
        return createRoute({ ...routeOptions, meta: { layout } });
    }

    /**
     * Defines the name you want to use for this route
     *
     * @param {string} name
     */
    function withName(name) {
        return createRoute({ ...routeOptions, name });
    }

    /**
     * Defines the guards you want to use before enter the route
     *
     * @param {import("vue-router").NavigationGuard[]} guards
     */
    function withGuardsBeforeEnter(guards) {
        return createRoute({
            ...routeOptions,
            beforeEnter: useNavigationGuards(guards),
        });
    }

    return {
        ...routeOptions,

        withLayout,
        withName,
        withGuardsBeforeEnter,
    };
};
