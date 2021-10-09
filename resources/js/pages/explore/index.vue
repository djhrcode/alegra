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
            <div style="max-width: 580px">
                <HeadingComponent :size="3" class="has-text-centered">
                    ¡Ayúdanos a encontrar las mejores imágenes del mundo!
                </HeadingComponent>
                <ParagraphComponent size="large" class="has-text-centered">
                    Ingresa un palabra, busca y vota la imagen que más te guste
                </ParagraphComponent>
            </div>
            <div style="max-width: 720px; width: 100%">
                <SearchInput
                    :is-loading="isSearchLoadingState"
                    @search="searchPictureByQuery"
                ></SearchInput>
            </div>
        </div>
        <masonry class="mt-6 is-fullwidth" :cols="3" :gutter="24">
            <SellerImageCard
                v-for="(image, index) in imagesListState"
                :key="index"
                :is-disabled="areUpvoteButtonsDisabledState"
                :picture-src="image.urls.small"
                :picture-alt="image.description"
                :avatar-src="image.seller.avatar"
                :avatar-title="image.seller.name"
                :avatar-subtitle="`${image.seller.total_points} puntos, ${image.seller.remaining_points} para ganar`"
                :style="getSellerImageCardStyle(index)"
                @upvote="() => upvotePictureBySellerId(image.seller.id, index)"
            ></SellerImageCard>
        </masonry>
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
import { useContestClient } from "@/models/Contest/ContestClient";
import { Routes } from "@/plugins/router";
import { useRouter } from "vue-router";

export default defineComponent({
    components: {
        SellerImageCard,
        HeadingComponent,
        ParagraphComponent,
        SearchInput,
    },

    setup() {
        const router = useRouter();

        const sellerService = useSellerService();
        const notificationStore = useNotificationStore();
        const contestClient = useContestClient();

        /**
         * Upvote business logic
         */
        const upvotingHasStarted = ref(false);
        const upvotingHasErrored = ref(false);
        const upvotingHasFinished = ref(false);
        const lastIndexUpvoted = ref(null);

        const areUpvoteButtonsDisabledState = computed(
            () => upvotingHasStarted.value || upvotingHasFinished.value
        );

        /**
         * Image searching business logic
         */

        const searchInputQuery = ref(false);
        const imagesListState = ref([]);
        const isSearchLoadingState = ref(false);

        const imagesListIsEmpty = computed(
            () => !!imagesListState.value.length
        );

        const startSearchLoading = () => (isSearchLoadingState.value = true);
        const stopSearchLoading = () => (isSearchLoadingState.value = false);

        const resetUpvotingProcess = () => {
            upvotingHasStarted.value = false;
            upvotingHasFinished.value = false;
            upvotingHasErrored.value = false;
            lastIndexUpvoted.value = null;
        };

        const startUpvotingProcess = () => {
            upvotingHasStarted.value = true;
            upvotingHasFinished.value = false;
        };

        const finishUpvotingProcess = (index = null) => {
            upvotingHasFinished.value = true;
            lastIndexUpvoted.value = index;

            notificationStore.notify(
                createNotification({
                    delay: 6000,
                    title: "¡Super! A nosotros también nos encanta esa imagen",
                    message:
                        "Tu voto se ha realizado exitosamente. Haz una nueva busqueda para votar otra vez",
                })
            );
        };

        const stopWithErrorUpvotingProcess = (error) => {
            upvotingHasErrored.value = true;
            upvotingHasStarted.value = false;
            upvotingHasFinished.value = false;

            notificationStore.notify(
                createNotification({
                    delay: 6000,
                    color: "danger",
                    title: "Ups, algo no salió bien :(",
                    message:
                        "Ha ocurrido un error en tu voto, por favor inténtalo de nuevo",
                })
            );

            throw error;
        };

        const hydrateSellerImageState = (index, newSellerData) => {
            const currentSellerState = createSellerImage(
                imagesListState.value[index]
            );

            const newSellerState = createSellerImage({
                ...currentSellerState,
                seller: newSellerData,
            });

            imagesListState.value.splice(index, 1, newSellerState);
        };

        const checkIfContestHasFinished = async () => {
            const contest = await contestClient.getActiveContest();

            if (contest.status === "closed")
                router.push({ name: Routes.Finished });
        };

        const upvotePictureBySellerId = (sellerId, index) => {
            startUpvotingProcess();

            return sellerService
                .upVote(sellerId)
                .then(hydrateSellerImageState.bind(null, index))
                .then(finishUpvotingProcess.bind(null, index))
                .then(checkIfContestHasFinished)
                .catch(stopWithErrorUpvotingProcess);
        };

        const searchPictureByQuery = async (query) => {
            resetUpvotingProcess();
            startSearchLoading();

            imagesListState.value = await sellerService
                .search({ query })
                .finally(stopSearchLoading);

            if (imagesListState.value.length) return;

            notificationStore.notify({
                delay: 6000,
                color: "accent",
                title: "Mmm, no hemos encontrado nada para esta busqueda",
                message:
                    "Intenta realizar otra búsqueda nuevamente ",
            });
        };

        const heroSectionStyle = computed(() => ({
            transition: "all 300ms ease-in-out",
            minHeight: imagesListIsEmpty.value ? "400px" : "60vh",
            paddingBottom: imagesListIsEmpty.value ? "6rem" : "3rem",
        }));

        const getSellerImageCardStyle = (index) => {
            if (!Number.isInteger(lastIndexUpvoted.value)) return {};
            if (!upvotingHasFinished.value) return {};

            return {
                opacity: index === lastIndexUpvoted.value ? 1 : 0.5,
                filter: index === lastIndexUpvoted.value ? "" : "blur(10px)",
            };
        };

        return {
            searchInputQuery,
            imagesListState,
            imagesListIsEmpty,
            heroSectionStyle,
            lastIndexUpvoted,
            getSellerImageCardStyle,

            isSearchLoadingState,
            areUpvoteButtonsDisabledState,

            searchPictureByQuery,
            upvotePictureBySellerId,
        };
    },
});
</script>

<style></style>
