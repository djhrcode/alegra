import { defineConfig } from "laravel-vite";
import vue from "@vitejs/plugin-vue";
import purgecss from "@fullhuman/postcss-purgecss";

const vueComponentPath = /\.vue(\?.+)?$/;

/**
 * For more information please check ViteJS documentation
 * https://vitejs.dev/config/
 */

export default defineConfig()
    .withPlugin(vue)
    .withPostCSS([
        purgecss({
            content: [
                "./resources/**/*.vue",
                "./resources/**/*.blade.php",
                "./resources/**/*.html",
            ],
            defaultExtractor(content) {
                const contentWithoutStyleBlocks = content.replace(
                    /<style[^]+?<\/style>/gi,
                    ""
                );
                return (
                    contentWithoutStyleBlocks.match(
                        /[A-Za-z0-9-_/:]*[A-Za-z0-9-_/]+/g
                    ) || []
                );
            },
            safelist: [
                /-(leave|enter|appear)(|-(to|from|active))$/,
                /^(?!(|.*?:)cursor-move).+-move$/,
                /^router-link(|-exact)-active$/,
                /data-v-.*/,
            ],
        }),
    ])
    .merge({});
