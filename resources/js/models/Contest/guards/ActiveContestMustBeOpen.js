import { createNotification } from "@/models/Notification/NotificationFactories";
import { useNotificationStore } from "@/models/Notification/NotificationStore";
import { Routes } from "@/plugins/router";
import { store } from "@/plugins/store";
import { createNavigationGuard } from "@/router/helpers/guards";
import { useContestClient } from "../ContestClient";

export const ActiveContestMustBeOpen = createNavigationGuard(
    async (to, from, next) => {
        const activeContest = await useContestClient().getActiveContest();

        if (activeContest.status === "open") {
            return next();
        }

        useNotificationStore(store).notify(
            createNotification({
                delay: 10000,
                color: "warning",
                title: "El concurso ya ha finalizado",
                message: "Por favor, reiniciélo para seguir votando",
            })
        );

        return next({ name: Routes.Finished });
    }
);
