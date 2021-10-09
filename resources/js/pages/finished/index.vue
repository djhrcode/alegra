<template>
    <div
        class="
            is-flex is-flex-direction-column is-align-items-center is-fullwidth
        "
    >
        <div
            class="
                pt-6
                is-flex
                is-fullwidth
                is-flex-direction-column
                is-align-items-center
                is-justify-content-center
            "
            :style="heroSectionStyle"
        >
            <div
                v-if="winnerSeller.seller"
                class="has-text-centered mb-6"
                style="max-width: 580px"
            >
                <SellerProgressAvatar
                    progress-color="#ff9f03"
                    :avatar-src="winnerSeller.seller.avatar"
                    :avatar-title="winnerSeller.seller.name"
                    :avatar-subtitle="`${winnerSeller.seller.total_points} puntos acumulados`"
                    :progress-percentage="
                        (winnerSeller.seller.total_points /
                            winnerSeller.seller.winning_points) *
                        100
                    "
                ></SellerProgressAvatar>
                <HeadingComponent :size="3" class="has-text-centered">
                    ¡{{ winnerSeller.seller.name }} ha ganado!
                </HeadingComponent>
                <ParagraphComponent size="large" class="has-text-centered">
                    {{ winnerSeller.seller.name }} a demostrado tener las
                    imágenes más asombrosas e increibles del mundo alcanzando un
                    total de 200 puntos.
                </ParagraphComponent>
                <ParagraphComponent size="large" class="has-text-centered">
                    Agradecemos a todos los participantes por su esfuerzo y
                    aquellos votantes que nos ayudaron a conseguir las mejores
                    imágenes.
                </ParagraphComponent>
                <ButtonComponent
                    class="mx-auto mt-2 px-4"
                    size="medium"
                    icon-right="la-file-alt"
                    target="_blank"
                    :href="contestFinished.invoice_url"
                    :is-loading="isStateLoading"
                    >Ver factura generada</ButtonComponent
                >
                <ButtonComponent
                    class="mx-auto mt-2 px-4"
                    color="danger"
                    size="medium"
                    type="inverted"
                    icon-right="la-redo-alt"
                    :is-loading="isStateLoading"
                    @click="onClickResetButton"
                    >Reiniciar concurso</ButtonComponent
                >
            </div>
            <div
                class="
                    grid
                    is-3-columns-desktop is-1-columns-mobile is-2-columns-touch
                    mt-6
                "
                style="max-width: 980px; width: 100%"
            >
                <SellerProgressAvatar
                    v-for="(sellerResult, index) in sellerPositionsFromSecond"
                    :key="index"
                    :avatar-src="sellerResult.seller.avatar"
                    :avatar-title="sellerResult.seller.name"
                    :avatar-subtitle="`${sellerResult.seller.total_points} puntos`"
                    :progress-percentage="
                        (sellerResult.seller.total_points /
                            sellerResult.seller.winning_points) *
                        100
                    "
                ></SellerProgressAvatar>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, defineComponent, onMounted, ref } from "@vue/runtime-core";
import HeadingComponent from "@/components/elements/Heading/HeadingComponent.vue";
import ParagraphComponent from "@/components/elements/Paragraph/ParagraphComponent.vue";
import SellerImageCard from "@/components/sections/Seller/SellerImageCard.vue";
import SearchInput from "@/components/sections/Search/SearchInput.vue";
import { useSellerService } from "@/models/Seller/SellerService.js";
import { useNotificationStore } from "@/models/Notification/NotificationStore";
import { createNotification } from "@/models/Notification/NotificationFactories";
import { createSellerImage } from "@/models/Seller/SellerImage";
import ButtonComponent from "@/components/elements/Button/ButtonComponent.vue";
import { useContestClient } from "@/models/Contest/ContestClient";
import SellerProgressAvatar from "@/components/sections/Seller/SellerProgressAvatar.vue";
import {
    createContest,
    createContestResults,
} from "@/models/Contest/ContestFactories";
import { useRouter } from "vue-router";
import { Routes } from "@/plugins/router";

export default defineComponent({
    components: {
        SellerImageCard,
        HeadingComponent,
        ParagraphComponent,
        ButtonComponent,
        SearchInput,
        SellerProgressAvatar,
    },

    setup() {
        const contestClient = useContestClient();
        const notificationStore = useNotificationStore();
        const router = useRouter();

        const contestFinished = ref(createContest({}));
        const sellerResultsListState = ref([].map(createContestResults));
        const isSellerResultsLoadingState = ref(false);
        const isStateLoading = ref(false);

        const startLoadingState = () => (isStateLoading.value = true);
        const stopLoadingState = () => (isStateLoading.value = false);

        const winnerSeller = computed(
            () => sellerResultsListState.value.slice(0, 1)[0] ?? {}
        );

        const sellerPositionsFromSecond = computed(() =>
            sellerResultsListState.value.slice(1)
        );

        const sellersResultsListIsEmpty = computed(
            () => !!sellerResultsListState.value.length
        );

        const hydrateOrderedResults = (results) => {
            sellerResultsListState.value = results.sort(
                (sellerA, sellerB) => sellerA.position - sellerB.position
            );
        };

        contestClient.getContestResults().then(hydrateOrderedResults);

        contestClient
            .getActiveContest()
            .then((contest) => (contestFinished.value = contest));

        const heroSectionStyle = computed(() => ({
            transition: "all 300ms ease-in-out",
            minHeight: sellersResultsListIsEmpty.value ? "400px" : "60vh",
            paddingBottom: sellersResultsListIsEmpty.value ? "6rem" : "3rem",
        }));

        const onClickResetButton = () => {
            startLoadingState();

            contestClient
                .resetActiveContest()
                .then(() =>
                    notificationStore.notify({
                        delay: 6000,
                        title: "¡El concurso se ha reiniciado exitosamente!",
                    })
                )
                .then(() => router.push({ name: Routes.Welcome }))
                .catch(() =>
                    notificationStore.notify({
                        color: "danger",
                        delay: 6000,
                        title: "Eeeh, esto es muy vergonzoso",
                        description:
                            "No hemos podido reiniciar el concurso, intenta otra vez",
                    })
                )
                .finally(stopLoadingState);
        };

        return {
            contestFinished,
            onClickResetButton,
            isStateLoading,
            winnerSeller,
            sellerPositionsFromSecond,
            heroSectionStyle,
            sellerResultsListState,
        };
    },
});
</script>

<style lang="scss">
.seller-progress-card {
    & &__progress {
        --progress-bar-position: 190deg;

        transition: all 200ms ease-in-out;
        padding: 0.5rem;
        background: conic-gradient(
            #00b19d 0deg var(--progress-bar-position),
            #e5e5e5 var(--progress-bar-position) 360deg
        );
        max-width: min-content;
        border-radius: 99999px;
    }
}
</style>
