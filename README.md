IMAGE HANDLER (for Laravel 5)
--------------------------------

[![Latest Stable Version](https://poser.pugx.org/amostajo/laravel-image-handler/v/stable)](https://packagist.org/packages/amostajo/laravel-image-handler)
[![Total Downloads](https://poser.pugx.org/amostajo/laravel-image-handler/downloads)](https://packagist.org/packages/amostajo/laravel-image-handler)
[![License](https://poser.pugx.org/amostajo/laravel-image-handler/license)](https://packagist.org/packages/amostajo/laravel-image-handler)

Image handling solution for [Laravel 5](http://laravel.com/), creates thumbs on the fly, handles image cropping, upscaling and resizing.

Works with **Laravel 5.1**.

## Installation

Add

```json
"amostajo/laravel-image-handler": "v1.0.0"
```

to your `composer.json`. Then run `composer install` or `composer update`.

Then in your `config/app.php` add

```php
Amostajo\LaravelImageHandler\Providers\ImageHandlerProvider::class,
```

in the providers array.

Then add

```php
'ImageHandler'      => Amostajo\LaravelImageHandler\Facades\ImageHandler::class,
```
    
in the `aliases` array.

Copy and rename the config file `[package]\config\config.php` to your laravel's config directory `[root]\config\image.php`.

## Usage

Creating a thumb for an image have never been this easy:

```php
// $imageUrl is exactly that, an image url.
// From either your own website or from an external source.
$url = ImageHandler::thumb($imageUrl);
```

**ImageHandler** will actually create a thumb and place it in `public/thumbs` directory.

The returned `$url` can be placed in a `img` html tag like this (sample using blade):

```html
<img src="{{ ImageHandler::thumb($imageUrl) }}"/>
```

![Thumb](http://s14.postimg.org/6j0rz20ql/beach_100x100.jpg)

The thumb created will always be cropped to fit the desired size. By default, the thumb will be cropped to the width and height specified in the configuration file, although you can easily set these as parameters:

```html
<img src="{{ ImageHandler::thumb($imageUrl, 800, 180) }}"/>
```

![Thumb](http://s22.postimg.org/wvcf9ny81/beach_800x180.jpg)

If you don't want the image to be cropped, prefer to keep constraints and just resize, use these methods instead:

```php
// Resized / scaled to a specific width
$url = ImageHandler::width($imageUrl);


// Resized / scaled to a specific height
$url = ImageHandler::height($imageUrl);
```

```html
<img src="{{ ImageHandler::width($imageUrl, 350) }}"/>
```

![Thumb](http://s9.postimg.org/z3nppwyz3/sheep_350x.jpg)

```html
<img src="{{ ImageHandler::height($imageUrl, 350) }}"/>
```

![Thumb](http://s30.postimg.org/mi9f00ekh/sheep_x350.jpg)

## Configuration

Modify the configuration file to adjust the default thumb sizes, set the name of the folder path for the thumbs to be stored and more.

## License

This package is free software distributed under the terms of the MIT license.

## Additional Information

This package uses [php-image-resize](https://github.com/eventviva/php-image-resize).

### Image credits
 
[Beach](http://beachgrooves.com/wp-content/uploads/2014/07/beach.jpg)
Taken from http://beachgrooves.com on 1st of July of 2015.

[Sheep](http://static.guim.co.uk/sys-images/Guardian/Pix/pictures/2014/4/11/1397210130748/Spring-Lamb.-Image-shot-2-011.jpg)
Taken from https://guim.co.uk on 1st of July of 2015.