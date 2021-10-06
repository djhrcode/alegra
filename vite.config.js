import usePath from "path";
import { defineConfig } from "laravel-vite";
import useVuePlugin from "@vitejs/plugin-vue";

/**
 * For more information please check ViteJS documentation
 * https://vitejs.dev/config/
 */

export default defineConfig()
    .withPlugin(useVuePlugin)
    .merge({});
