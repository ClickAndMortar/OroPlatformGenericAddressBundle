# Generic Address bundle - C&M

Generic Address bundle is a bundle for OroPlatform / OroCRM project. It allows to add addresses easily on any entity.

Made with :blue_heart: by C&M

## Installation

### Download the Bundle

```console
$ composer require clickandmortar/oro-platform-generic-address-bundle
```

### Enable the Bundle

Bundle is enabled automatically by `bundles.yml` file.
Run only following commands:

```
php bin/console cache:clear
php bin/console doctrine:schema:update --force
php bin/console oro:entity-config:update --filter="ClickAndMortar*" --force
```