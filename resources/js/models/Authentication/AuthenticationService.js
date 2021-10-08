import { HTTPError } from "ky";
import { useAuthenticationClient } from "./AuthenticationClient";
import {
    createAuthenticable,
    createAuthenticationState,
    createBearerToken,
    createCredentials,
    createUser,
} from "./AuthenticationFactories";
import { useAuthenticationStore } from "./AuthenticationStore";
import { useBearerTokenStorage } from "./BearerTokenStorage";

export function useAuthenticationService() {
    const authHttpClient = useAuthenticationClient();
    const authStateStore = useAuthenticationStore();
    const bearerTokenStorage = useBearerTokenStorage();

    // /**
    //  * Hydrates the authentication store's state with the given account
    //  * This function must remain private
    //  */
    function hydrateStoreWithAccount(account = {}) {
        console.log("Hydrating Store", account)
        return authStateStore.hydrate(
            createAuthenticationState({
                status: true,
                account: createUser(account),
            })
        );
    }

    function onSuccessResponse(bearerToken = createBearerToken()) {
        bearerTokenStorage.setToken(bearerToken.access_token);

        return authHttpClient
            .account()
            .then((account) => hydrateStoreWithAccount(account));
    }

    /**
     * Creates a login request and if success, then
     * hydrates the account state locally
     */
    function login(credentials = createCredentials()) {
        return authHttpClient.login(credentials).then(onSuccessResponse);
    }

    /**
     * Creates a register request and if success, then
     * hydrates the account state locally
     */
    function register(authenticable = createAuthenticable()) {
        return authHttpClient.register(authenticable).then(onSuccessResponse);
    }

    function account() {
        return authStateStore.hasAccount()
            ? authStateStore.state.account
            : null;
    }

    function logout() {
        return authStateStore
            .logout()
            .then(() => bearerTokenStorage.removeToken());
    }

    async function checkStatus() {
        const isLocallyActive = authStateStore.checkStatus();
        const hasBearerToken = bearerTokenStorage.hasToken();

        return isLocallyActive && hasBearerToken ? true : authHttpClient
            .account()
            .then((account) => hydrateStoreWithAccount(account))
            .then(() => authStateStore.checkStatus())
    }

    return {
        logout,
        login,
        register,

        account,
        checkStatus,
    };
}
