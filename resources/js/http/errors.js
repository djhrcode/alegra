import { BadRequestHttpError } from "./errors/BadRequestHttpError";
import { ForbiddenHttpError } from "./errors/ForbiddenHttpError";
import { MustAuthenticateHttpError } from "./errors/MustAuthenticateHttpError";
import { NotFoundHttpError } from "./errors/NotFoundHttpError";
import { TokenMismatchHttpError } from "./errors/TokenMismatchHttpError";
import { TooManyRequestsHttpError } from "./errors/TooManyRequestsHttpError";
import { UnprocessableEntityHttpError } from "./errors/UnprocessableEntityHttpError";
import {
    BAD_REQUEST_HTTP_ERROR,
    FORBIDDEN_HTTP_ERROR,
    NOT_FOUND_HTTP_ERROR,
    TOKEN_MISMATCH_HTTP_ERROR,
    TOO_MANY_REQUESTS_HTTP_ERROR,
    UNAUTHORIZED_HTTP_ERROR,
    UNPROCESSABLE_ENTITY_HTTP_ERROR,
} from "./status";

const errorStatusCodesMap = {
    [BAD_REQUEST_HTTP_ERROR]: BadRequestHttpError,
    [UNAUTHORIZED_HTTP_ERROR]: MustAuthenticateHttpError,
    [FORBIDDEN_HTTP_ERROR]: ForbiddenHttpError,
    [NOT_FOUND_HTTP_ERROR]: NotFoundHttpError,
    [TOKEN_MISMATCH_HTTP_ERROR]: TokenMismatchHttpError,
    [UNPROCESSABLE_ENTITY_HTTP_ERROR]: UnprocessableEntityHttpError,
    [TOO_MANY_REQUESTS_HTTP_ERROR]: TooManyRequestsHttpError,
};

/**
 * @param {number} statusCode
 * @param {Response} response
 * @param {Request} request
 * @param {import("ky").NormalizedOptions} options
 */
export const throwCorrespondingError = (
    statusCode,
    request,
    options,
    response
) => {
    if (statusCode in errorStatusCodesMap)
        throw new errorStatusCodesMap[statusCode](response, request, options);
};
