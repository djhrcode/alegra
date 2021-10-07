import { expectsHttpCodeToBe, NOT_FOUND_HTTP_ERROR } from "../status";

export class NotFoundHttpError extends HTTPError {
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
            NOT_FOUND_HTTP_ERROR,
            NotFoundHttpError.name
        );

        return new NotFoundHttpError(response, request, options);
    }
}
