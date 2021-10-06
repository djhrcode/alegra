import { render } from "@testing-library/vue";
import "@testing-library/jest-dom";
import ParagraphComponent from "./ParagraphComponent.vue";

describe("ParagraphComponent.vue", () => {
    it("renders paragraph with text", () => {
        const text = "I'm a paragraph expecting an amazing copy";
        
        const { getByRole } = render(ParagraphComponent, {
            slots: { default: text },
        });

        const paragraph = getByRole("textbox");

        expect(paragraph).toBeDefined();
        expect(paragraph).toHaveTextContent(text);
        expect(paragraph.classList.contains("paragraph")).toBeTruthy();
        expect(paragraph.tagName.toLowerCase()).toBe("p");
    });

    it("prop :size works properly", () => {
        const text = "Click me; I'm a link";

        const { getByRole } = render(ParagraphComponent, {
            slots: { default: text },
            props: { size: "large" },
        });

        const paragraph = getByRole("textbox");

        expect(paragraph.classList.contains("is-large")).toBeTruthy();
    });

    it("prop :element works properly", () => {
        const text = "I'm a paragraph expecting an amazing copy";

        const { getByRole } = render(ParagraphComponent, {
            slots: { default: text },
            props: { element: "span" },
        });

        const paragraph = getByRole("textbox");

        expect(paragraph.tagName.toLowerCase()).toBe("span");
    });

    it("prop :color works properly", () => {
        const text = "I'm a paragraph expecting an amazing copy";

        const { getByRole } = render(ParagraphComponent, {
            slots: { default: text },
            props: { color: "primary" },
        });

        const paragraph = getByRole("textbox");

        expect(paragraph.classList.contains("is-primary")).toBeTruthy();
    });
});
