import { createJsonDataResponse, useHttpClient } from "@/libs/http";
import { createSeller } from "./Seller";
import { createImageUrls, createSellerImage } from "./SellerImage";

export const useSellerService = () => {
    const search = async ({
        query = String(),
        page = Number(),
        perPage = Number(),
    }) => {
        const response = await useHttpClient()
            .get("sellers/images", { searchParams: { query, page } })
            .json();

        return createJsonDataResponse(response).data.map(
            ({ urls, seller, ...image }) =>
                createSellerImage({
                    urls: createImageUrls(urls),
                    seller: createSeller(seller),
                    ...image,
                })
        );
    };

    const upVote = async (sellerId = String()) => {
        const response = await useHttpClient()
            .put(`sellers/${sellerId}/upvote`)
            .json();

        return createJsonDataResponse(response).data.map(
            ({ urls, seller, ...image }) =>
                createSellerImage({
                    urls: createImageUrls(urls),
                    seller: createSeller(seller),
                    ...image,
                })
        );
    };

    return { search, upVote };
};
