import { render } from "@testing-library/vue";
import "@testing-library/jest-dom";
import ButtonComponent from "./ButtonComponent.vue";
import { router } from "@/plugins/router";
import { fireEvent } from "@testing-library/dom";

describe("ButtonComponent.vue", () => {
    it("renders button with text", () => {
        const text = "Click me; I'm a button";
        const { getByRole } = render(ButtonComponent, {
            slots: { default: text },
        });

        const button = getByRole("button");

        expect(button).toBeDefined();
        expect(button).toHaveTextContent(text);
    });

    it("renders link when uses [href] attribute", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(ButtonComponent, {
            slots: { default: text },
            props: { href: "/link" },
        });

        const link = getByRole("link");

        expect(link).toBeDefined();
    });
    it("renders router link when uses [to] attribute", () => {
        const text = "Click me; I'm a link";

        const { html, getByRole } = render(ButtonComponent, {
            slots: { default: text },
            props: { to: "/welcome" },
            global: {
                plugins: [router],
            },
        });

        const link = getByRole("link");

        expect(link).toBeDefined();
    });

    it("emits @click event when button is clicked", () => {
        const text = "Click me; I'm a link";

        const { emitted, getByRole } = render(ButtonComponent, {
            slots: { default: text },
        });

        const button = getByRole("button");

        fireEvent.click(button);

        expect(emitted()).toHaveProperty("click");
    });

    it("prop :color works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(ButtonComponent, {
            slots: { default: text },
            props: { color: "primary" },
        });

        const button = getByRole("button");

        expect(button.classList.contains("is-primary")).toBeTruthy();
    });

    it("prop :size works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(ButtonComponent, {
            slots: { default: text },
            props: { size: "small" },
        });

        const button = getByRole("button");

        expect(button.classList.contains("is-small")).toBeTruthy();
    });

    it("prop :type works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(ButtonComponent, {
            slots: { default: text },
            props: { type: "outlined" },
        });

        const button = getByRole("button");

        expect(button.classList.contains("is-outlined")).toBeTruthy();
    });

    it("prop :is-disabled works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(ButtonComponent, {
            slots: { default: text },
            props: { isDisabled: true },
        });

        const button = getByRole("button");

        expect(button.classList.contains("is-disabled")).toBeTruthy();
    });

    it("prop :is-rounded works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(ButtonComponent, {
            slots: { default: text },
            props: { isRounded: true },
        });

        const button = getByRole("button");

        expect(button.classList.contains("is-rounded")).toBeTruthy();
    });
});
