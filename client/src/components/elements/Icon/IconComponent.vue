<template>
    <span :class="dynamicClasses" role="text">
        <i :class="iconDynamicClasses" role="img"></i>
    </span>
</template>

<script>
import { computed, defineComponent, readonly } from "vue";

const iconPackClass = "las";
const iconPackPrefix = "la-";

const iconPackSizesMap = readonly({
    small: "",
    normal: "la-lg",
    medium: "la-2x",
    large: "la-2x",
});

const possibleSizesMap = readonly({
    small: "is-small",
    normal: "is-normal",
    medium: "is-medium",
    large: "is-large",
});

const possibleColorsMap = readonly({
    primary: "is-primary",
    secondary: "is-secondary",
    dark: "is-dark",
    light: "is-light",
});

const possibleSizes = Object.keys(possibleSizesMap);
const possibleColors = Object.keys(possibleColorsMap);

export default defineComponent({
    props: {
        name: {
            type: String,
            default: "thumb-up",
        },
        isRight: {
            type: Boolean,
            default: false,
        },
        isLeft: {
            type: Boolean,
            default: false,
        },
        size: {
            type: String,
            default: "normal",
            validator: (value) =>
                possibleSizes.some((possible) => possible == value),
        },
        color: {
            type: String,
            default: null,
            validator: (value) =>
                value === null || possibleColors.includes(value),
        },
    },
    setup(props) {
        const dynamicClasses = computed(() => ({
            icon: true,
            "is-left": props.isLeft,
            "is-right": props.isRight,
            [possibleSizesMap[props.size]]: Boolean(props.size),
            [possibleColorsMap[props.color]]: Boolean(props.color),
        }));

        const iconDynamicClasses = computed(() => ({
            [iconPackClass]: true,
            [iconPackPrefix + props.name]: true,
            [iconPackSizesMap[props.size]]: true,
        }));

        return {
            dynamicClasses,
            iconDynamicClasses,
        };
    },
});
</script>

<style lang="scss" scoped>
@import "@/styles/main.scss";

$icon-colors: $custom-colors !default;

.icon {
    @each $color, $icon-color-value in $custom-colors {
        &.is-#{$color} {
            color: $icon-color-value;
        }
    }
}
</style>
