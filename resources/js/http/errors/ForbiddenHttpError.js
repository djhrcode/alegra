import { HTTPError } from "ky";
import { expectsHttpCodeToBe, FORBIDDEN_HTTP_ERROR } from "../status";

export class ForbiddenHttpError extends HTTPError {
    /**
     * @param {Response} response
     * @param {Request} request
     * @param {import("ky").NormalizedOptions} options
     */
    constructor(response, request, options) {
        super(response, request, options);
    }

    /**
     * @param {Response} response
     * @param {Request} request
     * @param {import("ky").NormalizedOptions} options
     */
    static make(response, request, options) {
        expectsHttpCodeToBe(
            response.status,
            FORBIDDEN_HTTP_ERROR,
            ForbiddenHttpError.name
        );

        return new ForbiddenHttpError(response, request, options);
    }
}
