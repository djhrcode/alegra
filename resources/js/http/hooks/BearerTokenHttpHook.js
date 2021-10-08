import { useBearerTokenStorage } from "@/models/Authentication/BearerTokenStorage";

/**
 * If there is a Bearer token stored locally we
 * automatically use that token for every outgoing request
 *
 * @type {import("ky").BeforeRequestHook}
 */
export const BearerTokenHttpHook = (request, options) => {
    if (useBearerTokenStorage().hasToken())
        request.headers.set(
            "Authorization",
            `Bearer ${useBearerTokenStorage().getToken()}`
        );
};
