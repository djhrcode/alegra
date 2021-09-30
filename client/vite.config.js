import { defineConfig } from "vite";
import VuePlugin from "@vitejs/plugin-VuePlugin";
import { ViteAliases } from "vite-aliases";

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [VuePlugin(), ViteAliases()],
});
