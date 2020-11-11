const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            boxShadow : {
                default: '0 0 5px 0 rgba(0, 0, 0, 0.08)'
            },
            colors : {
                blue: {
                    default: '#47cdff',
                    'light': '#8ae2fe',
                    accent: 'var(--text-accent-color)',
                    'accent-light': 'var(--text-accent-light-color)',
                    muted: 'var(--text-muted-color)',
                    'muted-light': 'var(--text-muted-light-color)'
                }
            },
            backgroundColor: {
                page: 'var(--page-background-color)',
                card: 'var(--card-background-color)',
                button: 'var(--button-background-color)',
                header: 'var(--header-background-color)',
                
            },
            textColor: {
                default: 'var(--text-default-color)',
                accent: 'var(--text-accent-color)',
                'accent-light': 'var(--text-accent-light-color)',
                muted: 'var(--text-muted-color)',
                'muted-light': 'var(--text-muted-light-color)'
            },
            borderColor: {
                default: 'var(--text-default-color)',
                accent: 'var(--text-accent-color)',
                'accent-light': 'var(--text-accent-light-color)',
                muted: 'var(--text-muted-color)',
                'muted-light': 'var(--text-muted-light-color)'
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [require('@tailwindcss/ui')],
};
