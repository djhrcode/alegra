import { Store } from "vuex";

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
 * @param {Store} store
 */
export const useStoreWithNamespace = (namespace, store) => ({
    state() {
        return store.state[namespace];
    },

    commit(type, payload, options) {
        return store.commit(`${namespace}/${type}`, payload, options);
    },

    dispatch(action, payload, options) {
        return store.dispatch(`${namespace}/${action}`, payload, options);
    },
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
