const teamColors = require('./teams');
module.exports = {
    purge: [],
    theme: {
        extend: {
            colors: teamColors,
            //screens: {
            //    'light-mode': { raw: '(prefers-color-scheme: light)' },
            //    'dark-mode': { raw: '(prefers-color-scheme: dark)' }
            //}
        },
    },
    variants: {
        backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
        borderColor: ['responsive', 'hover', 'focus', 'group-hover'],
        opacity: ['responsive', 'hover', 'focus', 'group-hover'],
        scale: ['responsive', 'hover', 'focus', 'group-hover'],
        textColor: ['responsive', 'hover', 'focus', 'group-hover'],
        translate: ['responsive', 'hover', 'focus', 'group-hover']
    },
    plugins: [],
}
