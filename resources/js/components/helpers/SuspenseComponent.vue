<template>
    <slot v-if="suspenseError" name="error"></slot>
    <Suspense v-else>
        <template #default>
            <slot name="default"></slot>
        </template>
        <template #fallback>
            <slot name="fallback"></slot>
        </template>
    </Suspense>
</template>

<script>
import { defineComponent, onErrorCaptured, ref } from "@vue/runtime-core";

/**
 * A custom Suspense component to handle errors
 */
export default defineComponent({
    emits: ["asyncerror"],

    setup(props, context) {
        const suspenseError = ref(null);

        onErrorCaptured((error) => {
            suspenseError.value = error;

            context.emit("asyncerror", error)

            return true;
        });

        return { suspenseError };
    },
});
</script>

<style></style>
