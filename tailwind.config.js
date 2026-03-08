/** tailwind.config.js */
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./*.php",
        "./**/*.php",
        "./*.html",
        "./**/*.html",
        "./*.js",
        "./**/*.js"
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                serif: ['"Playfair Display"', 'ui-serif', 'Georgia'],
                mono: ['"JetBrains Mono"', 'ui-monospace', 'SFMono-Regular'],
            },
            colors: {
                // Deep Space Tech Theme Options
                'deep-space': '#000000',
                'deep-surface': '#0a0a0c',
                'deep-border': 'rgba(255, 255, 255, 0.1)',
                'neon-accent': '#00ffcc', // Vibrant cyan/green
                'cobalt-accent': '#0055ff',
                'neon-hover': '#00e6b8',
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 70%, rgba(0,0,0,1) 100%)',
            },
            transitionTimingFunction: {
                'cinematic': 'cubic-bezier(0.23, 1, 0.32, 1)',
            },
            transitionDuration: {
                '600': '600ms',
                '800': '800ms',
            }
        },
    },
    plugins: [],
}
