# Wagner Spray Tech

**An [American Eagle](https://americaneagle.com) project**

---

- [Local Development Environment](#local-development-environment)
- [Development Process](#development-process)
- [Project Structure](#project-structure)
- [Assets](#assets)
- [Running Tests](#running-the-tests)
- [Maintenance](#maintenance)

---

# Local Development Environment

Ensure you have the prerequisite software installed:

- [Composer](https://getcomposer.org/) 2.0+.
- [Git](https://git-scm.com/) 2.15+.
- [Local by Flywheel](https://localwp.com/) 5.2+.
- [Node](https://nodejs.org/) 14.15.0+.
- [WP-CLI](https://wp-cli.org/) 2.4+.
- [PHP 8.0][https://www.php.net/downloads.php]

## On-boarding

1. If you have a Local by Flywheel site export, import this into your Local application. If not, skip to step 2.
   1. With the site imported, in Terminal do:
      - `cd` into the project root directory (`/wagner-spray-tech/app/public`)
      - `git checkout main`
      - `git pull origin main`
   2. Next, skip step 2 and go to step 3.
2. If you do not have a Local by Flywheel site export:
   1. Create a new site in your local environment application.
      - Create a custom environment setup:
      - PHP `8.0.x`
      - Web Server `nginx`
      - MySQL `5.7.x`
   2. Set any admin username and password, as these will be overwritten by the site's database once imported.
   3. Under "Advanced Options" ensure you setup a multisite (subdirectory).
   4. Delete the `wp-content` directory.
   5. In Terminal from the root directory (`/wagner-spray-tech/app/public`), do:
      - `git init`
      - `git remote add origin https://github.com/AEWP/wagner-spray-tech.git`
      - `git fetch`
      - `git checkout -t origin/main`
3. Now pull a backup from WP Engine in order to on-board the latest database and media, as well as check the custom theme and plugin(s) for any changes.
   1. Database - import the database from the backup, ensuring you perform a search and replace on the DB to replace the domain with your local URL.
   2. Media - replace the local `/wp-content/uploads` directory with the version from the backup.
   3. Custom theme & plugin(s) - Copy these files from the backup into the local codebase and run `git status`, to check for any changes that have potentially been made live on the site.
      - If there are any untracked / unstaged files, these need to be committed to the repo.
4. Next add your AEPackagist Satispress authorisation token to the root directory.
   - If you do not have an `auth.json` file yet, read the “[Setup Satispress Authentication](#setup-satispress-authentication)“ step.
   - If you already have an `auth.json` file used in other projects, you can reuse this file again.
5. Once on-boarded locally, in Terminal do: `npm run start` to install Composer and Node dependencies, and build the project's assets.
6. Lastly, in your local environment create an SSL certificate to trust the local site and add a secure connection.
7. Once these steps are complete, the site is now fully on-boarded and ready for development to start.

**Note:** When opening the project in your code editor to start development work, ensure you open the root directory (`/wagner-spray-tech/app/public`), in order for PHPCS (coding standards) and husky (pre-commit hook/checks) to work correctly.

### Setup Satispress Authentication

All free WordPress plugins are available via `wpackagist`. Premium plugins are not available via this service, so a Satispress Composer package server has been created which makes premium plugins available for authenticated users via [SatisPress](https://github.com/cedaro/satispress). Find out more about SatisPress [approach to security](https://github.com/cedaro/satispress/blob/develop/docs/security.md).

1. Firstly, ask for a user account to the Satispress Composer package server, if you do not already have one.
2. Then navigate to the Satispress server and generate and/or copy the API key within Satispress.
3. Now generate an authentication file (`auth.json`) to the server. In Terminal, from the project root directory, do:

```
composer config http-basic.ssplugins.wpengine.com YOUR_SATISPRESS_API_KEY satispress
```

This will generate the `auth.json` file and store it locally, allowing premium plugins to be installed on your local environment.

The Satispress API key should also be added to the repo as a 'secret', and then referenced during the deployment phase to allow install of premium plugins to the site environments.

## Project Structure

There are three plugins we are developing for this project and the site theme.

- `wp-content/plugins/wagner-spray-tech-blocks` -- All the site Gutenberg Blocks.
- `wp-content/plugins/wagner-spray-tech-core` -- All the site Core functionality.
- `wp-content/plugins/wagner-spray-tech-digital-river-integration` -- All of the site Digital River Integration functionality.
- `wp-content/themes/wagner-spray-tech` -- The site theme.

The Core and Digital River plugins are based around a simple container interface, which allows any of the PHP files to easily implment any of the other objects by use of the shared app container.

The Blocks plugin uses core standards to build blocks using blocks.json which are then automatically integrated into the system via the PHP in the plugin, you should not have to adapt this to add any new blocks, simply build the block and drop its directory into `wp-content/plugins/wagner-spray-tech-blocks/src/`.

The Theme is based around our standard project theme structure.

## Assets

There are two parts to asset buildinng for this project: Main and Blocks

### Main Root Build

This will build the theme and Core plugin assets

Webpack is used to compile, minify and copy Sass/CSS, JavaScript and SVG files. The webpack config is defined in the `webpack.config.js` file in the project root directory.

Webpack is controlled by NPM scripts which are defined in `package.json`.

- `npm run start` -- install Composer and NPM dependencies and serve production-ready versions of assets.
- `npm run build` -- build production-ready versions of assets.
- `npm run watch` -- build production-ready versions of assets, and continue watching for updates.
- `npm run lint:css` -- check CSS with Prettier.
- `npm run lint:js` -- check JS with ESLint and Prettier.

### Blocks Build

This will build the Gutenberg Blocks and you will need to run the npm commands from `wp-content/plugins/wagner-spray-tech-blocks`.

- `npm run start` -- install Composer and NPM dependencies and serve production-ready versions of assets.
- `npm run build` -- build production-ready versions of assets.
- `npm run watch` -- build production-ready versions of assets, and continue watching for updates.
- `npm run lint:css` -- check CSS with Prettier.
- `npm run lint:js` -- check JS with ESLint and Prettier.

# Development Process

### Contributions

This project should mostly follow the standard [Git Flow](http://jeffkreeftmeijer.com/2010/why-arent-you-using-git-flow/) model.

Development happens in feature branches, which are merged into `develop`, which in turn is merged into `staging` for QC testing and client review, and then eventually the `main` branch. When making changes, a feature branch should be created which branches from `main`.

Only the `staging` branch should be merged into `main`. The exception to this is hotfixes - these are small, specific issues which need to be deployed outside the standard workflow. Hotfixes should be merged to all three main branches; `develop`, `staging` and `main`.

The workflow should be:

1. Create a working feature branch (from the `main` branch).

```
git checkout -b feature/JIRA_REFERENCE_NUMBER/FEATURE_NAME
```

2. Once the work is completed, make a Pull Request into `develop`.
3. After the code is reviewed, the Project Lead can merge into `develop` for deployment to the Development environment.
4. Once deployed and tested, make a Pull Request into `staging` from `develop` (or the feature branch, if necessary), to deploy to the Staging environment.
5. Once again, after deployment and testing, and the work being signed off by the client, make a Pull Request into `main` from `staging` (or the feature branch, if necessary), to deploy to the Production environment.
6. Only the Servers Team can merge into the `main` branch for deployment to Production.

#### Installing New Plugins

New plugins should be installed via Composer and added to the `composer.json` file, and the `composer.lock` file file (which is used by the CI/CD deployment script to install dependencies) by running `composer update PLUGIN_SOURCE/PLUGIN_SLUG`, for example:

```
composer update wpackagist-plugin/woocommerce
```

## Environments

### Local

This is used for local site development before deploying to a server.

### [Development](https://my.wpengine.com/installs/wagner-spray-techdev)

This is where we share the latest development code - this environment may be displaying any of the current feature branches at any particular moment. Merging into the `develop` branch will trigger automated CI/CD and deploy to this environment.

### [Staging](https://my.wpengine.com/installs/wagner-spray-techtest)

This environment should closely mirror the Production environment. QC tests (automated and manual) should be carried out within the environment, and work ready for client UAT. Merging into the `staging` branch will trigger automated CI/CD and deploy to this environment.

### [Production](https://my.wpengine.com/installs/wagner-spray-tech)

This is the user-facing production code - deployment rights to this environment should be restricted to the Servers Team. Merging into the `main` branch will trigger automated CI/CD and deploy to this environment.

## Code Structure

This repo should contain:

1. Project configuration files including `composer.json`, `package.json`, `webpack.config.js`, `gitignore`, `phpcs.xml`, CI/CD workflows and more.
2. The project specific theme (`wagner-spray-tech`).
3. Must Use Plugins (`mu_plugins`).
4. Custom plugins including `wagner-spray-tech-core`.

**Note:** WordPress is maintained outside of this repo and should _never_ be included within the codebase - WordPress can be considered a dependency served by the WPEngine environment.

# Running Tests

The project contains one type of automated tests:

- **Coding standards** which are run via [PHP Code Sniffer (PHPCS)](https://github.com/squizlabs/PHP_CodeSniffer).

All of the test frameworks are installed with Composer as part of the development environment setup. All of the tests are run via NPM scripts (which in turn, trigger Composer scripts defined in `composer.json`).

- `npm run lint:phpcompat` -- check PHP files for compatibility with PHP 8.0.
- `npm run lint:php` -- check PHP files for compatibility with the WordPress coding standards.
- `npm run lint-fix:php` -- fix errors in PHP files for compatibility with the WordPress coding standards.

## Package Management

This project uses Composer and NPM for package management. Composer is typically used to install build tools and third-party plugins, and NPM is only used to install build tools.

When adding a package (for example, a third-party plugin), you will need to update the following files and add the new directory(s) to the ignore lists:

- `phpcompat.xml.dist` and `phpcs.xml.dist` to prevent automated coding standards checks on third-party packages/plugins.
- `.gitignore` to prevent the folder being added to the Git repository.
- The contents of `/wp-content/plugins/` directory are automatically ignored.

Optionally, if some part of the folder (or all of it) does not need to be included in the production build, update the `.github/assets/blocklist` file.

# Maintenance

## Plugins

When an update to a plugin is required, a new branch should be created and the plugin updates can be tested locally. To update a plugin, change the version number within the `composer.json` file to the most up-to-date version, then run
`composer update` to initiate the update.

The `composer.lock` is in turn updated with the new version number. This file contains the list of instructions used during the CI/CD pipeline to install packages/plugins.

If the local tests are successful, a Pull Request should be created for `develop`. Regression tests (and other QA tests) should be carried out within the `staging` environment before the site is signed-off by QA. Once all tests are passed, the updates should be merged into `main` and deployed on the Production environment (only the Servers Team should deploy to Production environment).

## Updating WordPress

Updating the WordPress version should follow the following workflow:

1. Update locally and test.
2. Create a backup, update the Development environment manually and test.
3. Create a backup, update the Staging environment manually and conduct final tests / confirm client sign off.
4. Create a backup, update the Production environment manually and confirm compatibility.
