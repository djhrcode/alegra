import { throwCorrespondingError } from "../errors";

/**
 * Depending on the status code we throw an error
 * using the corresponding error class
 *
 * @type {import("ky").AfterResponseHook}
 */
export const VerifyErrorTypeHttpHook = (request, options, response) => {
    if (!response.ok)
        throwCorrespondingError(response.status, request, options, response);
};
