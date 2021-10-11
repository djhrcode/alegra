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
        <HeadingComponent size="4"> Crea una cuenta</HeadingComponent>

        <ParagraphComponent size="large" class="mb-3">
            ¡Ayúdanos a conseguir las mejores imágenes del mundo! Pero primero,
            crea una cuenta para ingresar por favor
        </ParagraphComponent>

        <!--
            Email form field with InputComponent
         -->
        <ParagraphComponent class="mb-1">
            <strong>Nombre y apellido</strong>
        </ParagraphComponent>
        <InputComponent
            v-model="formRegisterData.name"
            name="name"
            class="mb-3"
            icon-right="la-user"
            placeholder="John Smith"
            size="medium"
            :is-disabled="hasLoadingState"
            :error="formRegisterErrors?.errors?.name?.at(0)"
            :has-error="!!formRegisterErrors.errors?.name?.length"
        ></InputComponent>

        <!--
            Email form field with InputComponent
         -->
        <ParagraphComponent class="mb-1">
            <strong>Correo electrónico</strong>
        </ParagraphComponent>
        <InputComponent
            v-model="formRegisterData.email"
            name="email"
            class="mb-3"
            icon-right="la-envelope"
            placeholder="youremail@example.com"
            size="medium"
            :is-disabled="hasLoadingState"
            :error="formRegisterErrors?.errors?.email?.at(0)"
            :has-error="!!formRegisterErrors.errors?.email?.length"
        ></InputComponent>

        <!--
            Password form field with InputComponent
         -->
        <ParagraphComponent class="mb-1">
            <strong>Contraseña</strong>
        </ParagraphComponent>
        <InputComponent
            v-model="formRegisterData.password"
            name="password"
            size="medium"
            class="mb-3"
            placeholder="Password"
            icon-right-class="is-clickable"
            :icon-right="isPasswordVisible ? 'la-eye' : 'la-eye-slash'"
            :type="isPasswordVisible ? 'text' : 'password'"
            :is-disabled="hasLoadingState"
            :error="formRegisterErrors?.errors?.password?.at(0)"
            :has-error="!!formRegisterErrors.errors?.password?.length"
            @click:icon-right="togglePasswordVisibility"
        ></InputComponent>

        <!--
            Password form field with InputComponent
         -->
        <ParagraphComponent class="mb-1">
            <strong>Confirmar contraseña</strong>
        </ParagraphComponent>
        <InputComponent
            v-model="formRegisterData.password_confirm"
            name="password_confirm"
            size="medium"
            class="mb-3"
            placeholder="Password"
            icon-right-class="is-clickable"
            :icon-right="isPasswordVisible ? 'la-eye' : 'la-eye-slash'"
            :type="isPasswordVisible ? 'text' : 'password'"
            :is-disabled="hasLoadingState"
            :error="formRegisterErrors?.errors?.password_confirm?.at(0)"
            :has-error="!!formRegisterErrors.errors?.password_confirm?.length"
            @click:icon-right="togglePasswordVisibility"
        ></InputComponent>

        <!--
            Login form submit button with ButtonComponent
         -->
        <ButtonComponent
            class="mt-2"
            icon-right="la-user-circle"
            size="medium"
            :is-loading="hasLoadingState"
            @click="onClickRegister"
        >
            Crear mi cuenta
        </ButtonComponent>

        <ParagraphComponent size="small" class="mb-1 mt-3 has-text-centered">
            ¿Ya tienes una cuenta?
        </ParagraphComponent>
        <ButtonComponent
            to="/login"
            color="dark"
            type="inverted"
            icon-right="la-sign-in-alt"
            :is-loading="hasLoadingState"
        >
            Inicia sesión
        </ButtonComponent>

        <div class="mb-6 mt-6"></div>
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
import {
    createAuthenticable,
    createCredentials,
} from "@/models/Authentication/AuthenticationFactories";
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
        const formRegisterErrors = reactive({
            message: null,
            errors: {},
        });

        const formRegisterData = reactive(
            createAuthenticable({
                name: null,
                email: null,
                password: null,
                password_confirm: null,
            })
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

            formRegisterErrors.errors = errorResponse.errors;
            formRegisterErrors.message = errorResponse.message;

            notificationStore.notify({
                color: "danger",
                title: "Los datos ingresados son incorrectos",
                message: errorResponse.getFirstError(),
            });
        }

        function onLoginSuccessResponse() {
            router.push("/welcome");

            notificationStore.notify({
                title: "¡Genial! Has creado tu cuenta exitosamente",
            });

            return;
        }

        function onClickRegister() {
            startLoadingState();

            authenticationService
                .register(createAuthenticable(formRegisterData))
                .then(onLoginSuccessResponse)
                .catch((error) => onLoginErrorResponse(error))
                .finally(stopLoadingState);
        }

        return {
            hasLoadingState,
            formRegisterData,
            formRegisterErrors,
            onClickRegister,

            isPasswordVisible,
            togglePasswordVisibility,
        };
    },
});
</script>

<style></style>
