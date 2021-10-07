import { expectsHttpCodeToBe, UNAUTHORIZED_HTTP_ERROR } from "../status";

export class MustAuthenticateHttpError extends HTTPError {
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
            UNAUTHORIZED_HTTP_ERROR,
            MustAuthenticateHttpError.name
        );

        return new MustAuthenticateHttpError(response, request, options);
    }
}
