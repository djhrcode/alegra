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
            @input="onInputValueChange"
        />
        <IconComponent
            v-if="iconLeft"
            is-left
            :class="iconLeftClass"
            :size="size"
            :name="iconLeft"
            @click="$emit('click:icon-left')"
        ></IconComponent>

        <IconComponent
            v-if="iconRight"
            is-right
            :class="iconRightClass"
            :size="size"
            :name="iconRight"
            @click="$emit('click:icon-right')"
        ></IconComponent>

        <p v-if="error && hasErrorState" class="control__error">
            {{ error }}
        </p>
    </div>
</template>

<script>
import { computed, defineComponent, readonly, ref, watch } from "vue";
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
    danger: "is-danger",
    warning: "is-warning",
    success: "is-success",
});

const possibleSizes = Object.keys(possibleSizesMap);
const possibleColors = Object.keys(possibleColorsMap);

export default defineComponent({
    components: {
        IconComponent,
    },

    emits: ["update:modelValue", "click:icon-right", "click:icon-left"],

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
        error: {
            type: String,
            default: null,
        },
        hasError: {
            type: Boolean,
            default: false,
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
        iconRightClass: {
            type: String,
            default: null,
        },
        iconLeftClass: {
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
    setup(props, context) {
        const hasErrorState = ref(props.hasError);

        const inputColor = computed(() =>
            hasErrorState.value ? "danger" : props.color
        );

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
            [possibleColorsMap[inputColor.value]]: Boolean(inputColor.value),
            [possibleSizesMap[props.size]]: Boolean(props.size),
        }));

        watch(
            () => props.hasError,
            (newValue) => {
                hasErrorState.value = newValue;
            }
        );

        /**
         * @param {InputEvent} event
         */
        const onInputValueChange = (event) => {
            context.emit("update:modelValue", event.target.value);
            hasErrorState.value = false;
        };

        return {
            hasErrorState,
            controlDynamicClasses,
            inputDynamicClasses,
            onInputValueChange,
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

.control {
    input.input {
        border-width: $input-border-width;
        font-weight: 300;
    }

    & &__label {
        margin-bottom: 0.75rem;
        font-weight: 500;
        color: $dark;
    }

    & &__error {
        margin-top: 0.5rem;
        color: $danger;
        font-size: 0.875rem;
    }

    & .icon.is-clickable {
        cursor: pointer;
        color: rgba($dark, 0.5);

        &:hover {
            color: rgba($dark, 0.75);
        }

        &:focus {
            color: rgba($dark, 1);
        }
    }
}
</style>
