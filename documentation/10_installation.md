# Installation
Execute the following commands, and you are ready to go:

```
COMPOSER_MEMORY_LIMIT=-1 composer require passioneight/pimcore-steam-web-api

php bin/console pimcore:bundle:enable PimcoreSteamWebApiBundle
```

> All `ClassDefinition`s will be available after installing the bundle - unless the same classes exist already.

### [Next Chapter: Prerequisites](/documentation/15_prerequisites.md)