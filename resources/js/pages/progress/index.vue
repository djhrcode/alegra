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
            <div class="has-text-centered mb-6" style="max-width: 580px">
                <HeadingComponent :size="3" class="has-text-centered">
                    Así van los participantes :)
                </HeadingComponent>
                <ParagraphComponent size="large" class="has-text-centered">
                    Debajo puedes ver el progreso de las votaciones. Puedes
                    seguir buscando y votando las imágenes que más te gusten.
                </ParagraphComponent>
                <ButtonComponent
                    class="mx-auto mt-2 px-4"
                    size="medium"
                    to="/explore"
                    icon-right="la-search"
                    >Seguir buscando</ButtonComponent
                >
            </div>
            <div class="grid is-3-columns-desktop is-1-columns-mobile is-2-columns-touch mt-6" style="max-width: 980px; width: 100%">
                <SellerProgressAvatar
                    v-for="(sellerResult, index) in sellerResultsListState"
                    :key="index"
                    :avatar-src="sellerResult.seller.avatar"
                    :avatar-title="sellerResult.seller.name"
                    :avatar-subtitle="`${sellerResult.seller.total_points} puntos`"
                    :progress-percentage="(sellerResult.seller.total_points / sellerResult.seller.winning_points) * 100"
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
import { createContestResults } from "@/models/Contest/ContestFactories";

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

        const sellerResultsListState = ref([].map(createContestResults));
        const isSellerResultsLoadingState = ref(false);

        const sellersResultsListIsEmpty = computed(
            () => !!sellerResultsListState.value.length
        );

        contestClient
            .getContestResults()
            .then((results) => (sellerResultsListState.value = results));

        const heroSectionStyle = computed(() => ({
            transition: "all 300ms ease-in-out",
            minHeight: sellersResultsListIsEmpty.value ? "400px" : "60vh",
            paddingBottom: sellersResultsListIsEmpty.value ? "6rem" : "3rem",
        }));

        return {
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
