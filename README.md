# Package for Drupal Code Quality presets

Composer plugin bringing Axelerant's GrumPHP, phpcs, phpmd and phpstan presets to a Drupal project.

## Status

active

Customised from [vijaycs85/drupal-quality-checker](https://packagist.org/packages/vijaycs85/drupal-quality-checker)
for Axelerant, with a different template file and the Axelerant logo.

## Requirements

| Tool | Version |
| --- | --- |
| PHP | as required by the installed `grumphp-shim` |
| Composer | 2 |

`composer.json` is authoritative; this table summarises it.

## Quick start

```bash
composer require --dev axelerant/drupal-quality-checker
```

That adds the plugin and copies the default configuration into the project:
`grumphp.yml.dist`, `phpcs.xml.dist`, `phpmd.xml.dist` and `phpstan.neon.dist`.

Because they are `.dist` files the plugin overwrites them on every
`composer install`. To customise a preset, rename the file without the suffix
and add the `.dist` copies to `.gitignore`.

No further setup is needed. If the git hooks do not fire:

```bash
php ./vendor/bin/grumphp git:init
```

## Common commands

| Command | What it does |
| --- | --- |
| `composer require --dev axelerant/drupal-quality-checker` | Install into a project |
| `php ./vendor/bin/grumphp git:init` | Reinstall the git hooks when they do not fire |
| `php ./vendor/bin/grumphp run` | Run every configured task now |
| `composer validate --strict` | Check this plugin's own manifest |
| `cp vendor/axelerant/drupal-quality-checker/phpmd.xml.dist phpmd.xml` | Take over the phpmd ruleset |
| `cp vendor/axelerant/drupal-quality-checker/phpcs.xml.dist phpcs.xml` | Take over the phpcs ruleset |

For the rest, see [GrumPHP's command documentation](https://github.com/phpro/grumphp/blob/master/doc/commands.md).

## How we work here

Branch, open a pull request, and have it reviewed. A change to a shipped preset
changes every project that installs this plugin, so it is released rather than
merged quietly. Note it in `CHANGELOG.md`.

## Ownership

Owned by @hussainweb.

No team owns this repository, so questions go to the owner. Open an issue at
https://github.com/axelerant/drupal-quality-checker/issues for anything else.
That is the support route for this package, including for people outside
Axelerant who install it.

## Documentation

- [Documentation map](docs/README.md) — where do I start?
- [Architecture](docs/architecture.md) — how does the plugin reach a project?

## Distribution

Published on Packagist as `axelerant/drupal-quality-checker` and installed as a
Composer dev dependency.

## Customising

Almost all customising begins with first copying the `grumphp.yml.dist` file to your project. Make sure you have the file.

### Adding tasks

There are various tasks you can add and customise in your grumphp.yml. Read the [online documentation for GrumPHP tasks](https://github.com/phpro/grumphp/blob/master/doc/tasks.md) to see the tasks you can use and configure.

### Forcing commit message format

To configure commit message structure, use the [git_commit_message task](https://github.com/phpro/grumphp/blob/master/doc/tasks/git_commit_message.md). For example, to enforce the commit message contains the Jira issue ID, use the rule as the following snippet. More options are [documented online](https://github.com/phpro/grumphp/blob/master/doc/tasks/git_commit_message.md).

```yaml
# grumphp.yml
grumphp:
  tasks:
    git_commit_message:
      matchers:
        Must contain issue number: /JIRA-\d+/
```

### Disable commit banners

GrumPHP supports banners to celebrate (or scold) on your commit. This is fun but it is possible it gets on your nerves. If you don’t want it, edit the grumphp.yml file and replace the following parameters:

```yaml
# grumphp.yml
grumphp:
    ascii: ~
```

You could even disable specific ones like this:

```yaml
# grumphp.yml
grumphp:
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
grumphp:
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
grumphp:
  tasks:
    phpcs:
      standard: ['phpcs.xml']
```

### Customise phpstan rules

Copy the ruleset to the project root first

```bash
cp vendor/axelerant/drupal-quality-checker/phpstan.neon.dist phpstan.neon
```

Edit it as per your needs and commit. Remember to modify the grumphp.yml file with the new path.

```yaml
# grumphp.yml
grumphp:
  tasks:
    phpstan:
      configuration: phpstan.neon
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

## Upgrading from Beta 8

GrumPHP 0.19 introduced [a breaking change](https://github.com/phpro/grumphp/releases/tag/v0.19.0) to the structure of the YAML file. The template in this repository is updated as per the new structure. However, you would need to change the YML files on your projects before you update to Beta 9 or later.

Fortunately, the change is simple and in many cases would only require a one line change. Rename the `parameters` section to `grumphp`. Our default template contains two parameters which still need to remain under `parameters`. They are `git_dir` and `bin_dir`. Look at [the diff of the change](https://github.com/axelerant/drupal-quality-checker/commit/e8d9414ce6ea046b0386115764db68e5251d8a58#diff-94c8df1b4af91d80f7417cad14bbe0e5) to understand what needs to be changed in your grumphp.yml file. Also, read more at the [release page for GrumPHP 0.19](https://github.com/phpro/grumphp/releases/tag/v0.19.0).

Lastly, you can [watch this video](https://youtu.be/XoFJfBcZF58) where I upgrade this on a project. Link: https://youtu.be/XoFJfBcZF58
