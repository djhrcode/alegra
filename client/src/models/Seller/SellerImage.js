import { createSeller } from "./Seller";

export const createImageUrls = ({
    full = String(),
    regular = String(),
    small = String(),
    thumb = String(),
}) => ({
    full,
    regular,
    small,
    thumb,
});

export const createSellerImage = ({
    id = String(),
    description = String(),
    width = Number(),
    height = Number(),
    color = String(),
    urls = createImageUrls(),
    seller = createSeller()
}) => ({
    id, 
    description,
    width,
    height,
    color,
    urls,
    seller,
});
