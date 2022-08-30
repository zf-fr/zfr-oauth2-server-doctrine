# zfr-oauth2-server-doctrine

Doctrine 2 adapter for [ZfrOAuth2Server](http://github.com/zf-fr/zfr-oauth2-server)

[![Build Status](https://travis-ci.org/zf-fr/zfr-oauth2-server-doctrine.png)](https://travis-ci.org/zf-fr/zfr-oauth2-server-doctrine)
[![Latest Stable Version](https://poser.pugx.org/zfr/zfr-oauth2-server-doctrine/v/stable.png)](https://packagist.org/packages/zfr/zfr-oauth2-server-doctrine)
[![Coverage Status](https://coveralls.io/repos/github/zf-fr/zfr-oauth2-server-doctrine/badge.svg?branch=master)](https://coveralls.io/github/zf-fr/zfr-oauth2-server-doctrine?branch=master)
[![Total Downloads](https://poser.pugx.org/zfr/zfr-oauth2-server-doctrine/downloads.png)](https://packagist.org/packages/zfr/zfr-oauth2-server-doctrine)
[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/prolic/zfr-oauth2-server)


## Requirements

- PHP 7.4 or higher
- doctrine/orm ^2.7

## Installation

Installation is only officially supported using Composer:

```sh
php composer.phar require zfr/zfr-oauth2-server-doctrine:^0.3
```

## Support

- File issues at [https://github.com/zf-fr/zfr-oauth2-server-doctrine/issues](https://github.com/zf-fr/zfr-oauth2-server-doctrine/issues).
- Say hello in our [gitter](https://gitter.im/prolic/zfr-oauth2-server) chat.


## Configuration

to be written

## Second level cache

Scope and tokens are marked cacheable to take advantage of Doctrine 2.5 ORM second level cache. However, you
need to configure the regions yourself.
