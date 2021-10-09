import { useHttpClient } from "@/helpers/http";
import { createCollectionResponse } from "@/http/responses/CollectionResponse";
import { createContest, createContestResults } from "./ContestFactories";

export function useContestClient() {
    const httpApiClient = useHttpClient();

    function getContestResults() {
        return httpApiClient
            .get("contests/active/results")
            .then((response) => response.json())
            .then(createCollectionResponse)
            .then((collection) => collection.data.map(createContestResults));
    }

    function getActiveContest() {
        return httpApiClient
            .get("contests/active")
            .then((response) => response.json())
            .then(({ data }) => createContest(data));
    }

    function resetActiveContest() {
        return httpApiClient
            .post("contests/active/reset")
            .then((response) => response.json());
    }

    return { getContestResults, getActiveContest, resetActiveContest };
}
