IMAGE HANDLER (for Laravel 5)
--------------------------------

Image handling solution for [Laravel 5](http://laravel.com/), works with **Laravel 5.1**.

## Installation

Add

```json
"amsgames/laravel-image-handler": "v1.0.0"
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

Create a new folder under your `directory` and call it `thumbs`, the final path should look like

```bash
[root]\public\thumbs
```

Here is were the created thumbs will be located.

## Usage

Creating a thumb for an image have never been this easy:

```php
// $imageUrl is exactly that, an image url.
// From either your own website or from an external source.
$url = ImageHandler::thumb($imageUrl);
```

The returned `$url` can be placed in a `img` html tag like this (sample using blade):

```html
<img src="{{ ImageUrl::thumb($imageUrl) }}"/>
```

![Thumb](http://s14.postimg.org/6j0rz20ql/beach_100x100.jpg)

The thumb created will always be cropped to fit the desired size. By default, the thumb will be cropped to the width and height specified in the configuration file, although you can easily set these as parameters:

```html
<img src="{{ ImageUrl::thumb($imageUrl, 800, 180) }}"/>
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
<img src="{{ ImageUrl::width($imageUrl, 350) }}"/>
```

![Thumb](http://s9.postimg.org/z3nppwyz3/sheep_350x.jpg)
```

```html
<img src="{{ ImageUrl::height($imageUrl, 350) }}"/>
```

![Thumb](http://s30.postimg.org/mi9f00ekh/sheep_x350.jpg)

## Configuration

Modify the configuration file to adjust the default thumb sizes, set the name of the folder path for the thumbs to be stored and more.

## License

This package is free software distributed under the terms of the MIT license.

## Additional Information

This package uses the official [php-image-resize](https://github.com/eventviva/php-image-resize) package.