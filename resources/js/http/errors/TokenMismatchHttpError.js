import { expectsHttpCodeToBe, TOKEN_MISMATCH_HTTP_ERROR } from "../status";

export class TokenMismatchHttpError extends HTTPError {
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
            TOKEN_MISMATCH_HTTP_ERROR,
            TokenMismatchHttpError.name
        );

        return new TokenMismatchHttpError(response, request, options);
    }
}
