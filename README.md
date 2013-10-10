oxid-errorhandler
=================

Better Error Pages for Oxid E-Sales.

This will give you a more sophisticated output when running the oxid e-shop with the iDebug setting set to -1,
please be sure that you also need to active display_errors otherwise this will not work.

This is a shameless rip of what the great [symfony2](https://github.com/symfony/symfony) framework does,
most of the code comes from their error handling parts. I just ported the twig templates to smarty, made
it PHP 5.2 compatible and included some more reflection info useful for Oxid development.

![Alt text](/screenshot.jpg "Screenshot")
