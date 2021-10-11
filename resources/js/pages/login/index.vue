<template>
    <div
        class="
            is-fullheight
            is-flex
            is-flex-direction-column
            is-justify-content-center
            pt-6 pt-4-mobile mx-auto
        "
        style="max-width: 460px"
    >
        <HeadingComponent size="4"> Ingresa </HeadingComponent>

        <ParagraphComponent size="large" class="mb-3">
            ¡Ayúdanos a conseguir las mejores imágenes del mundo! Pero primero,
            ingresa con tu cuenta por favor
        </ParagraphComponent>

        <!--
            Email form field with InputComponent
         -->
        <ParagraphComponent class="mb-1">
            <strong>Correo electrónico</strong>
        </ParagraphComponent>
        <InputComponent
            v-model="formLoginData.email"
            class="mb-3"
            icon-right="la-envelope"
            placeholder="youremail@example.com"
            size="medium"
            :is-disabled="hasLoadingState"
            :error="formLoginErrors?.errors?.email?.at(0)"
            :has-error="!!formLoginErrors.errors?.email?.length"
        ></InputComponent>

        <!--
            Password form field with InputComponent
         -->
        <ParagraphComponent class="mb-1">
            <strong>Contraseña</strong>
        </ParagraphComponent>
        <InputComponent
            v-model="formLoginData.password"
            size="medium"
            class="mb-2"
            placeholder="Password"
            icon-right-class="is-clickable"
            :icon-right="isPasswordVisible ? 'la-eye' : 'la-eye-slash'"
            :type="isPasswordVisible ? 'text' : 'password'"
            :is-disabled="hasLoadingState"
            :error="formLoginErrors?.errors?.password?.at(0)"
            :has-error="!!formLoginErrors.errors?.password?.length"
            @click:icon-right="togglePasswordVisibility"
        ></InputComponent>

        <!--
            Login form submit button with ButtonComponent
         -->
        <ButtonComponent
            class="mt-2"
            icon-right="la-sign-in-alt"
            size="medium"
            :is-loading="hasLoadingState"
            @click="onClickLogin"
        >
            Iniciar sesión
        </ButtonComponent>


        <ParagraphComponent size="small" class="mb-1 mt-3 has-text-centered">
            ¿Todavía no tienes una cuenta?
        </ParagraphComponent>
        <ButtonComponent
            to="/register"
            color="dark"
            type="inverted"
            icon-right="la-user-circle"
            :is-loading="hasLoadingState"
        >
            Crear una cuenta
        </ButtonComponent>

        <div class="mb-6"></div>
    </div>
</template>

<script>
import { defineComponent, onMounted, reactive, ref } from "@vue/runtime-core";
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

        const isPasswordVisible = ref(false);
        const togglePasswordVisibility = () =>
            (isPasswordVisible.value = !isPasswordVisible.value);

        const router = useRouter();
        const notificationStore = useNotificationStore();
        const authenticationService = useAuthenticationService();
        const hasLoadingState = ref(false);

        const startLoadingState = () => (hasLoadingState.value = true);

        const stopLoadingState = () => (hasLoadingState.value = false);

        async function onLoginErrorResponse(error) {
            console.log("Login has emitted an error", error);

            notificationStore.notify({
                color: "danger",
                title: "Ups, parece que tenemos un error :(",
            });

            if (!(error instanceof UnprocessableEntityHttpError)) throw error;

            const errorResponse = await error.json();

            formLoginErrors.errors = errorResponse.errors;
            formLoginErrors.message = errorResponse.message;

            notificationStore.notify({
                color: "danger",
                title: "Los datos ingresados son incorrectos",
                message: errorResponse.getFirstError(),
            });
        }

        function onLoginSuccessResponse() {
            router.push("/welcome");

            notificationStore.notify({
                title: "¡Genial! Has iniciado sesión exitosamente",
            });

            return;
        }

        function onClickLogin() {
            startLoadingState();

            authenticationService
                .login(createCredentials(formLoginData))
                .then(onLoginSuccessResponse)
                .catch((error) => onLoginErrorResponse(error))
                .finally(stopLoadingState);
        }

        return {
            hasLoadingState,
            formLoginData,
            formLoginErrors,
            onClickLogin,

            isPasswordVisible,
            togglePasswordVisibility,
        };
    },
});
</script>

<style></style>
