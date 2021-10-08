import { useBearerTokenStorage } from "@/models/Authentication/BearerTokenStorage";
import { Routes, useRouterInstance } from "@/plugins/router";
import { UNAUTHORIZED_HTTP_ERROR } from "../status";

/**
 * If the server response is an Unauthorized HTTP Code
 * then redirect the user to login
 *
 * @type {import("ky").AfterResponseHook}
 */
export const HandleAuthenticationErrorHttpHook = (
    request,
    options,
    response
) => {
    if (response.status === UNAUTHORIZED_HTTP_ERROR) {
        useBearerTokenStorage().removeToken();
        useRouterInstance().push({ name: Routes.Login })
    }
};
