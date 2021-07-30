# PHPconvertDMSToDecimal
A PHP function that will convert a coordinate in DMS (degrees / minutes / seconds) or DM only to decimal degrees.

Strictly speaking it will also accept decimal degrees.  I wanted a function that could parse any latitude or longitude that a user may input.

The code is compatible with any PHP version above 5.0.

## Installation guide

### If your project doesn't use composer
Just do a _require_once()_ of the _convert.php_ file.

### If your project uses composer

First you need to add this repository in your _composer.json_ file. For instance:
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/prairiewest/PHPconvertDMSToDecimal.git"
    }
]
```

Then you have to do a 

```
composer require prairiewest/phpconvertdmstodecimal
```

Finally, in your code, you just have to call the library directly, or, if your project
uses namespaces, you need to include it in your class:

```
use function convertDMSToDecimal;

// or

use DmsToDecimalConverter
```

## Utilization
You can either use it as an object or directly:

```
// Directly:
convertDMSToDecimal($coords);

// As an object:
$converter = new DmsToDecimalConverter();
$outputValue = $converter->convert($entryValue);
```
