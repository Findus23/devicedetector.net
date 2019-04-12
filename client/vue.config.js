module.exports = {
    outputDir: "../public/dist",
    indexPath: "../",
    devServer: {
        proxy: {
            '^/detect/': {
                target: 'http://local.devicedetector.net/detect/',
                changeOrigin: true
            },
            '^/supported/': {
                target: 'http://local.devicedetector.net/supported/',
                changeOrigin: true
            },
            '^/version.json': {
                target: 'http://local.devicedetector.net/version.json',
                changeOrigin: true
            }
        }
    }
};
