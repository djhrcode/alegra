/**
 * @param {import("vue-router").NavigationGuard} navigationGuard
 * @return {import("vue-router").NavigationGuard}
 */
export const SingleTimeNavigationGuard = (navigationGuard) => {
    const wasSometimeExecuted = { value: false };

    /**
     *
     * @type {import("vue-router").NavigationGuard}
     */
    const navigationGuardDecorator = (...navigationParams) => {
        const nextNavigationGuard = navigationParams[2];

        if (wasSometimeExecuted.value) {
            return nextNavigationGuard();
        }

        wasSometimeExecuted.value = true;
        return navigationGuard(...navigationParams);
    };

    return navigationGuardDecorator;
};
