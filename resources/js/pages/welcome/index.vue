<template>
    <div
        class="
            container pt-6
            is-fullheight
            is-flex
            is-flex-direction-column
            is-justify-content-center
        "
        style="max-width: 580px"
    >
        <HeadingComponent :size="2">
            ¡Te damos la <br />
            bienvenida, {{ firstName }}!
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
            class="mt-2 mb-6"
            icon-right="la-arrow-right"
            size="medium"
            to="/explore"
        >
            Siguiente
        </ButtonComponent>
        <div class="mb-6"></div>
    </div>
</template>

<script>
import { computed, defineComponent, onMounted, ref } from "@vue/runtime-core";
import ButtonComponent from "@/components/elements/Button/ButtonComponent.vue";
import HeadingComponent from "@/components/elements/Heading/HeadingComponent.vue";
import ParagraphComponent from "@/components/elements/Paragraph/ParagraphComponent.vue";
import NavigationBar from "@/components/sections/Navigation/NavigationBar.vue";
import InputComponent from "@/components/elements/Input/InputComponent.vue";
import { useAuthenticationService } from "@/models/Authentication/AuthenticationService.js";
import { useRouter } from "vue-router";

export default defineComponent({
    components: {
        NavigationBar,
        ButtonComponent,
        HeadingComponent,
        ParagraphComponent,
        InputComponent,
    },

    setup() {
        const stateLoaded = ref(false);
        const router = useRouter();
        const authenticationService = useAuthenticationService();

        authenticationService.checkStatus().then((value) => {
            value ? null : router.push("/login");
        });

        const firstName = computed(
            () => authenticationService.account()?.name?.split(" ")[0]
        );

        return { stateLoaded, firstName };
    },
});
</script>

<style></style>
