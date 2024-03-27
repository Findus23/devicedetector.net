import vue from '@vitejs/plugin-vue'
import {defineConfig} from 'vite'
import Components from 'unplugin-vue-components/vite'
import {BootstrapVueNextResolver} from "unplugin-vue-components/resolvers";

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    includeAbsolute: false
                }
            }
        }),
        Components({
            resolvers: [BootstrapVueNextResolver()]
        }),
    ],
    server: {
        proxy: {
            "/detect": "http://local.devicedetector.net/",
            "/supported": "http://local.devicedetector.net/",
            "/icons": "http://local.devicedetector.net/",
            "/from-header": "http://local.devicedetector.net/",
            "/version.json": "http://local.devicedetector.net/"
        }
    },
    build: {
        sourcemap: true,
        target: "es2019",
        rollupOptions:{
            // external: /icons.*/
        }
    }
})
