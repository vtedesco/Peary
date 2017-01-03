PearyBundle
========================

Developpement in progress...
Made for implement quickly some tools and monitoring capabilities on new projects.
Currently let you :
- Log 404 and 500 errors and display them
- Display Monolog errors

Interface preview:
![PearyBundle preview](http://i.imgur.com/Su9Fsoh.png)

Instalation
-----------

Make sure you have asseticBundle installed

Install via composer
```shell
composer require vted/peary
```
Enable the bundle in your kernel
```php
# app/AppKernel.php
$bundles = [
    ...
    new Vted\PearyBundle\VtedPearyBundle(),
    ...
];
```
Add routing
```yaml
# app/config/routing.yml
vted_peary:
    resource: "@VtedPearyBundle/Resources/config/routing.yml"
    prefix:   /_peary/
```
