export const BAD_REQUEST_HTTP_ERROR = 401;

export const UNAUTHORIZED_HTTP_ERROR = 401;

export const FORBIDDEN_HTTP_ERROR = 403;

export const NOT_FOUND_HTTP_ERROR = 404;

export const TOKEN_MISMATCH_HTTP_ERROR = 419;

export const UNPROCESSABLE_ENTITY_HTTP_ERROR = 422;

export const TOO_MANY_REQUESTS_HTTP_ERROR = 429;

export const expectsHttpCodeToBe = (statusCode, expected, className) => {
    if (statusCode !== expected)
        throw new TypeError(className + " must have an equivalent status code");
};
