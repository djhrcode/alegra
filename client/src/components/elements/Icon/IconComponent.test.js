import { render } from "@testing-library/vue";
import "@testing-library/jest-dom";
import IconComponent from "./IconComponent.vue";

describe("IconComponent.vue", () => {
    it("renders icon from given name", () => {
        const { getByRole } = render(IconComponent, {
            props: { name: "arrow-right" },
        });

        const icon = getByRole("img");

        expect(icon).toBeDefined();
        expect(icon.classList.contains("la-arrow-right")).toBeTruthy();
    });

    it("prop :color works properly", () => {
        const { getByRole } = render(IconComponent, {
            props: { name: "arrow-right", color: "primary" },
        });

        const iconContainer = getByRole("text");

        expect(iconContainer.classList.contains("is-primary")).toBeTruthy();
    });

    it("prop :size works properly", () => {
        const { getByRole } = render(IconComponent, {
            props: { name: "arrow-right", size: "medium" },
        });

        const iconContainer = getByRole("text");
        const icon = getByRole("img");

        expect(iconContainer.classList.contains("is-medium")).toBeTruthy();
        expect(icon.classList.contains("la-2x")).toBeTruthy();
    });

    it("prop :is-right works properly", () => {
        const { getByRole, html } = render(IconComponent, {
            props: { name: "arrow-right", isRight: true },
        });

        const iconContainer = getByRole("text");

        expect(iconContainer.classList.contains("is-right")).toBeTruthy();
    });

    it("prop :is-left works properly", () => {
        const { getByRole } = render(IconComponent, {
            props: { name: "arrow-right", isLeft: true },
        });

        const iconContainer = getByRole("text");

        expect(iconContainer.classList.contains("is-left")).toBeTruthy();
    });
});
