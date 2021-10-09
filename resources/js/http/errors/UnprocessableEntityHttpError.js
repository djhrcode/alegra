import { HTTPError } from "ky";
import {
    expectsHttpCodeToBe,
    UNPROCESSABLE_ENTITY_HTTP_ERROR,
} from "../status";

/**
 *
 * @param {{ message: String, errors: {[key:string]: string[]}}} param0
 * @returns
 */
const createValidationErrorResponse = ({
    message = String(),
    errors = {},
}) => ({
    errors,
    message,

    getFirstError() {
        return Object.values(errors)?.at(0)?.at(0) ?? null;
    },

    getFirstErrorFor(field) {
        return errors[field][0] ?? null;
    },
});

export class UnprocessableEntityHttpError extends HTTPError {
    #jsonResponse = null;

    /**
     * @param {Response} response
     * @param {Request} request
     * @param {import("ky").NormalizedOptions} options
     */
    constructor(response, request, options) {
        super(response, request, options);
    }

    async json() {
        if (!this.#jsonResponse)
            this.#jsonResponse = await this.response.json();

        return createValidationErrorResponse(this.#jsonResponse);
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
