<template>
    <div :class="controlDynamicClasses" role="combobox">
        <input
            role="textbox"
            :class="inputDynamicClasses"
            :type="type"
            :placeholder="placeholder"
            :disabled="isDisabled"
            :readonly="isReadonly"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <IconComponent
            v-if="iconLeft"
            :size="size"
            :name="iconLeft"
            is-left
        ></IconComponent>
        <IconComponent
            v-if="iconRight"
            :size="size"
            :name="iconRight"
            is-right
        ></IconComponent>
    </div>
</template>

<script>
import { computed, defineComponent, readonly, ref } from "vue";
import IconComponent from "../Icon/IconComponent.vue";

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
    components: {
        IconComponent,
    },

    emits: ['update:modelValue'],
    
    props: {
        isDisabled: {
            type: Boolean,
            default: null,
        },
        isReadonly: {
            type: Boolean,
            default: null,
        },
        isLoading: {
            type: Boolean,
            default: null,
        },
        isRounded: {
            type: Boolean,
            default: null,
        },
        modelValue: {
            type: String,
            default: null,
        },
        type: {
            type: String,
            default: "text",
        },
        placeholder: {
            type: String,
            default: null,
        },
        iconRight: {
            type: String,
            default: null,
        },
        iconLeft: {
            type: String,
            default: null,
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
        const controlDynamicClasses = computed(() => ({
            control: true,
            "is-loading": props.isLoading,
            "has-icons-left": Boolean(props.iconLeft),
            "has-icons-right": Boolean(props.iconRight),
            [possibleSizesMap[props.size]]: Boolean(props.size),
        }));

        const inputDynamicClasses = computed(() => ({
            input: true,
            "has-transition": true,
            "is-rounded": props.isRounded,
            [possibleColorsMap[props.color]]: Boolean(props.color),
            [possibleSizesMap[props.size]]: Boolean(props.size),
        }));

        return {
            controlDynamicClasses,
            inputDynamicClasses,
        };
    },
});
</script>

<style lang="scss">
@import "@/styles/main.scss";

$input-color: $dark;
$input-background-color: $white;
$input-shadow: none;
$input-border-width: 2px;
$input-border-color: rgba($dark, 0.2);
$input-icon-color: rgba($dark, 0.2);
$input-icon-active-color: $dark;

$input-hover-border-color: rgba($dark, 0.4);

$input-focus-border-color: $primary;
$input-focus-box-shadow-size: 0 0 0 0.25em;
$input-focus-box-shadow-color: rgba($primary, 0.1);


@import "bulma/sass/form/shared.sass";
@import "bulma/sass/form/input-textarea.sass";
@import "bulma/sass/form/tools.sass";

input.input {
    border-width: $input-border-width;
    font-weight: 300;
}
</style>
