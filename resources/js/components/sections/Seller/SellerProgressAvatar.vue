<template>
    <div class="seller-progress-card card is-shadowless mb-1">
        <div class="card-content px-0">
            <div class="has-text-centered">
                <div
                    class="seller-progress-card__progress mx-auto"
                    :style="progressDynamicStyle"
                >
                    <figure
                        class="
                            seller-progress-card__image
                            image
                            is-128x128
                            mx-auto
                        "
                    >
                        <img
                            class="is-rounded"
                            :src="avatarSrc"
                            :alt="avatarAlt"
                        />
                    </figure>
                </div>
                <ParagraphComponent size="large" class="mb-0 mt-2">
                    <strong>{{ avatarTitle }}</strong>
                </ParagraphComponent>
                <ParagraphComponent class="mb-0">
                    {{ avatarSubtitle }}
                </ParagraphComponent>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, defineComponent } from "@vue/runtime-core";
import ParagraphComponent from "@/components/elements/Paragraph/ParagraphComponent.vue";

export default defineComponent({
    components: {
        ParagraphComponent,
    },
    props: {
        avatarTitle: {
            default: null,
            type: String,
        },
        avatarSubtitle: {
            default: null,
            type: String,
        },
        avatarSrc: {
            default:
                "https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50",
            type: String,
        },
        avatarAlt: {
            default: "",
            type: String,
        },
        progressPercentage: {
            default: 50,
            type: Number,
        },
        progressColor: {
            default: "#00b19d",
            type: String,
        },
    },
    setup(props) {
        const percentageToDegs = () => (360 / 100) * props.progressPercentage;

        const progressDynamicStyle = computed(() => ({
            "--progress-bar-color": props.progressColor,
            "--progress-bar-position": `${percentageToDegs()}deg`,
        }));

        return { progressDynamicStyle };
    },
});
</script>

<style lang="scss" scoped>
@import "@/styles/main.scss";
@import "bulma/sass/components/card.sass";

.seller-progress-card {
    & &__progress {
        --progress-bar-position: 190deg;
        --progress-bar-color: #00b19d;

        transition: all 200ms ease-in-out;
        padding: 0.5rem;
        background: conic-gradient(
            var(--progress-bar-color) 0deg var(--progress-bar-position),
            #e5e5e5 var(--progress-bar-position) 360deg
        );
        max-width: min-content;
        border-radius: 99999px;
    }
}
</style>
