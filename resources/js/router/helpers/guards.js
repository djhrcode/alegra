/**
 * Creates a executable to handle many navigation guards
 *
 * @param {Array<import("vue-router").NavigationGuard>} navigationGuards
 */
export const useNavigationGuards = (navigationGuards) => {
    /**
     * Executes every given guard
     *
     * @type {import("vue-router").NavigationGuard}
     */
    const executeNavigationGuards = (to, from, rootRouterNext) => {
        /**
         * Creates a generator to iterate programmatically
         * to every navigation guard received
         *
         * @param {Array<import("vue-router").NavigationGuard>} guards
         */
        function* createGuardsGenerator(navigationGuards) {
            for (const currentNavigationGuard of navigationGuards)
                yield currentNavigationGuard;
        }

        const navigationGuardsGenerator =
            createGuardsGenerator(navigationGuards);

        const executeNextNavigationGuard = () => {
            const { value: nextNavigationGuard, done: noMoreGuardsToExecute } =
                navigationGuardsGenerator.next();

            if (noMoreGuardsToExecute) return rootRouterNext();

            return nextNavigationGuard(to, from, nextGuardHandler);
        };

        const nextGuardHandler = (action = undefined) => {
            const actionToExecute = action === undefined;

            if (!actionToExecute) return rootRouterNext(action);

            executeNextNavigationGuard();
        };

        return executeNextNavigationGuard();
    };

    return executeNavigationGuards;
};

/**
 * @param {import("vue-router").NavigationGuard} guard
 * @return {import("vue-router").NavigationGuard}
 */
export const createNavigationGuard = (guard) => guard;
