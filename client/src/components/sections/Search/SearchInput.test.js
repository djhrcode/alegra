import { fireEvent, render } from "@testing-library/vue";
import "@testing-library/jest-dom";
import SearchInput from "./SearchInput.vue";

const INPUT_QUERY_SELECTOR = ".search-input__input input.input";
const BUTTON_TEXT_QUERY_SELECTOR = "button.search-input__button-text";
const BUTTON_ICON_QUERY_SELECTOR = "button.search-input__button-icon";

describe("SearchInput.vue", () => {
    it("renders SearchInput successfully", () => {
        const { baseElement } = render(SearchInput);

        expect(
            baseElement.querySelector(INPUT_QUERY_SELECTOR)
        ).toBeInTheDocument();
        expect(
            baseElement.querySelector(BUTTON_TEXT_QUERY_SELECTOR)
        ).toBeInTheDocument();
        expect(
            baseElement.querySelector(BUTTON_ICON_QUERY_SELECTOR)
        ).toBeInTheDocument();
    });

    it("prop v-model works properly", () => {
        const value = "I wanna look for this!";

        const { emitted, baseElement, html } = render(SearchInput, {
            props: { modelValue: value },
        });

        /**
         * @type {HTMLInputElement|null}
         */
        const input = baseElement.querySelector(INPUT_QUERY_SELECTOR);

        fireEvent.input(input);

        expect(input.value).toBe(value);
        expect(emitted()).toHaveProperty("update:modelValue");
    });

    it("emits @search when enter key pressed", () => {
        const { emitted, baseElement } = render(SearchInput);

        fireEvent.keyDown(
            baseElement.querySelector(INPUT_QUERY_SELECTOR),
            { code: "Enter", key: "Enter", charCode: 13 }
        );

        expect(emitted()).toHaveProperty("search");
    });

    it("emits @search when click button text", () => {
        const { baseElement, emitted } = render(SearchInput);

        fireEvent.click(
            baseElement.querySelector(BUTTON_TEXT_QUERY_SELECTOR)
        );

        expect(emitted()).toHaveProperty("search");
    });

    it("emits @search when click button icon", () => {
        const { baseElement, emitted } = render(SearchInput);

        fireEvent.click(
            baseElement.querySelector(BUTTON_ICON_QUERY_SELECTOR)
        );

        expect(emitted()).toHaveProperty("search");
    });
});
