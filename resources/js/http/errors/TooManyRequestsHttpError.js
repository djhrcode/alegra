import { expectsHttpCodeToBe, TOO, TOO_MANY_REQUESTS_HTTP_ERROR_MANY_REQUESTS_HTTP_ERROR } from "../status";

export class TooManyRequestsHttpError extends HTTPError {
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
            TOO_MANY_REQUESTS_HTTP_ERROR,
            TooManyRequestsHttpError.name
        );

        return new TooManyRequestsHttpError(response, request, options);
    }
}
