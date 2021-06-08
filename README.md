# Generic Address bundle - C&M

Generic Address bundle is a bundle for OroPlatform / OroCRM project. It allows to add addresses easily on any entity.

Made with :blue_heart: by C&M

## Versions

| Bundle version                      | OroPlaftorm version |
| ----------------------------------- | ------------------- |
| 1.1.*                               | 4.1.*               |
| 1.0.*                               | 3.1.*               |

## Installation

### Download the Bundle

```console
$ composer require "clickandmortar/oro-platform-generic-address-bundle" "1.1.*"
```

### Enable the Bundle

Edit your `config.yml` file to expose js routing:

```
fos_js_routing:
    routes_to_expose:         [...,candm_*,...]
```

Bundle is enabled automatically by `bundles.yml` file.
Run only following commands:

```
php bin/console cache:clear
php bin/console fos:js-routing:dump
php bin/console doctrine:schema:update --force
php bin/console oro:entity-config:update --filter="ClickAndMortar*" --force
php bin/console oro:migration:data:load --bundles="ClickAndMortarGenericAddressBundle"
```

