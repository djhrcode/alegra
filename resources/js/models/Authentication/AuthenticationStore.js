import { createStoreModule, useStoreWithNamespace } from "@/helpers/store";
import { readonly } from "vue";
import { useStore } from "vuex";
import { createAuthenticationState } from "./AuthenticationFactories";

export const AuthenticationNamespace = "authentication";

export const AuthenticationActions = readonly({
    Hydrate: "Hydrate",
    Logout: "logout",
});

export const AuthenticationMutations = readonly({
    Hydrate: "hydrate",
});

export const AuthenticationStore = createStoreModule(AuthenticationNamespace, {
    namespaced: true,

    state: () => createAuthenticationState({ status: false, account: null }),

    mutations: {
        [AuthenticationMutations.Hydrate](state, payload) {
            state.status = payload.status;
            state.account = payload.account;
        },
    },

    actions: {
        [AuthenticationActions.Hydrate](context, payload) {
            console.log("Hydrating auth state", payload);
            context.commit(
                AuthenticationMutations.Hydrate,
                createAuthenticationState(payload)
            );
        },

        [AuthenticationActions.Logout](context) {
            context.commit(
                AuthenticationMutations.Hydrate,
                createAuthenticationState({ status: false, account: null })
            );
        },
    },
});

export function useAuthenticationStore() {
    const authStateStore = useStoreWithNamespace(AuthenticationNamespace, useStore());

    function hydrate(state = createAuthenticationState()) {
        return authStateStore.dispatch(
            AuthenticationActions.Hydrate,
            createAuthenticationState(state)
        );
    }

    function logout() {
        return authStateStore.dispatch(AuthenticationActions.Logout);
    }

    function checkStatus() {
        return Boolean(createAuthenticationState(authStateStore.state()).status);
    }

    function hasAccount() {
        return Boolean(createAuthenticationState(authStateStore.state()).account);
    }

    return {
        hydrate,
        logout,
        checkStatus,
        hasAccount,

        get state() {
            return createAuthenticationState(authStateStore.state());
        },
    };
}
