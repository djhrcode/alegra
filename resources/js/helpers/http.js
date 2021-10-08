import httpClientLib from "ky";

import { BearerTokenHttpHook } from "@/http/hooks/BearerTokenHttpHook";
import { VerifyErrorTypeHttpHook } from "@/http/hooks/VerifyErrorTypeHttpHook";
import { HandleAuthenticationErrorHttpHook } from "@/http/hooks/HandleAuthenticationErrorHttpHook";

/**
 * This is an abstraction for the KY http library
 *
 * If you need information about KY library please see
 * https://github.com/sindresorhus/ky
 */
export const useHttpClient = () =>
    httpClientLib.create({
        prefixUrl: import.meta.env.VITE_WORLWIDE_API_URL,
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
        hooks: {
            beforeRequest: [BearerTokenHttpHook],
            afterResponse: [
                HandleAuthenticationErrorHttpHook,
                VerifyErrorTypeHttpHook,
            ],
        },
    });

export const createJsonDataResponse = ({ data = [] }) => ({ data });
