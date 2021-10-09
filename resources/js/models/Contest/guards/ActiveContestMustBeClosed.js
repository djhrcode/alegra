import { Routes } from "@/plugins/router";
import { createNavigationGuard } from "@/router/helpers/guards";
import { useContestClient } from "../ContestClient";

export const ActiveContestMustBeClosed = createNavigationGuard(
    async (to, from, next) => {
        const activeContest = await useContestClient().getActiveContest();

        if (activeContest.status === "closed") {
            return next();
        }

        return next({ name: Routes.Welcome });
    }
);
