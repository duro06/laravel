module.exports = {
  root: true,
  env: {
    browser: true,
    node: true
  },
  parserOptions: {
    parser: 'babel-eslint'
  },
  extends: [
    "plugin:vue/essential",
    "eslint:recommended",
      
  ],
  // add your custom rules here
  rules: {
    'eqeqeq':'off',
    'no-console':'off'
  }
}
