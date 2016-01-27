<?php
/**
 *
 * @package       Upload Extensions
 * @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace boardtools\upload\includes\sources;

/**
 * Modified from the original ComposerRepository class.
 * https://github.com/composer/composer/blob/master/src/Composer/Repository/ComposerRepository.php
 */
class extensions_list
{
	protected static $url = "https://www.phpbb.com/customise/db/composer/packages-extension.json";
	protected static $baseUrl = "https://www.phpbb.com/customise/db/composer";
	protected static $packages = array();
	protected static $hasProviders = false;
	protected static $providersUrl;
	protected static $lazyProvidersUrl;
	protected static $providerListing;
	protected static $allowSslDowngrade = false;
	private static $rootData;

	public static function getPackages()
	{
		self::initialize();
		self::sortPackages();
		return self::$packages;
	}

	public static function sortPackages()
	{
		usort(self::$packages, function ($a, $b)
		{
			return strcmp(strtolower($a[current(array_keys($a))]['display_name']), strtolower($b[current(array_keys($b))]['display_name']));
		});
	}

	public static function hasProviders()
	{
		self::loadRootServerFile();

		return self::$hasProviders;
	}

	protected static function initialize()
	{
		$repoData = self::loadDataFromServer();

		foreach ($repoData as $package)
		{
			self::addPackage($package);
		}
	}

	/**
	 * Adds a new package to the repository
	 *
	 * @param array $package
	 */
	public static function addPackage(array $package)
	{
		if (null === self::$packages)
		{
			self::initialize();
		}

		$name = $package['name'];
		$version = $package['version'];

		if (!isset(self::$packages[$name]))
		{
			self::$packages[$name] = array();
		}

		if (!isset(self::$packages[$name][$version]))
		{
			self::$packages[$name][$version] = array();
		}

		$package['display_name'] = (isset($package['extra']) && isset($package['extra']['display-name'])) ? $package['extra']['display-name'] : $package['name'];

		self::$packages[$name][$version] = $package;
	}

	protected static function loadRootServerFile()
	{
		if (null !== self::$rootData)
		{
			return self::$rootData;
		}

		$jsonUrl = self::$url;

		$data = self::fetchFile($jsonUrl, 'packages.json');

		// Try loading from cache.
		if (empty($data))
		{
			$data = json_decode(cache::read('packages.json'), true);
		}

		if (!empty($data['providers-lazy-url']))
		{
			self::$lazyProvidersUrl = self::canonicalizeUrl($data['providers-lazy-url']);
			self::$hasProviders = true;
		}

		if (self::$allowSslDowngrade)
		{
			self::$url = str_replace('https://', 'http://', self::$url);
			self::$baseUrl = str_replace('https://', 'http://', self::$baseUrl);
		}

		if (!empty($data['providers-url']))
		{
			self::$providersUrl = self::canonicalizeUrl($data['providers-url']);
			self::$hasProviders = true;
		}

		if (!empty($data['providers']) || !empty($data['providers-includes']))
		{
			self::$hasProviders = true;
		}

		return self::$rootData = $data;
	}

	protected static function canonicalizeUrl($url)
	{
		if ('/' === $url[0])
		{
			return preg_replace('{(https?://[^/]+).*}i', '$1' . $url, self::$url);
		}

		return $url;
	}

	protected static function loadDataFromServer()
	{
		$data = self::loadRootServerFile();

		return self::loadIncludes($data);
	}

	protected static function loadIncludes($data)
	{
		$packages = array();

		// legacy repo handling
		if (!isset($data['packages']) && !isset($data['includes']))
		{
			foreach ($data as $pkg)
			{
				foreach ($pkg['versions'] as $metadata)
				{
					$packages[] = $metadata;
				}
			}

			return $packages;
		}

		if (isset($data['packages']))
		{
			foreach ($data['packages'] as $package => $versions)
			{
				foreach ($versions as $version => $metadata)
				{
					$packages[] = $metadata;
				}
			}
		}

		if (isset($data['includes']))
		{
			foreach ($data['includes'] as $include => $metadata)
			{
				if (cache::sha1($include) === $metadata['sha1'])
				{
					$includedData = json_decode(cache::read($include), true);
				}
				else
				{
					$includedData = self::fetchFile($include);
				}
				$packages = array_merge($packages, self::loadIncludes($includedData));
			}
		}

		return $packages;
	}

	protected static function fetchFile($filename, $cacheKey = null, $sha256 = null)
	{
		$file = $filename;
		if (null === $cacheKey)
		{
			$cacheKey = $filename;
			$file = self::$baseUrl . '/' . $filename;
		}

		// url-encode $ signs in URLs as bad proxies choke on them
		if (($pos = strpos($file, '$')) && preg_match('{^https?://.*}i', $file))
		{
			$file = substr($file, 0, $pos) . '%24' . substr($file, $pos + 1);
		}

		$json = @file_get_contents($file);
		if ($sha256 && $sha256 !== hash('sha256', $json))
		{
			return false;
		}
		$data = json_decode($json, true);
		if ($cacheKey && !empty($json))
		{
			cache::write($cacheKey, $json);
		}

		return $data;
	}
}
