import { createJsonDataResponse, useHttpClient } from "@/helpers/http.js";
import { createSeller } from "./Seller.js";
import { createImageUrls, createSellerImage } from "./SellerImage.js";

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
            .post(`sellers/${sellerId}/upvote`)
            .json();

        return createSeller(createJsonDataResponse(response).data);
    };

    return { search, upVote };
};
