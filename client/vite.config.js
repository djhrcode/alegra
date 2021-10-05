import { defineConfig } from "vite";
import useVuePlugin from "@vitejs/plugin-vue";
import { ViteAliases as useViteAliases } from "vite-aliases";

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [useViteAliases(), useVuePlugin()],
});
