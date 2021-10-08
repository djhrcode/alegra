import { HTTPError } from "ky";
import { expectsHttpCodeToBe, UNPROCESSABLE_ENTITY_HTTP_ERROR } from "../status";

export class UnprocessableEntityHttpError extends HTTPError {
    /**
     * @param {Response} response
     * @param {Request} request
     * @param {import("ky").NormalizedOptions} options
     */
    constructor(response, request, options) {
        super(response, request, options);
    }

    json() {
        return createValidationErrorResponse(this.response.json());
    }

    /**
     * @param {Response} response
     * @param {Request} request
     * @param {import("ky").NormalizedOptions} options
     */
    static make(response, request, options) {
        expectsHttpCodeToBe(
            response.status,
            UNPROCESSABLE_ENTITY_HTTP_ERROR,
            UnprocessableEntityHttpError.name
        );

        return new UnprocessableEntityHttpError(response, request, options);
    }
}
