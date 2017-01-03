PearyBundle
========================

Developpement in progress...

Made for implement quickly some tools and monitoring capabilities on new projects.

Instalation
-----------

Install via composer

composer require vted/peary

Enable the bundle in your kernel

# app/AppKernel.php
$bundles = [
    ...
    new Vted\PearyBundle\VtedPearyBundle(),
    ...
];

Add routing

# app/config/routing.yml
vted_peary:
    resource: "@VtedPearyBundle/Resources/config/routing.yml"
    prefix:   /_peary/

