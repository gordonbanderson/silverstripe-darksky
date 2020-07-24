# Dark Sky SilverStripe Client
[![Build Status](https://travis-ci.org/gordonbanderson/silverstripe-darksky.svg?branch=master)](https://travis-ci.org/gordonbanderson/silverstripe-darksky)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gordonbanderson/silverstripe-darksky/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gordonbanderson/silverstripe-darksky/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/gordonbanderson/silverstripe-darksky/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gordonbanderson/silverstripe-darksky/build-status/master)
[![codecov.io](https://codecov.io/github/gordonbanderson/silverstripe-darksky/coverage.svg?branch=master)](https://codecov.io/github/gordonbanderson/silverstripe-darksky?branch=master)

[![Latest Stable Version](https://poser.pugx.org/suilven/silverstripe-darksky/version)](https://packagist.org/packages/suilven/silverstripe-darksky)
[![Latest Unstable Version](https://poser.pugx.org/suilven/silverstripe-darksky/v/unstable)](//packagist.org/packages/suilven/silverstripe-darksky)
[![Total Downloads](https://poser.pugx.org/suilven/silverstripe-darksky/downloads)](https://packagist.org/packages/suilven/silverstripe-darksky)
[![License](https://poser.pugx.org/suilven/silverstripe-darksky/license)](https://packagist.org/packages/suilven/silverstripe-darksky)
[![Monthly Downloads](https://poser.pugx.org/suilven/silverstripe-darksky/d/monthly)](https://packagist.org/packages/suilven/silverstripe-darksky)
[![Daily Downloads](https://poser.pugx.org/suilven/silverstripe-darksky/d/daily)](https://packagist.org/packages/suilven/silverstripe-darksky)
[![composer.lock](https://poser.pugx.org/suilven/silverstripe-darksky/composerlock)](https://packagist.org/packages/suilven/silverstripe-darksky)

[![GitHub Code Size](https://img.shields.io/github/languages/code-size/gordonbanderson/silverstripe-darksky)](https://github.com/gordonbanderson/silverstripe-darksky)
[![GitHub Repo Size](https://img.shields.io/github/repo-size/gordonbanderson/silverstripe-darksky)](https://github.com/gordonbanderson/silverstripe-darksky)
[![GitHub Last Commit](https://img.shields.io/github/last-commit/gordonbanderson/silverstripe-darksky)](https://github.com/gordonbanderson/silverstripe-darksky)
[![GitHub Activity](https://img.shields.io/github/commit-activity/m/gordonbanderson/silverstripe-darksky)](https://github.com/gordonbanderson/silverstripe-darksky)
[![GitHub Issues](https://img.shields.io/github/issues/gordonbanderson/silverstripe-darksky)](https://github.com/gordonbanderson/silverstripe-darksky/issues)

![codecov.io](https://codecov.io/github/gordonbanderson/silverstripe-darksky/branch.svg?branch=master)



## Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Issues](#issues)
- [Contribution](#contribution)
- [Maintainers](#maintainers)
- [License](#license)


## Installation

Use Composer:

```bash
composer require suilven/silverstripe-darksky
```

After the repo has cloned, you will need to run the `setup.php` script:

```bash
$ cd my-repo-name
$ php ./setup.php
```

The setup script will ask a series of questions to gather data about
your new module:

```bash
$ php ./setup.php
================================================================================
SILVERSTRIPE MODULE SETUP
================================================================================
> Loading config file...
> Checking files...
> Files OK!

```

If a question has a default value, just hit enter to accept the default.

After answering each question, the script will then process the necessary
files by replacing named tokens in each file with the corresponding setup value.

By default, these files are:

- `_config.php`
- `_config/config.yml`
- `admin/client/src/bundles/bundle.js`
- `admin/client/src/styles/_variables.scss`
- `admin/client/src/styles/bundle.scss`
- `client/src/bundles/bundle.js`
- `client/src/styles/_variables.scss`
- `client/src/styles/bundle.scss`
- `composer.json`
- `package.json`
- `webpack.config.js`

Each file needs to readable and writable. The setup script will first
verify that it can process each file before proceeding.

## Configuration

Oh Apple have bought the service, so you cannot sign up for an API key...



## Continuous Integration
The following services are free for open source repositories.  Note that both Scrutinizer and CodeCov show your source
code, as such if you are writing closed source code you will need to either pay for these services or remove them from
the continuous integration files.  Both CodeCov and Scrutinizer can be integrated with GitHub.

### Unit Testing
Pushes are run against Travis

### Code Coverage
The CI files upload code coverage to a third party service called CodeCov.  To see your test coverage, open an account

### Code Quality
Scrutinizer is a third party service that staticaly analyzes your code looking for likes of PSR violations, formatting,
and complex code (i.e. code smells).  A sample configuration file is provided.  You will need to set up an account and

## Issues
Please use the [GitHub issue tracker][issues] for bug reports and feature requests.

## Contribution

Your contributions are gladly welcomed to help make this project better.
Please see [contributing](CONTRIBUTING.md) for more information.

## Maintainers

[![Gordon Anderson](https://avatars2.githubusercontent.com/u/7060?s=144&u=4535192eb64a73e48e927f55830f6db04ff4f08c&v=4)](https://github.com/gordonbanderson)

## Attribution
### Weather Icons
Fhatkul Karim, https://www.iconfinder.com/iconsets/weather-line-19

## License

[MIT](LICENSE.md)

[silverstripe]: https://github.com/silverstripe/silverstripe-framework
[webpack]: https://webpack.js.org
[issues]: https://github.com/gordonbanderson/silverstripe-darksky/issues
