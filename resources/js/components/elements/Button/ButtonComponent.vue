<template>
    <component
        :is="dynamicElement"
        :class="dynamicClasses"
        v-bind="{ ...$attrs, ...dynamicAttributes }"
    >
        <IconComponent
            v-if="iconLeft"
            :name="iconLeft"
            :size="size"
        ></IconComponent>
        <IconComponent
            v-if="icon"
            :name="icon"
            :size="size"
        ></IconComponent>
        <span v-if="!icon"><slot></slot></span>
        <IconComponent
            v-if="iconRight"
            :name="iconRight"
            :size="size"
        ></IconComponent>
    </component>
</template>

<script>
import { computed, defineComponent, markRaw, readonly } from "vue";
import { RouterLink } from "vue-router";
import IconComponent from "../Icon/IconComponent.vue";

const possibleElementsMap = readonly({
    router: markRaw(RouterLink),
    link: "a",
    button: "button",
});

const possibleSizesMap = readonly({
    small: "is-small",
    normal: "is-normal",
    medium: "is-medium",
    large: "is-large",
});

const possibleTypesMap = readonly({
    outlined: "is-outlined",
    inverted: "is-inverted",
});

const possibleColorsMap = readonly({
    dark: "is-dark",
    primary: "is-primary",
    secondary: "is-secondary",
    success: "is-success",
    danger: "is-danger",
    warning: "is-warning",
});

const possibleElements = Object.keys(possibleElementsMap);
const possibleSizes = Object.keys(possibleSizesMap);
const possibleTypes = Object.keys(possibleTypesMap);
const possibleColors = Object.keys(possibleColorsMap);

export default defineComponent({
    components: { IconComponent },
    props: {
        href: String,
        to: [String, Object],

        isLoading: {
            type: Boolean,
            default: false,
        },
        isDisabled: {
            type: Boolean,
            default: false,
        },
        isRounded: {
            type: Boolean,
            default: false,
        },
        isFullwidth: {
            type: Boolean,
            default: false,
        },
        element: {
            type: String,
            default: "button",
            validator: (value) => possibleElements.includes(value),
        },
        icon: {
            type: String,
            default: null,
        },
        iconRight: {
            type: String,
            default: null,
        },
        iconLeft: {
            type: Boolean,
            default: null,
        },
        size: {
            type: String,
            default: "normal",
            validator: (value) => possibleSizes.includes(value),
        },
        type: {
            type: String,
            default: null,
            validator: (value) =>
                value === null || possibleTypes.includes(value),
        },
        color: {
            type: String,
            default: "primary",
            validator: (value) => possibleColors.includes(value),
        },
    },
    setup(props, context) {
        const dynamicElement = computed(() => {
            if (props.href) return possibleElementsMap.link;
            if (props.to) return possibleElementsMap.router;

            return possibleElementsMap[props.element];
        });

        const dynamicClasses = computed(() => ({
            button: true,
            "is-rounded": props.isRounded,
            "is-disabled": props.isDisabled,
            "is-fullwidth": props.isFullwidth,
            "is-loading": props.isLoading,
            [possibleColorsMap[props.color]]: Boolean(props.color),
            [possibleSizesMap[props.size]]: Boolean(props.size),
            [possibleTypesMap[props.type]]: Boolean(props.type),
        }));

        const dynamicAttributes = computed(() => {
            const attributes = {};

            if (props.to) attributes.to = props.to;
            if (props.href) attributes.href = props.href;
            if (props.isDisabled) attributes.disabled = props.isDisabled;

            return attributes;
        });

        return {
            dynamicElement,
            dynamicClasses,
            dynamicAttributes,
        };
    },
});
</script>

<style lang="scss" scoped>
@import "@/styles/main.scss";
@import "bulma/sass/elements/button.sass";
</style>
