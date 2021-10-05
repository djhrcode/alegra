<template>
    <div
        class="
            container is-fullheight
            is-flex is-flex-direction-column is-justify-content-center
        "
        style="max-width: 580px"
    >
        <HeadingComponent :size="2">
            ¡Te damos la <br />
            bienvenida, Sandra!
        </HeadingComponent>
        <ParagraphComponent size="large">
            En <strong>WorldwideImages</strong> nos hemos propuesto conseguir la
            persona con las mejores imágenes del mundo ¡Y tú puedes ayudarnos a
            conseguirla!
        </ParagraphComponent>
        <ParagraphComponent size="large">
            Para ello, busca las imágenes con la temática que más te llame la
            atención y luego vota a la persona que tenga la imagen más
            sorprendente. Al votar una imagen, estaras ayudando al proveedor de
            la imagen a ganar el concurso y lograr así facturar con Alegra.
        </ParagraphComponent>
        <ButtonComponent
            class="mt-2"
            icon-right="arrow-right"
            size="medium"
            to="/explore"
        >
            Siguiente
        </ButtonComponent>
    </div>
</template>

<script>
import { defineComponent, onMounted } from "@vue/runtime-core";
import ButtonComponent from "@/components/elements/Button/ButtonComponent.vue";
import HeadingComponent from "@/components/elements/Heading/HeadingComponent.vue";
import ParagraphComponent from "@/components/elements/Paragraph/ParagraphComponent.vue";
import NavigationBar from "@/components/sections/Navigation/NavigationBar.vue";
import InputComponent from "@/components/elements/Input/InputComponent.vue";

export default defineComponent({
    components: {
        NavigationBar,
        ButtonComponent,
        HeadingComponent,
        ParagraphComponent,
        InputComponent,
    },

    setup() {},
});
</script>

<style></style>
