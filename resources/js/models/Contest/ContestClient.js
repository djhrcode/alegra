import { useHttpClient } from "@/helpers/http";
import { createCollectionResponse } from "@/http/responses/CollectionResponse";
import { createContestResults } from "./ContestFactories";

export function useContestClient() {
    const httpApiClient = useHttpClient();

    function getContestResults() {
        return httpApiClient
            .get("contests/active/results")
            .then((response) => response.json())
            .then(createCollectionResponse)
            .then((collection) => collection.data.map(createContestResults));
    }

    return { getContestResults };
}
