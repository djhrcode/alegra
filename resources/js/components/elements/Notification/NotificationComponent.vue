<template>
    <div :class="dynamicClasses">
        <ButtonComponent
            class="delete px-1"
            icon="la-times"
            type="inverted"
            color="dark"
            is-rounded
            size="small"
            @click="$emit('close')"
        ></ButtonComponent>
        <p v-if="title" class="m-0">
            <strong>{{ title }}</strong>
        </p>
        <p v-if="message" class="m-0 has-text-weight-light">{{ message }}</p>
    </div>
</template>

<script>
import { computed, defineComponent, markRaw, readonly } from "vue";
import ButtonComponent from "../Button/ButtonComponent.vue";
import ParagraphComponent from "../Paragraph/ParagraphComponent.vue";

const possibleColorsMap = readonly({
    primary: "is-primary",
    secondary: "is-secondary",
    success: "is-success",
    danger: "is-danger",
    warning: "is-warning",
});

const possibleColors = Object.keys(possibleColorsMap);

export default defineComponent({
    components: { ButtonComponent, ParagraphComponent },
    emits: ['close'],
    props: {
        message: {
            type: String,
            default: null,
        },
        title: {
            type: String,
            default: null,
        },
        color: {
            type: String,
            default: "primary",
            validator: (value) => possibleColors.includes(value),
        },
        isLight: {
            type: Boolean,
            default: false,
        },
        isFixed: {
            type: Boolean,
            default: false,
        },
    },
    setup(props) {
        const dynamicClasses = computed(() => ({
            notification: true,
            "is-fixed": props.isFixed,
            "is-light": props.isLigh,
            [possibleColorsMap[props.color]]: Boolean(props.color),
        }));

        return {
            dynamicClasses,
        };
    },
});
</script>

<style lang="scss" scoped>
@import "@/styles/main.scss";
@import "bulma/sass/elements/notification.sass";

.notification {
    transition: all 200ms ease-in-out;
}
</style>
