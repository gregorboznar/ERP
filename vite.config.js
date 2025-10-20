import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { fileURLToPath, URL } from "node:url";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/filament/admin/theme.css",
                "resources/js/filament/admin/theme.js",
                "resources/css/filament/admin/custom.css",
                "resources/css/main.css",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("./resources", import.meta.url)),
        },
    },
    server: {
        hmr: {
            host: "erp.test",
        },
    },
});
