import { HTTPError } from "ky";
import { expectsHttpCodeToBe, BAD_REQUEST_HTTP_ERROR } from "../status";

export class BadRequestHttpError extends HTTPError {
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
            BAD_REQUEST_HTTP_ERROR,
            BadRequestHttpError.name
        );

        return new BadRequestHttpError(response, request, options);
    }
}
