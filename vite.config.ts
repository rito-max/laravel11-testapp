import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: [
                "resources/js/pages/stockDetails.tsx",
                "resources/css/app.css",
                "resources/js/app.tsx",
            ],
            refresh: true,
        }),
    ],
});
