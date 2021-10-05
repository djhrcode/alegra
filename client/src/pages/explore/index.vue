<template>
    <div
        class="
            is-flex is-flex-direction-column is-align-items-center is-fullwidth
        "
    >
        <div
            class="
                pt-6 is-flex
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
                :picture-src="image.urls.regular"
                :picture-alt="image.description"
                :avatar-src="image.seller.avatar"
                :avatar-title="image.seller.name"
                :avatar-subtitle="`${image.seller.total_points} puntos acumulados de 20`"
                @upvote="() => upvotePictureBySellerId(image.seller.id)"
            ></SellerImageCard>
        </masonry>
    </div>
</template>

<script>
import { computed, defineComponent, onMounted, ref } from "@vue/runtime-core";
import HeadingComponent from "@/components/elements/Heading/HeadingComponent.vue";
import ParagraphComponent from "@/components/elements/Paragraph/ParagraphComponent.vue";
import SellerImageCard from "@/components/sections/Picture/SellerImageCard.vue";
import SearchInput from "@/components/sections/Search/SearchInput.vue";
import { useSellerService } from "@/models/Seller/SellerService";

export default defineComponent({
    components: {
        SellerImageCard,
        HeadingComponent,
        ParagraphComponent,
        SearchInput,
    },

    setup() {
        const sellerService = useSellerService();

        const imagesListState = ref([]);
        const currentPageState = ref(0);

        const isSearchLoadingState = ref(false);
        const areUpvoteButtonsDisabledState = ref(false);

        const imagesListIsEmpty = computed(() => !!(imagesListState.value.length));

        const startSearchLoading = () => (isSearchLoadingState.value = true);
        const stopSearchLoading = () => (isSearchLoadingState.value = false);

        const markUpvoteButtonsAsDisabled = () =>
            (areUpvoteButtonsDisabledState.value.value = true);

        const unmarkUpvoteButtonsAsDisabled = () =>
            (areUpvoteButtonsDisabledState.value.value = false);

        const searchPictureByQuery = async (query) => {
            startSearchLoading();

            imagesListState.value = await sellerService
                .search({
                    query,
                    page: currentPageState.value++,
                })
                .finally(stopSearchLoading);
        };

        const upvotePictureBySellerId = async (sellerId) => {
            markUpvoteButtonsAsDisabled();

            await sellerService
                .upVote(sellerId)
                .finally(unmarkUpvoteButtonsAsDisabled);
        };

        const heroSectionStyle = computed(() => ({
            transition: 'all 300ms ease-in-out',
            minHeight: imagesListIsEmpty.value ? '400px' : '60vh',
            paddingBottom: imagesListIsEmpty.value ? '6rem' : '3rem'
        }));

        return {
            imagesListState,
            imagesListIsEmpty,
            heroSectionStyle,

            isSearchLoadingState,
            areUpvoteButtonsDisabledState,

            searchPictureByQuery,
            upvotePictureBySellerId,
        };
    },
});
</script>

<style></style>
