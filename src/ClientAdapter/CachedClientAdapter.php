<?php declare(strict_types = 1);

namespace Suilven\DarkSky\ClientAdapters;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;
use VertigoLabs\Overcast\ClientAdapterInterface;
use VertigoLabs\Overcast\ClientAdapters\ClientAdapter;

/**
 * Class CachedClientAdapter
 *
 * @package Suilven\DarkSky\ClientAdapters
 *
 * These are disabled due to them breaking method signatures with relevant parent classes
 *
 * @phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
 * @phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
 * @phpcs:disable SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
 */
class CachedClientAdapter extends ClientAdapter implements ClientAdapterInterface
{
    /** @var \GuzzleHttp\Client */
    private $guzzleClient;

    /** @var string|null */
    private $requestedUrl = null;

    /** @var array<string,mixed> */
    private $responseHeaders = [];

    /**
     * CachedClientAdapter constructor.
     */
    public function __construct(?Client $guzzleClient = null)
    {
        if ($guzzleClient === null) {
            $guzzleClient = new Client();
        }
        $this->guzzleClient = $guzzleClient;
    }


    /**
     * Returns the response data from the Dark Sky API in the
     * form of an array.
     *
     * @param float $latitude
     * @param float $longitude
     * @param \DateTime $time
     * @param array<string,string> $parameters
     * @return array<string,string>
     */
    public function getForecastWithCaching($latitude, $longitude, $time = null, ?array $parameters = null): array
    {
        // build the URL for Dark Sky
        $this->requestedUrl = $this->buildRequestURL($latitude, $longitude, $time, $parameters);

        $cache = $this->getCache();
        $cachekey = \hash('ripemd160', $this->requestedUrl . '0001');

        $body = '';

        $cachedResponse = $cache->get($cachekey);
        if (\is_null($cachedResponse)) {
            $response = $this->getRequestedURL();

            $cacheDirectives = $this->buildCacheDirectives($response);

            $this->responseHeaders = [
                'cache' => $cacheDirectives,
                'responseTime' => \intval($response->getHeader('x-response-time')),
                'apiCalls' => \intval($response->getHeader('x-forecast-api-calls')),
            ];

            /** @var string $responseBody PHPStan fails here without defining the response body as a string */
            $responseBody = $response->getBody();
            $body = \json_decode($responseBody, true);

            $entry = [
                'body' => $body,
                'headers' => $this->responseHeaders,
            ];

            // @todo make configurable
            $cache->set($cachekey, $entry, 3600);
        } else {
            $body = $cachedResponse['body'];
            $this->responseHeaders = $cachedResponse['headers'];
        };

        return $body;
    }


    /**
     * Returns the response data from the Dark Sky in the
     * form of an array
     *
     * @param float $latitude
     * @param float $longitude
     * @phpstan-ignore-next-line
     * @param array|null $parameters
     * @return array<string,string>
     */
    public function getForecast($latitude, $longitude, ?\DateTime $time = null, ?array $parameters = null): array
    {
        return $this->getForecastWithCaching($latitude, $longitude, $time, $parameters);
    }


    /**
     * Returns the relevant response headers from the Dark Sky API.
     *
     * @return array<string,string>
     */
    public function getHeaders(): array
    {
        return $this->responseHeaders;
    }


    /**
     * Builds the cache directives from response headers by filtering them
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array<string,string>
     */
    protected function buildCacheDirectives($response): array
    {
        $cacheControlHeader = null;
        if ($response->hasHeader('cache-control')) {
            $cacheControlHeader = $this->parseHeader($response->getHeader('cache-control'));
            $cacheControlHeader = \current($cacheControlHeader);
            $cacheControlHeader = (isset($cacheControlHeader['max-age'])?$cacheControlHeader['max-age']:null);
        }

        $expiresHeader = null;
        if ($response->hasHeader('expires')) {
            $expiresHeader = \implode(' ', \array_column($this->parseHeader($response->getHeader('expires')), 0));
        }

        return \array_filter([
            'maxAge'=>$cacheControlHeader,
            'expires'=>$expiresHeader,
        ]);
    }


    /**
     * This is taken from the GuzzleHTTP/PSR7 library,
     * see https://github.com/guzzle/psr7 for more info
     *
     * Parse an array of header values containing ";" separated data into an
     * array of associative arrays representing the header key value pair
     * data of the header. When a parameter does not contain a value, but just
     * contains a key, this function will inject a key with a '' string value.
     *
     * @param string|array<string,string> $header Header to parse into components.
     * @return array<int,array<int|string, string>> Returns the parsed header values.
     */
    protected function parseHeader($header): array
    {
        static $trimmed = "\"'  \n\t\r";
        $params = $matches = [];

        foreach ($this->normalizeHeader($header) as $val) {
            $part = [];
            foreach (\preg_split('/;(?=([^"]*"[^"]*")*[^"]*$)/', $val) as $kvp) {
                if (!\preg_match_all('/<[^>]+>|[^=]+/', $kvp, $matches)) {
                    continue;
                }

                $m = $matches[0];
                if (isset($m[1])) {
                    $part[\trim($m[0], $trimmed)] = \trim($m[1], $trimmed);
                } else {
                    $part[] = \trim($m[0], $trimmed);
                }
            }
            if ($part === []) {
                continue;
            }

            $params[] = $part;
        }

        return $params;
    }


    /**
     * This is taken from the GuzzleHTTP/PSR7 library,
     * see https://github.com/guzzle/psr7 for more info
     *
     * Converts an array of header values that may contain comma separated
     * headers into an array of headers with no comma separated values.
     *
     * @param string|array<string,string> $header Header to normalize.
     * @return array<string> Returns the normalized header field values.
     */
    protected function normalizeHeader($header): array
    {
        if (!\is_array($header)) {
            return \array_map('trim', \explode(',', $header));
        }

        $result = [];
        foreach ($header as $value) {
            foreach ((array) $value as $v) {
                if (\strpos($v, ',') === false) {
                    $result[] = $v;

                    continue;
                }
                foreach (\preg_split('/,(?=([^"]*"[^"]*")*[^"]*$)/', $v) as $vv) {
                    $result[] = \trim($vv);
                }
            }
        }

        return $result;
    }


    /**
     * Centralised method to get the cache for open weather map data
     *
     * @return \Psr\SimpleCache\CacheInterface SilverStripe cache object
     */
    private function getCache(): CacheInterface
    {
        return \SilverStripe\Core\Injector\Injector::inst()->get(\Psr\SimpleCache\CacheInterface::class . '.darksky');
    }


    /**
     * Obtain a JSON object utilising the API if needbe, but taking into account hit rates against
     * the API - documentation says not to repeat URLS more than every 10 mins
     */
    private function getRequestedURL(): ResponseInterface
    {
        return $this->guzzleClient->get($this->requestedUrl);
    }
}
