<template>
    <div class="search-input columns is-2 is-mobile">
        <div class="column">
            <InputComponent
                :modelValue="searchQueryValue"
                @update:modelValue="handleModelValueUpdate"
                class="search-input__input"
                size="medium"
                icon-left="la-search"
                placeholder="Busca una imagen..."
                @keydown.enter="onEnterKeyPressFromInput"
                :is-loading="isLoading"
            ></InputComponent>
        </div>
        <div class="column is-narrow is-hidden-touch">
            <ButtonComponent
                class="search-input__button-text px-4"
                icon-right="la-arrow-right"
                size="medium"
                @click="onClickSearchButton"
                :is-loading="isLoading"
            >
                Buscar
            </ButtonComponent>
        </div>
        <div class="column is-narrow is-hidden-desktop">
            <ButtonComponent
                class="search-input__button-icon px-2"
                icon="la-arrow-right"
                size="medium"
                @click="onClickSearchButton"
                :is-loading="isLoading"
            ></ButtonComponent>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref, watchEffect } from "vue";
import InputComponent from "@/components/elements/Input/InputComponent.vue";
import ButtonComponent from "@/components/elements/Button/ButtonComponent.vue";

export default defineComponent({
    components: { InputComponent, ButtonComponent },
    emits: ["update:modelValue", "search"],
    props: {
        modelValue: {
            type: String,
            default: null,
        },
        isLoading: {
            type: Boolean,
            default: false,
        }
    },
    setup(props, { emit }) {
        const searchQueryValue = ref(props.modelValue);

        const dispatchSearch = (value) => emit("search", searchQueryValue.value);

        const onClickSearchButton = () => dispatchSearch(props.modelValue);
        const onEnterKeyPressFromInput = () => dispatchSearch(props.modelValue);

        const handleModelValueUpdate = (value) => {
            searchQueryValue.value = value;
            emit("update:modelValue", value);
        };

        return {
            handleModelValueUpdate,
            searchQueryValue,
            onClickSearchButton,
            onEnterKeyPressFromInput,
        };
    },
});
</script>
