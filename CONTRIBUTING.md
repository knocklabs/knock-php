# Contributing

## Getting Started

1. Install [asdf](https://asdf-vm.com)

2. Install the asdf PHP plugin

```bash
asdf plugin add php https://github.com/asdf-community/asdf-php.git # Visit that repository to see installation prerequisites
```

3. Run `asdf install` to install the version of PHP specified in the [.tool-versions](.tool-versions) file
4. Run `composer install` to install dependencies

Note that installing PHP via ASDF requires a number of dependencies. Instructions are in the [asdf-php plugin](https://github.com/asdf-community/asdf-php.git) repository. The instructions steps may fail, and are highly sensitive to your local environment. If you are having difficulty running tests or other functions, you can alternatively commit and push to a branch and let GitHub Actions run the tests & formatting for you.

Future improvements to this repository could include using Docker to encapsulate the environment and dependencies for running tests & other tools.

## Running tests

`./vendor/bin/phpunit`

## Formatting

`./vendor/bin/php-cs-fixer fix`

## Linting

`./vendor/bin/phpstan analyse`
