# Package for Drupal Code Quality presets

This has been customised from [vijaycs85/drupal-code-quality](https://packagist.org/packages/vijaycs85/drupal-quality-checker) for Axelerant needs. Apart from a different template file, it uses the Axelerant logo.

## Installation

First, run `composer require` to include the package in your application.

```bash
composer require --dev axelerant/drupal-code-quality
```

Then, copy the `grumphp.yml.dist` from the library to your project root.

```bash
cp vendor/axelerant/drupal-code-quality/grumphp.yml.dist grumphp.yml
```

There is also a phpmd.xml.dist you may copy and edit if you wish (don't forget to change the grumphp.yml in your project as well).

## Usage

No additional steps required, but if git hooks aren't fired, run `php ./vendor/bin/grumphp git:init`. For additional commands, look at [grumhp's documentation](https://github.com/phpro/grumphp/blob/master/doc/commands.md).
