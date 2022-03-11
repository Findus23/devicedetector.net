import {createVuePlugin} from 'vite-plugin-vue2'
import {defineConfig} from 'vite'
import pluginRewriteAll from 'vite-plugin-rewrite-all'

export default defineConfig({
    plugins: [
        createVuePlugin(),
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
        target: "es2019"
    }
})
