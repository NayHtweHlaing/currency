<?php

/*
 * This file is part of the Hexcores\Currency package.
 *
 * @package Hexcores\Currency
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hexcores\Currency\Http;

/**
 * HTTP Client for API request.
 *
 * @package Hexcores\Currency
 * @author Nyan Lynn Htut <nyanlynnhtut@hexcores.com> 
 **/

class Client
{
	/**
	 * Request url
	 * @var string
	 */
	protected $url;

	/**
	 * Create new Client instance
	 * @param string|null $url
	 */
	public function __construct($url = null)
	{
		if (!extension_loaded('curl')) 
		{
            $message = 'The PHP cURL extension must be installed to use Hexcores Curency.';
            throw new \RuntimeException($message);
        }

        if ( ! is_null($url))
        {
        	$this->setUrl($url);
        }
	}

	/**
	 * Set request url to client
	 * @param string $url
	 * @return \Hexcores\Currency\Http\Client
	 */
	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * Get data from request url with curl
	 * @param  string|null $url
	 * @return json object
	 */
	public function get($url = null)
	{
		if ( ! is_null($url))
		{
			$this->setUrl($url);
		}

		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$json = curl_exec($ch);
		curl_close($ch);
		
		return json_decode($json);
	}

	/**
	 * Prepare the url before request
	 * @param  string $url
	 * @return void
	 * @throws \RuntimeException If request url is null.
	 */
	protected function prepare($url)
	{
		if ( ! is_null($url))
		{
			$this->setUrl($url);
		}

		if ( is_null($this->url))
		{
			$message = 'Need to set request URL for processing';
			throw new \RuntimeException($message);
		}
	}
}