<template>
    <div class="card is-shadowless mb-1">
        <div class="card-image">
            <figure class="image">
                <img
                    :src="pictureSrc"
                    style="border-radius: 10px"
                    alt="Placeholder image"
                />
            </figure>
        </div>
        <div class="card-content px-0">
            <div class="media">
                <div class="media-left">
                    <figure class="image is-48x48">
                        <img
                            class="is-rounded"
                            :src="avatarSrc"
                            :alt="avatarAlt"
                        />
                    </figure>
                </div>
                <div class="media-content">
                    <p class="title is-4 mb-0">{{ avatarTitle }}</p>
                    <p class="mt-0 has-text-weight-light is-size-7">
                        {{ avatarSubtitle }}
                    </p>
                </div>
                <div class="media-right">
                    <ButtonComponent
                        @click="$emit('upvoate')"
                        icon-right="thumbs-up"
                        :is-disabled="isDisabled"
                    >
                        Upvote
                    </ButtonComponent>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ButtonComponent from "@/components/elements/Button/ButtonComponent.vue";
import { defineComponent } from "@vue/runtime-core";

export default defineComponent({
    emits: ["upvote"],
    components: {
        ButtonComponent,
    },
    props: {
        pictureAspectRatio: {
            default: null,
            type: String,
        },
        pictureSrc: {
            default: "https://bulma.io/images/placeholders/1280x960.png",
            type: String,
        },
        pictureAlt: {
            default: null,
            type: String,
        },
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
            default: null,
            type: String,
        },
        isDisabled: {
            default: false,
            type: Boolean,
        },
    },
});
</script>

<style lang="scss" scoped>
@import "@/styles/main.scss";
@import "bulma/sass/components/card.sass";
</style>
