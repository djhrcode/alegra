const applicationHasBooted = { value: false };

/**
 * @param {import("vue-router").NavigationGuard} navigationGuard
 * @return {import("vue-router").NavigationGuard}
 */
export const createBootNavigationGuard = (navigationGuard) => {
    /**
     *
     * @type {import("vue-router").NavigationGuard}
     */
    const navigationGuardDecorator = (...navigationParams) => {
        const nextNavigationGuard = navigationParams[2];

        if (applicationHasBooted) return nextNavigationGuard();

        applicationHasBooted = true;
        return navigationGuard(...navigationParams);
    };

    return navigationGuardDecorator;
};
