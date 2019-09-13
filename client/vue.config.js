module.exports = {
    css: {
        sourceMap: true
    },
    devServer: {
        proxy: {
            '^/detect/': {
                target: 'http://local.devicedetector.net/',
                changeOrigin: true
            },
            '^/supported/': {
                target: 'http://local.devicedetector.net/',
                changeOrigin: true
            },
            '^/version.json': {
                target: 'http://local.devicedetector.net/',
                changeOrigin: true
            },
            '^/icons': {
                target: 'http://local.devicedetector.net/',
                changeOrigin: true
            }

        }
    }
};
