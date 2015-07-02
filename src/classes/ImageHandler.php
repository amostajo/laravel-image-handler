<?php

namespace Amostajo\LaravelImageHandler\Classes;

/**
 * Image Handler provides methods for easy image handling. 
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\LaravelImageHandler
 */

use File;
use Eventviva\ImageResize;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class ImageHandler
{
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new confide instance.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app; Cache::flush();
        
        $path = public_path() . Config::get('image.thumbs_folder');
        
        if (!File::isWritable($path))
		{
		    File::makeDirectory($path);
		}
    }

	/**
	 * Returns a thumb url based on the url an size provided.
	 *
	 * @param string $url 	 Base url.
	 * @param int    $width  Returned image width.
	 * @param int    $height Returned image height.
	 *
	 * @return string
	 */
	public static function thumb($url, $width = 0, $height = 0)
	{
		if (empty($width) || !is_numeric($width)) $width = config('image.thumbs_width');

		if (empty($height) || !is_numeric($height)) $height = config('image.thumbs_height');

		$info = pathinfo($url);

		if (!isset($info['extension'])) {

			$uniqid = explode('&', $info['filename']);

			$info['filename'] = $uniqid[count($uniqid) - 1];

			$info['extension'] = 'jpg';

		}

		$info['extension'] = explode('?', $info['extension'])[0];

		$cacheKey = preg_replace(
			[
				'/:filename/',
				'/:width/',
				'/:height/',
			], 
			[
				$info['filename'],
				$width,
				$height
			], 
			config('image.cache_key_format')
		);

		return Cache::remember($cacheKey, config('image.cache_minutes'), function () use($url, $width, $height, $info) {

			$assetPath = sprintf(
					'%s%s_%sx%s.%s',
					Config::get('image.thumbs_folder'),
					$info['filename'],
					$width,
					$height,
					$info['extension']
			);

			if (!file_exists(public_path() . $assetPath)) {

				$image = new ImageResize($url);

				/// Process image
				$size = getimagesize($url);

				// Resize to fit wanted width is too small
				if ($size[0] < $width) {

					$scaledPath = sprintf(
						'%s%s_%sx.%s',
						Config::get('image.thumbs_folder'),
						$info['filename'],
						$width,
						$info['extension']
					);

					$image->interlace = 1;

					$image->scale(ceil(100 + ((($width - $size[0]) / $size[0]) * 100)));

					$image->save(public_path() . $scaledPath);

					$image = new ImageResize(URL::asset($scaledPath));

					$size = getimagesize(URL::asset($scaledPath));
				}

				// Resize to fit wanted height is too small
				if ($size[1] < $height) {

					$scaledPath = sprintf(
						'%s%s_x%s.%s',
						Config::get('image.thumbs_folder'),
						$info['filename'],
						$height,
						$info['extension']
					);

					$image->interlace = 1;

					$image->scale(ceil(100 + ((($height - $size[1]) / $size[1]) * 100)));

					$image->save(public_path() . $scaledPath);

					$image = new ImageResize(URL::asset($scaledPath));
				}

				// Final crop
				$image->crop($width, $height);

				$image->save(public_path() . $assetPath);
			}

			return URL::asset($assetPath);

		});
	}

	/**
	 * Returns a resized image url.
	 * Resized on width constraint.
	 *
	 * @param string $url   Base url.
	 * @param int    $width Width to resize to.
	 *
	 * @return string
	 */
	public static function width($url, $width = 0)
	{
		if (empty($width) || !is_numeric($width)) $width = config('image.thumbs_width');

		$info = pathinfo($url);

		$cacheKey = preg_replace(
			[
				'/:filename/',
				'/:width/',
				'/:height/',
			], 
			[
				$info['filename'],
				$width,
				'',
			], 
			config('image.cache_key_format')
		);

		return Cache::remember($cacheKey, config('image.cache_minutes'), function () use($url, $width, $info) {
			
			$size = getimagesize($url);

			$assetPath = sprintf(
				'%s%s_%sx.%s',
				Config::get('image.thumbs_folder'),
				$info['filename'],
				$width,
				$info['extension']
			);

			if (!file_exists(public_path() . $assetPath)) {

				$image = new ImageResize($url);

				$image->interlace = 1;

				$image->scale(ceil(100 + ((($width - $size[0]) / $size[0]) * 100)));

				$image->save(public_path() . $assetPath);
			}

			return URL::asset($assetPath);
		});
	}

	/**
	 * Returns a resized image url.
	 * Resized on height constraint.
	 *
	 * @param string $url    Base url.
	 * @param int    $height Height to resize to.
	 *
	 * @return string
	 */
	public static function height($url, $height = 0)
	{
		if (empty($height) || !is_numeric($height)) $height = config('image.thumbs_height');

		$info = pathinfo($url);

		$cacheKey = preg_replace(
			[
				'/:filename/',
				'/:width/',
				'/:height/',
			], 
			[
				$info['filename'],
				'',
				$height,
			], 
			config('image.cache_key_format')
		);

		return Cache::remember($cacheKey, config('image.cache_minutes'), function () use($url, $height, $info) {
			
			$size = getimagesize($url);

			$assetPath = sprintf(
				'%s%s_x%s.%s',
				Config::get('image.thumbs_folder'),
				$info['filename'],
				$height,
				$info['extension']
			);

			if (!file_exists(public_path() . $assetPath)) {

				$image = new ImageResize($url);

				$image->interlace = 1;

				$image->scale(ceil(100 + ((($height - $size[1]) / $size[1]) * 100)));

				$image->save(public_path() . $assetPath);
			}

			return URL::asset($assetPath);
		});
	}
}