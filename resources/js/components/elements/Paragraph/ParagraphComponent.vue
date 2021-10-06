<template>
    <component :is="dynamicElement" :class="dynamicClasses" role="textbox">
        <slot></slot>
    </component>
</template>

<script>
import { computed, defineComponent, readonly } from "vue";

const possibleElementsMap = readonly({
    span: "span",
    paragraph: "p"
});

const possibleSizesMap = readonly({
    small: "is-small",
    normal: "is-normal",
    large: "is-large",
});

const possibleColorsMap = readonly({
    primary: "is-primary",
    secondary: "is-secondary",
    dark: "is-dark",
    light: "is-light",
});

const possibleElements = Object.keys(possibleElementsMap);
const possibleSizes = Object.keys(possibleSizesMap);
const possibleColors = Object.keys(possibleColorsMap);

export default defineComponent({
    props: {
        element: {
            type: String,
            default: "paragraph",
            validator: (value) =>
                value === null || possibleElements.includes(value),
        },
        size: {
            type: String,
            default: "normal",
            validator: (value) =>
                possibleSizes.some((possible) => possible == value),
        },
        color: {
            type: String,
            default: "dark",
            validator: (value) => possibleColors.includes(value),
        },
    },
    setup(props) {
        const dynamicElement = computed(() =>  possibleElementsMap[props.element] );

        const dynamicClasses = computed(() => ({
            paragraph: true,
            [possibleColorsMap[props.color]]: Boolean(props.color),
            [possibleSizesMap[props.size]]: Boolean(props.size),
            [possibleElementsMap[props.element]]: Boolean(props.element),
        }));

        return {
            dynamicElement,
            dynamicClasses,
        };
    },
});
</script>

<style lang="scss" scoped>
@import "@/styles/main.scss";

$paragraph-font-family: $family-primary !default;
$paragraph-font-weight: 300 !default;
$paragraph-font-size: 1rem !default;
$paragraph-color: $dark !default;

$paragraph-colors: $custom-colors !default;
$paragraph-sizes: (
    small: 0.875rem,
    normal: 1rem,
    large: 1.125rem,
) !default;

.paragraph {
    color: $paragraph-color;
    font-family: $paragraph-font-family;
    font-size: $paragraph-font-size;
    font-weight: $paragraph-font-weight;
    line-height: 1.4;
    margin-bottom: 1.5rem;

    @each $level, $paragraph-size-value in $paragraph-sizes {
        &.is-#{$level} {
            font-size: $paragraph-size-value;
        }
    }

    @each $color, $paragraph-color-value in $paragraph-colors {
        &.is-#{$color} {
            color: $paragraph-color-value;
        }
    }

    strong, span, del, mark {
        font-size: inherit !important;
        font-family: inherit !important;
        color: inherit !important;
    }  
}
</style>
