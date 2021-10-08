import { useHttpClient } from "@/helpers/http";
import {
    createBearerToken,
    createCredentials,
    createAuthenticable,
    createUser,
} from "./AuthenticationFactories";

const createJsonBody = (json) => ({ json });

export function useAuthenticationClient() {
    const httpApiClient = useHttpClient();

    function account() {
        return httpApiClient
            .get("account")
            .then((response) => response.json())
            .then(({ data }) => createUser(data));
    }

    function login(data = createCredentials()) {
        return httpApiClient
            .post("auth/login", createJsonBody(createCredentials(data)))
            .then((response) => response.json())
            .then(({ data }) => createBearerToken(data));
    }

    function register(data = createAuthenticable()) {
        return httpApiClient
            .post("auth/register", createJsonBody(createAuthenticable(data)))
            .then((response) => response.json())
            .then(({ data }) => createBearerToken(data));
    }

    return { account, login, register };
}
