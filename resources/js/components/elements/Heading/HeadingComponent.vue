<template>
    <component :is="dynamicElement" :class="dynamicClasses">
        <slot></slot>
    </component>
</template>

<script>
import { computed, defineComponent, readonly } from "vue";

const possibleElementsMap = readonly({
    h1: "h1",
    h2: "h2",
    h3: "h3",
    h4: "h4",
    h5: "h5",
    h6: "h6",
});

const possibleSizesMap = readonly({
    1: "is-h1",
    2: "is-h2",
    3: "is-h3",
    4: "is-h4",
    5: "is-h5",
    6: "is-h6",
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
            default: null,
            validator: (value) =>
                value === null || possibleElements.includes(value),
        },
        size: {
            type: [String, Number],
            default: 4,
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
        const dynamicElement = computed(() => {
            if (props.element) return possibleElementsMap[props.element];

            return possibleElementsMap[`h${props.size}`];
        });

        const dynamicClasses = computed(() => ({
            heading: true,
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

$heading-font-family: $family-primary !default;
$heading-font-weight: 500 !default;
$heading-font-size: 1.875rem !default;
$heading-color: $dark !default;

$heading-colors: $custom-colors !default;
$heading-sizes: (
    h1: 3.75rem,
    h2: 3rem,
    h3: 2.25rem,
    h4: 1.875rem,
    h5: 1.5rem,
    h6: 1.125rem,
) !default;

.heading {
    color: $heading-color;
    font-family: $heading-font-family;
    font-size: $heading-font-size;
    font-weight: $heading-font-weight;
    line-height: 1.2;
    margin-bottom: 1.875rem;

    @each $level, $heading-size-value in $heading-sizes {
        &.is-#{$level} {
            font-size: $heading-size-value;
        }
    }

    @each $color, $heading-color-value in $heading-colors {
        &.is-#{$color} {
            color: $heading-color-value;
        }
    }
}
</style>
