export function useBearerTokenStorage() {
    const BEARER_TOKEN_STORAGE = "AuthBearerToken";

    function hasToken() {
        return Boolean(getToken());
    }

    function getToken() {
        return window.localStorage.getItem(BEARER_TOKEN_STORAGE);
    }

    function setToken(value) {
        window.localStorage.setItem(BEARER_TOKEN_STORAGE, value);
    }

    function removeToken() {
        window.localStorage.setItem(BEARER_TOKEN_STORAGE);
    }

    return { hasToken, setToken, getToken, removeToken };
}
