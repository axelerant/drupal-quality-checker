# Package for Drupal Code Quality presets

This has been customised from [vijaycs85/drupal-quality-checker](https://packagist.org/packages/vijaycs85/drupal-quality-checker) for Axelerant needs. Apart from a different template file, it uses the Axelerant logo.

## Installation

### When using drupal/core-composer-scaffold (recommended)

In most cases, you would already be using the [`drupal/core-composer-scaffold`](https://packagist.org/packages/drupal/core-composer-scaffold) package if you have set up using the latest Drupal templates. This package uses `core-composer-scaffold` to set up configuration files in your project. To make this work, add this package name in your composer's `extra.drupal-scaffold.allowed-packages` section.

```json
 "name": "my/project",
  ...
  "extra": {
    "drupal-scaffold": {
      "allowed-packages": [
        "axelerant/drupal-quality-checker"
      ],
      ...
    }
  }
```

Now, run `composer require` to include the package in your application. Since the package is now allowed, the `core-composer-scaffold` package will copy the configuration files.

See [More about scaffolding](#more-about-scaffolding) for more details.

### Without drupal/core-composer-scaffold

If you're not using the scaffolding plugin, the package won't copy the configuration files as expected.

First, run `composer require` to include the package in your application.

```bash
composer require --dev axelerant/drupal-quality-checker
```

If you don't already have a `grumphp.yml` file in your project, GrumPHP would ask you to create one. Answer "No" to the prompt.

Then, copy all the `*.dist` from the library to your project root. The files copied are:

* grumphp.yml.dist
* phpcs.xml.dist
* phpmd.xml.dist

```bash
cp vendor/axelerant/drupal-quality-checker/*.yml.dist .
```

## Usage

No additional steps required, but if git hooks aren't fired, run `php ./vendor/bin/grumphp git:init`. For additional commands, look at [grumhp's documentation](https://github.com/phpro/grumphp/blob/master/doc/commands.md).

## Customising

Almost all customising begins with first copying the `grumphp.yml.dist` file to your project. Make sure you have the file.

### Adding tasks

There are various tasks you can add and customise in your grumphp.yml. Read the [online documentation for GrumPHP tasks](https://github.com/phpro/grumphp/blob/master/doc/tasks.md) to see the tasks you can use and configure.

### Forcing commit message format

To configure commit message structure, use the [git_commit_message task](https://github.com/phpro/grumphp/blob/master/doc/tasks/git_commit_message.md). For example, to enforce the commit message contains the Jira issue ID, use the rule as the following snippet. More options are [documented online](https://github.com/phpro/grumphp/blob/master/doc/tasks/git_commit_message.md).

```yaml
# grumphp.yml
parameters:
  tasks:
    git_commit_message:
      matchers:
        Must contain issue number: /JIRA-\d+/
```

### Disable commit banners

GrumPHP supports banners to celebrate (or scold) on your commit. This is fun but it is possible it gets on your nerves. If you don’t want it, edit the grumphp.yml file and replace the following parameters:

```yaml
# grumphp.yml
parameters:
    ascii: ~
```

You could even disable specific ones like this:

```yaml
# grumphp.yml
parameters:
    ascii:
        succeeded: ~
```

### Overwrite phpmd ruleset

Copy the ruleset to the project root first

```bash
cp vendor/axelerant/drupal-quality-checker/phpmd.xml.dist phpmd.xml
```

Edit it as per your needs and commit. Remember to modify the grumphp.yml file with the new path.

```yaml
# grumphp.yml
parameters:
  tasks:
    phpmd:
      ruleset: ['phpmd.xml']
```

### Customise phpcs rules

Copy the ruleset to the project root first

```bash
cp vendor/axelerant/drupal-quality-checker/phpcs.xml.dist phpcs.xml
```

Edit it as per your needs and commit. Remember to modify the grumphp.yml file with the new path.

```yaml
# grumphp.yml
parameters:
  tasks:
    phpcs:
      standard: ['phpcs.xml']
```

## More about scaffolding

As described before, this package uses [`drupal/core-composer-scaffold`](https://github.com/drupal/core-composer-scaffold) plugin to scaffold a few files to the project root. This is not required but there is a good chance you are already using it if you're building a Drupal site.

The scaffolding operation runs with every composer operation and overwrites files. Only the file `grumphp.yml.dist` is not overwritten during subsequent operations. If you are customising any of the other configuration files and don't want the updates to overwrite your changes, you can override the behaviour in your composer.json file. For example, to skip `phpmd.xml.dist` from being overwritten, add this to your `composer.json`:

```json
  "name": "my/project",
  ...
  "extra": {
    "drupal-scaffold": {
      "file-mapping": {
        "[project-root]/phpmd.xml.dist": false
      }
    }
  }
```

For more details, read the ["Excluding Scaffold files"](https://github.com/drupal/core-composer-scaffold#excluding-scaffold-files) section of the [documentation](https://github.com/drupal/core-composer-scaffold/blob/8.8.x/README.md) for the core-composer-scaffold plugin.
