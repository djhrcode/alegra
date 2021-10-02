import { render } from "@testing-library/vue";
import "@testing-library/jest-dom";
import HeadingComponent from "./HeadingComponent.vue";

describe("HeadingComponent.vue", () => {
    it("renders heading with text", () => {
        const text = "I'm a heading expecting an amazing copy";
        
        const { getByRole } = render(HeadingComponent, {
            slots: { default: text },
        });

        const heading = getByRole("heading");

        expect(heading).toBeDefined();
        expect(heading).toHaveTextContent(text);
        expect(heading.classList.contains("heading")).toBeTruthy();
    });

    it("prop :size works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(HeadingComponent, {
            slots: { default: text },
            props: { size: 2 },
        });

        const heading = getByRole("heading");

        expect(heading.classList.contains("is-h2")).toBeTruthy();
        expect(heading.tagName.toLowerCase()).toBe("h2");
    });

    it("prop :element works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(HeadingComponent, {
            slots: { default: text },
            props: { size: 2, element: "h1" },
        });

        const heading = getByRole("heading");

        expect(heading.tagName.toLowerCase()).toBe("h1");
    });

    it("prop :color works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(HeadingComponent, {
            slots: { default: text },
            props: { color: "primary" },
        });

        const heading = getByRole("heading");

        expect(heading.classList.contains("is-primary")).toBeTruthy();
    });
});
