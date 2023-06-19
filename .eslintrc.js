module.exports = {
	root: true,
	env: {
		browser: true,
		es6: true,
		node: true
	},
	globals: {
		wp: true,
		jQuery: true,
		ajaxurl: true,
		alert: true
	},
	rules: {
		camelcase: 0
    },
    extends: [ "plugin:@wordpress/eslint-plugin/recommended" ]
};
