export const createUser = ({
    id = String(),
    name = String(),
    email = String(),
}) => ({ id, name, email });

export const createCredentials = ({
    email = String(),
    password = String(),
}) => ({ email, password });

export const createAuthenticable = ({
    name = String(),
    email = String(),
    password = String(),
    password_confirm = String(),
}) => ({ name, email, password, password_confirm });

export const createAuthenticationState = ({
    status = Boolean(),
    account = createUser({}),
}) => ({ status, account });

export const createBearerToken = ({
    token_type = String(),
    access_token = String(),
}) => ({ token_type, access_token });
