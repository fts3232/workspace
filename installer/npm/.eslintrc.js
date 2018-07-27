module.exports = {
    env: {
        browser: true,
        commonjs: true,
        es6: true,
        node: true,
    },
    "parser": "babel-eslint",
    extends: ['airbnb','prettier'],
    parserOptions: {
        ecmaFeatures: {
            jsx: true,
        },
        ecmaVersion: 2018,
        sourceType: 'module',
    },
    plugins: ['react'],
    rules: {
        indent: ['error', 4,{
            "SwitchCase": 1
        }],
        'import/extensions': 0,
        'linebreak-style': "off",
        quotes: ['error', 'single'],
        semi: ['error', 'always'],
        'no-console': 'off',
        'no-undef':'off',
        "prefer-arrow-callback": "warn",
        "no-var": "error",
        "max-params": ["error", 4],
        "import/no-unresolved": 0,
        "import/no-extraneous-dependencies": 0,
        'react/jsx-indent' : ['error',4],
        "react/jsx-filename-extension": ["error", { "extensions": [".js", ".jsx"] }]
    },
};
