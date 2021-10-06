/**
 * @typedef {{getModule: () => import("vuex").Module, getNamespace: () => ?string}} StoreModule
 */

/**
 * Creates a new StoreModule instance
 *
 * @param {import("vuex").Module} module
 * @param {string|null} namespace
 * @returns {StoreModule}
 */
export const createStoreModule = (namespace, module) => ({
    getModule: () => module,
    getNamespace: () => namespace,
});

/**
 * Transforms the given StoreModule instances into Vuex's ModuleTree
 *
 * @param {Array<StoreModule>} modules
 * @returns {import("vuex").ModuleTree}
 */
export const createModulesTree = (modules = []) =>
    modules.reduce((modulesTree, module) => {
        modulesTree[module.getNamespace()] = module.getModule();
        return modulesTree;
    }, {});
