import ky from "ky";

export const useHttpClient = () =>
    ky.create({ prefixUrl: import.meta.env.VITE_WORLWIDE_API_URL });

export const createJsonDataResponse = ({ data = [] }) => ({ data });
