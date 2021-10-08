<template>
    <div
        class="
            container
            is-fullheight
            is-flex
            is-flex-direction-column
            is-justify-content-center
        "
        style="max-width: 460px"
    >
        <HeadingComponent size="4"> Ingresa </HeadingComponent>
        <ParagraphComponent size="large" class="mb-3">
            ¡Ayúdanos a conseguir las mejores imágenes del mundo! Pero primero,
            ingresa con tu cuenta por favor
        </ParagraphComponent>

        <ParagraphComponent class="mb-1">
            <strong>Correo electrónico</strong>
        </ParagraphComponent>
        <InputComponent
            v-model="formLoginData.email"
            class="mb-3"
            icon-right="la-envelope"
            placeholder="youremail@example.com"
            size="medium"
        ></InputComponent>
        <ParagraphComponent class="mb-1">
            <strong>Contraseña</strong>
        </ParagraphComponent>
        <InputComponent
            v-model="formLoginData.password"
            class="mb-2"
            type="password"
            icon-right="la-eye-slash"
            placeholder="Password"
            size="medium"
        ></InputComponent>
        <ButtonComponent
            class="mt-2"
            icon-right="la-sign-in-alt"
            size="medium"
            @click="onClickLogin"
        >
            Iniciar sesión
        </ButtonComponent>
        <div class="mb-6"></div>
    </div>
</template>

<script>
import { defineComponent, onMounted, reactive } from "@vue/runtime-core";
import ButtonComponent from "@/components/elements/Button/ButtonComponent.vue";
import HeadingComponent from "@/components/elements/Heading/HeadingComponent.vue";
import ParagraphComponent from "@/components/elements/Paragraph/ParagraphComponent.vue";
import NavigationBar from "@/components/sections/Navigation/NavigationBar.vue";
import InputComponent from "@/components/elements/Input/InputComponent.vue";
import { useNotificationStore } from "@/models/Notification/NotificationStore.js";
import { useAuthenticationService } from "@/models/Authentication/AuthenticationService";
import { createCredentials } from "@/models/Authentication/AuthenticationFactories";
import { useRouter } from "vue-router";
import { UnprocessableEntityHttpError } from "@/http/errors/UnprocessableEntityHttpError";

export default defineComponent({
    components: {
        NavigationBar,
        ButtonComponent,
        HeadingComponent,
        ParagraphComponent,
        InputComponent,
    },

    setup() {
        const formLoginErrors = reactive({
            message: null,
            errors: {},
        });

        const formLoginData = reactive(
            createCredentials({ email: null, password: null })
        );

        const router = useRouter();
        const notificationStore = useNotificationStore();
        const authenticationService = useAuthenticationService();

        // authenticationService.checkStatus().then((value) => {
        //     value ? router.push("/welcome") : null;
        // });

        async function onLoginErrorResponse(error) {
            notificationStore.notify({
                color: "danger",
                title: "Ups, parece que tenemos un error :(",
            });

            if (!(error instanceof UnprocessableEntityHttpError)) throw error;

            formLoginErrors.errors = error.json().errors;
            formLoginErrors.message = error.json().message;
        }

        async function onLoginSuccessResponse() {
            router.push("/welcome");

            notificationStore.notify({
                title: "¡Genial! Has iniciado sesión exitosamente",
            });
        }

        async function onClickLogin() {
            authenticationService
                .login(createCredentials(formLoginData))
                .then(onLoginSuccessResponse)
                .catch(onLoginErrorResponse);
        }

        return { formLoginData, formLoginErrors, onClickLogin };
    },
});
</script>

<style></style>
