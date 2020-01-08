# Package for Drupal Code Quality presets

This has been customised from [vijaycs85/drupal-quality-checker](https://packagist.org/packages/vijaycs85/drupal-quality-checker) for Axelerant needs. Apart from a different template file, it uses the Axelerant logo.

## Installation

First, run `composer require` to include the package in your application.

```bash
composer require --dev axelerant/drupal-quality-checker
```

Then, copy the `grumphp.yml.dist` from the library to your project root.

```bash
cp vendor/axelerant/drupal-quality-checker/grumphp.yml.dist grumphp.yml
```

There is also a phpmd.xml.dist you may copy and edit if you wish (don't forget to change the grumphp.yml in your project as well).

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
