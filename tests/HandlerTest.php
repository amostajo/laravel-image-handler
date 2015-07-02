<?php

use Log;
use Config;
use ImageHandler;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HandlerTest extends TestCase
{

	/**
	 * Image url to use.
	 */
  	protected $imageUrl;

	/**
	 * Setups test data.
	 */
	public function setUp()
	{
		parent::setUp();

		$this->imageUrl = 'http://static.guim.co.uk/sys-images/Guardian/Pix/pictures/2014/4/11/1397210130748/Spring-Lamb.-Image-shot-2-011.jpg';

		Cache::flush();
	}

	/**
	 * Tests thumb creation and default config.
	 */
	public function testDefaultThumb()
	{
		$url = ImageHandler::thumb($this->imageUrl);

		$url = preg_replace(config('testing.domain'), config('testing.sitedomain'), $url);

		$size = getimagesize($url);

		$this->assertEquals($size[0], config('image.thumbs_width'));

		$this->assertEquals($size[1], config('image.thumbs_height'));
	}

	/**
	 * Tests custom thumb creation.
	 */
	public function testCustomThumb()
	{
		$url = ImageHandler::thumb($this->imageUrl, 280, 150);

		$url = preg_replace(config('testing.domain'), config('testing.sitedomain'), $url);

		$size = getimagesize($url);

		$this->assertEquals($size[0], 280);

		$this->assertEquals($size[1], 150);
	}

	/**
	 * Tests thumb resizing to width.
	 */
	public function testDefaultWidth()
	{
		$url = ImageHandler::width($this->imageUrl);

		$url = preg_replace(config('testing.domain'), config('testing.sitedomain'), $url);

		$size = getimagesize($url);

		$this->assertGreaterThanOrEqual(100, $size[0]);
	}

	/**
	 * Tests thumb resizing to height.
	 */
	public function testDefaultHeight()
	{
		$url = ImageHandler::height($this->imageUrl);

		$url = preg_replace(config('testing.domain'), config('testing.sitedomain'), $url);

		$size = getimagesize($url);

		$this->assertGreaterThanOrEqual(100, $size[1]);
	}

	/**
	 * Tests custom thumb resizing to width.
	 */
	public function testCustomWidth()
	{
		$url = ImageHandler::width($this->imageUrl, 660);

		$url = preg_replace(config('testing.domain'), config('testing.sitedomain'), $url);

		$size = getimagesize($url);

		$this->assertGreaterThanOrEqual(660, $size[0]);
	}

	/**
	 * Tests custom thumb resizing to height.
	 */
	public function testCustomHeight()
	{
		$url = ImageHandler::height($this->imageUrl, 360);

		$url = preg_replace(config('testing.domain'), config('testing.sitedomain'), $url);

		$size = getimagesize($url);

		$this->assertGreaterThanOrEqual(360, $size[1]);
	}
}