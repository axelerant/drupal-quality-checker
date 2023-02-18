# Changelog

## 1.4.0 / 2023-02-18

* Fork project
* Update README
* Update requires :
  * [drupal/coder](https://packagist.org/packages/drupal/coder) from `^8.3.7` to `8.3.*`
  * [friendsoftwig/twigcs](https://packagist.org/packages/friendsoftwig/twigcs) from `^4.0 || ^5.0 || ^6.0` to `6.*`
  * [php-parallel-lint/php-parallel-lint](https://packagist.org/packages/php-parallel-lint/php-parallel-lint) from `^1.2` to `1.3.*`
  * [phpcompatibility/php-compatibility](https://packagist.org/packages/phpcompatibility/php-compatibility) from `^9.0` to `9.3.*`
  * [phpmd/phpmd](https://packagist.org/packages/phpmd/phpmd) from `^2.8` to `2.13.*`
  * [phpro/grumphp-shim](https://packagist.org/packages/phpro/grumphp-shim) from `^1.0.0` to `1.15.*`
  * [sebastian/phpcpd](https://packagist.org/packages/sebastian/phpcpd) from `^1.0.0` to `6.0.3` (the latest version ever)
* Add require-dev : [roave/security-advisories](https://packagist.org/packages/roave/security-advisories)
* Use Drupal's logos
* Add .idea in .gitignore
* Update PHPCS & PHPMD dist files

## 1.3.0 / 2022-12-17

* Drop twigcs support for 3.2 and allow twigcs 6.0 to be used.
* Change the error graphic for clarity

## 1.2.0 / 2021-10-31

* Add a branch alias for 1.0.x
* Enable a PHP 8 compatible version of TwigCS to be installed
* Exclude "\Drupal\Core\Render\Element\Checkboxes" class of PHPMD StaticAccess rule (#17)
* Exclude "\Drupal\Component\Plugin\Factory\DefaultFactory" static access
* Exclude "\Drupal\Core\Site\Settings" static access
* Add common ignores to PHPCS
* Modify readme file to change syntax for copying all dist files
* Explicitly set twigcs ruleset
* Exclude MissingImport from cleancode rules

## 1.1.0 / 2020-11-06

* Allow more versions of phpcpd to be installed
* Allow twigcs 4.0 to be used
* Remove composer from require-dev
* Fixes #6. Use GrumPHP stable version release
* Merge pull request #5 from mohit-rocks/master
* Adding support for twigcs so it gets automatically downloaded

## 1.0.0 / 2020-07-12

* Replace abandoned package with replacement
* Add video of upgrade to README

## 1.0.0-beta9 / 2020-06-10

* Update README for changes from GrumPHP 0.19
* Introduce smaller versions of ASCII art
* Move to grumphp-shim's latest version (**breaking release**, read documentation)

## 1.0.0-beta8 / 2020-06-10

* Update phpcs.xml.dist with one matching Drupal core

## 1.0.0-beta7 / 2020-04-24

* Move composer to require-dev

## 1.0.0-beta6 / 2020-04-21

* Use the scaffold plugin to copy files
* Upgrade to GrumPHP 0.18
