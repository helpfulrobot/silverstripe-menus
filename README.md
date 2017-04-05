# Silverstripe menus


## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require silverstripe-modular-project/silverstripe-menus
```

## Creating custom menus

As it is common to reference MenuSets by name in templates, you can configure sets to be created automatically during the /dev/build task. These sets cannot be deleted through the CMS.

```
MenuSet:
  sets:
    main: Main menu
    footer: Footer menu
```

## Adding links to menus

Once you have created your menus you can add links.

## Usage in template

```
<ul>
    <% loop MenuSet('footer') %>
        <li>
            {$Me}
        </li>
    <% end_loop %>
</ul>
```
