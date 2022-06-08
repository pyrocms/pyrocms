module.exports = {
    purge: {
        enabled: false,
        content: [
            './storage/framework/views/*.php',
            './resources/**/*.blade.php',
            './docs/*.md',
            './vendor/streams/**/docs/*.md',
        ],
        options: {
            whitelist: [],
        }
    },

    theme: {
        extend: {},
    },
    variants: {},
    plugins: [],
}
