import { fireEvent, render } from "@testing-library/vue";
import "@testing-library/jest-dom";
import InputComponent from "./InputComponent.vue";

describe("InputComponent.vue", () => {
    it("renders input successfully", () => {
        const { getByRole } = render(InputComponent);

        const input = getByRole("textbox");

        expect(input).toBeDefined();
        expect(input.classList.contains("input")).toBeTruthy();
        expect(input.tagName.toLowerCase()).toBe("input");
    });

    it("prop v-model works properly", () => {
        const value = "Sample input value";

        const { emitted, getByRole } = render(InputComponent, {
            props: { modelValue: value },
        });
        
        const input = getByRole("textbox");
        
        fireEvent.input(input);

        expect(input.value).toBe(value);
        expect(emitted()).toHaveProperty("update:modelValue");
    });

    it("prop :size works properly", () => {
        const { getByRole } = render(InputComponent, {
            props: { size: "large" },
        });

        const control = getByRole("combobox");
        const input = getByRole("textbox");

        expect(control.classList.contains("is-large")).toBeTruthy();
        expect(input.classList.contains("is-large")).toBeTruthy();
    });

    it("prop :type works properly", () => {
        const type = "email";

        const { getByRole } = render(InputComponent, {
            props: { type },
        });

        const input = getByRole("textbox");

        expect(input.getAttribute("type")).toBe(type);
    });

    it("prop :placeholder works properly", () => {
        const placeholder = "Sample placeholder";

        const { getByRole } = render(InputComponent, {
            props: { placeholder },
        });

        const input = getByRole("textbox");

        expect(input.getAttribute("placeholder")).toBe(placeholder);
    });

    it("prop :is-rounded works properly", () => {
        const { getByRole } = render(InputComponent, {
            props: { isRounded: true },
        });

        const input = getByRole("textbox");

        expect(input.classList.contains("is-rounded")).toBeTruthy();
    });

    it("prop :is-disabled works properly", () => {
        const { getByRole } = render(InputComponent, {
            props: { isDisabled: true },
        });

        const input = getByRole("textbox");

        expect(input.disabled).toBeTruthy();
    });

    it("prop :is-readonly works properly", () => {
        const { getByRole } = render(InputComponent, {
            props: { isReadonly: true },
        });

        const input = getByRole("textbox");

        expect(input.readOnly).toBeTruthy();
    });

    it("prop :is-loading works properly", () => {
        const { getByRole } = render(InputComponent, {
            props: { isLoading: true },
        });

        const control = getByRole("combobox");

        expect(control.classList.contains("is-loading")).toBeTruthy();
    });

    it("prop :icon-right works properly", () => {
        const { getByRole } = render(InputComponent, {
            props: { iconRight: "arrow-right" },
        });

        const control = getByRole("combobox");

        expect(control.classList.contains("has-icons-right")).toBeTruthy();
        expect(control.querySelector(".icon.is-right")).toBeDefined();
        expect(control.querySelector(".las.la-arrow-right")).toBeDefined();
    });

    it("prop :icon-left works properly", () => {
        const { getByRole } = render(InputComponent, {
            props: { iconLeft: "arrow-left" },
        });

        const control = getByRole("combobox");

        expect(control.classList.contains("has-icons-left")).toBeTruthy();
        expect(control.querySelector(".icon.is-left")).toBeDefined();
        expect(control.querySelector(".las.la-arrow-left")).toBeDefined();
    });

    it("prop :color works properly", () => {
        const { getByRole } = render(InputComponent, {
            props: { color: "primary" },
        });

        const input = getByRole("textbox");

        expect(input.classList.contains("is-primary")).toBeTruthy();
    });
});
