import vue from '@vitejs/plugin-vue'
import {defineConfig} from 'vite'
import pluginRewriteAll from 'vite-plugin-rewrite-all'
import Components from 'unplugin-vue-components/vite'
import {BootstrapVue3Resolver} from "unplugin-vue-components/resolvers";

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
            resolvers: [BootstrapVue3Resolver()]
        }),
        pluginRewriteAll()
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
