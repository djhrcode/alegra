import { createSeller } from "../Seller/Seller";

export const createContestResults = ({
    position = Number(),
    seller = createSeller({}),
}) => ({ position, seller });
