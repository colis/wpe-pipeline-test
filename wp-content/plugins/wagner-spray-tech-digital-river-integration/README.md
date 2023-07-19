# Americaneagle.com Plugin Scaffold

> At Americaneagle.com, we strive to provide digital products that yield a top-notch user experience. In order to improve both our efficiency and consistency, we need to standardize what we use and how we use it. This plugin scaffold allows us to share initial set up procedures to make sure all projects can get up and running as quickly as possible while closely adhering to Americaneagle.com's high quality standards.

[![Support Level](https://img.shields.io/badge/support-active-green.svg)](#support-level)

## Dependencies

1. [Composer](https://getcomposer.org/) 2.x+, installed globally.
2. [PHP](https://php.net/) 8.0+.
3. [Node](https://nodejs.org/) 16.x+

### NOTICE

This is currently incomplete, as of 12/01/2023 only the php parts have been worked on, which means all of the front end tooling, bash scripting and configs are not working as expected.

DO NOT USE ON PRODUCTION PROJECTS

## Getting Started

- Clone the repository
- If copying files manually to an existing plugin directory instead of cloning directly from the repository, make sure to include the following files/folders which may be hidden:

```
.ae/
.husky/
.babelrc
.browserslistrc
.editorconfig
.eslintignore
.eslintrc
.gitignore
.npmrc
.nvmrc
.prettierrc
.stylelintignore
```

The NPM commands will fail without these files present.

- `cd` into the plugin folder
- run `bash .ae/init.sh "Your Project Name"` to install dependencies and build the front-end assets

## Architecture / Concepts

1. All hooks (add_action, add_filter etc) should be implements in Plugin.php in relevant methods. This is to ensure all other classes are pure and discovery of what is going on with plugin events is in one place.
2. Implements a basic container on the global $this->app class property. All sub modules created in directories that follow the RegistrableInterface will be autoloaded across the system for ease of use. Simply calling $this->app->get('ModuleName') will lazy instantiate objects when needed (and only once per class call).
3. New functionality simply needs to follow the Example provided and then integrate into system using hooks in plugin.php.

## Todo
1. Unit tests
2. Front end tooling
3. Possibly make class instantiation static across all classes, so that each class in only ever created once - if worth doing, since the Plugin.php contains all hooks this could be a none problem.

## Webpack config

This script uses webpack behind the scenes. It’ll look for a webpack config in the top-level directory of the plugin and will use it if it finds one. If none is found, it’ll use the default config provided by `@wordpress/scripts` packages.

To extend the provided webpack config, or replace subsections within the provided webpack config, you can provide your own `webpack.config.js` file, require the provided webpack.config.js file, and use the spread operator to import all of or part of the provided configuration.

In most cases `webpack.config.js` is the main file which would change from project to project. For example adding or removing entry points for JS and CSS.

## NPM Commands

- `npm run start` (install dependencies and build assets)
- `npm run build` (build a production version of all assets)
- `npm run watch` (watch assets)
- `npm run test` (runs phpunit, alias of `composer test`)
- `npm run build-release` (build all files for release)
- `npm run lint:js` (lint JS)
- `npm run lint:css` (lint CSS)
- `npm run lint:php` (lint PHP, alias of `composer lint`)

## Composer Commands

`composer lint` (lint PHP files)

`composer lint-fix` (lint PHP files and automatically correct coding standard violations)

`composer test` (runs phpunit)






## Contributing

We don't know everything! We welcome pull requests and spirited, but respectful, debates. Please contribute via [pull requests on GitHub](https://github.com/AEWP/wagner-spray-tech).

1. Fork it!
2. Create your feature branch: `git checkout -b feature/my-new-feature`
3. Commit your changes: `git commit -am 'Added some great feature!'`
4. Push to the branch: `git push origin feature/my-new-feature`
5. Submit a pull request

## Learn more about the default packages used with this project

- [WordPress Scripts](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts)
- [Husky](https://www.npmjs.com/package/husky)
- [Lint Staged](https://www.npmjs.com/package/lint-staged)
- [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer)

## Support Level

**Active:** Americaneagle.com is actively working on this, and we expect to continue work for the foreseeable future including keeping tested up to the most recent version of WordPress. Bug reports, feature requests, questions, and pull requests are welcome.

## Like what you see?

<a href="https://www.americaneagle.com/contact-us/"><img src="https://www.americaneagle.com/ResourcePackages/Talon/assets/dist/images/logo.jpg" width="400" alt="Work with us at Americaneagle.com"></a>
