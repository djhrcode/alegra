import { createSeller } from "../Seller/Seller";

export const createContestResults = ({
    position = Number(),
    seller = createSeller({}),
}) => ({ position, seller });

export const createContest = ({
    id = Number(),
    status = String(),
    name = String(),
    total_points = Number(),
    invoice_url = String(),
}) => ({ id, status, name, total_points, invoice_url });
