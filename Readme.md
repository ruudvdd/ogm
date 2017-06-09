# OGM
Library to generate and validate Belgian OGM's.

An OGM is a Belgian format used to automatically identify
payments. The typical structure of an OGM is `+++090/9337/55493+++` or `***090/9337/55493***`.
In total the OGM contains 12 digits. A group of 3, 4 and 5 digits separated by /, and starting and ending with '+++' or '***'.
The last 2 digits of a valid OGM is the remainder of the euclidean division of the first 10 digits of the OGM and 97.
When the remainder is 0, the last 2 digits are 97. [Wikipedia (Dutch)](https://nl.wikipedia.org/wiki/Gestructureerde_mededeling)

# Setup / installation

```sh
$ composer require ruudvdd/ogm
```

# Usage
## Generate

```php
$generator = new \Ruudvdd\OGM\Generator();

// Plain number (default)
$generator->generate(false);

// Formatted
$generator->generate(true);

// Choose the first x digits (max 10)
$generator->generate(false, 1234);

```

## Validate

```php
$validator = new \Ruudvdd\OGM\Validator();

// Validate a formatted OGM
$validator->isValid('+++090/9337/55493+++'); // true

// Validate a plain number (12 digits)
$validator->digitsAreValid('090933755493');

```
