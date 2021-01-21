# CXL Common Lib
Primary library, which holds common / shared code for various projects, like Institute &amp; Jobs etc.

## Requirements

There's a few requirements in order to contribute back to the project:

* PHP 5.6+ (preferably 7+).
* WordPress 5.2+.
* Gutenberg 5.6+ or WordPress 5.2+ for Gutenberg block styles.

### Build Process

The following is a list of commands you can run from the command line:

```bash

# Install composer packages
composer i

# Install npm packages
npm i
```

## Preparing your plugin for release

Whether you're going to upload to a site via FTP or create a ZIP to for users to download, you'll want to have all the files you need neatly packaged for production.  CXL Blocks has the tools for this, but you'll want to follow a specific order to get everything right.

Before beginning, make sure to navigate to your plugin folder via the command line to make sure you're in the right place.

```bash
cd path/to/wp-content/plugins/your-plugin
```

### Step 1: Switch Composer to production

You need to switch your Composer files to production, rather than development.  This will remove files that you don't need in a production environment.

```bash
composer update --prefer-dist --no-dev
```

### Step 2: Build plugin

The build process is a combination of commands run in the following order:

- `i18n` - Adds textdomains and creates a POT file.
- `export` - Creates a `/<plugin-slug>` folder in your plugin for distribution.

You can run those manually or simply run:

```bash
npm run build
```

From this point, you can create a ZIP folder with the zipping utility on your computer or simply upload the files to a site.

### Step 3: Switch Composer back to dev

Note that you changed your Composer environment to production in Step 1. You'll likely want to switch it back to development at some point.  To do so, you simply run the following command:

```bash
composer update
```

## Copyright and License

CXL Blocks is licensed under the [GNU GPL](https://www.gnu.org/licenses/gpl-2.0.html), version 2 or later.

2021 &copy; CXL.
