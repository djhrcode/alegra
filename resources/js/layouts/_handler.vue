<template>
    <keep-alive>
        <component :is="dynamicLayoutComponent">
            <slot></slot>
        </component>
    </keep-alive>
</template>

<script>
import { defineAsyncComponent, defineComponent } from "@vue/runtime-core";

const LayoutComponents = {
    default: defineAsyncComponent(() => import("./default.vue")),
};

export default defineComponent({
    defaultLayout: "default",
    components: LayoutComponents,
    computed: {
        dynamicLayoutComponent() {
            return LayoutComponents[this.currentLayout];
        },
        currentLayout() {
            return this.$route.meta.layout
                ? this.$route.meta.layout
                : this.$options.defaultLayout;
        },
    },
});
</script>
