<?php

namespace Hostville\Modullo;


use GuzzleHttp\Psr7\Uri;

class UrlRegistry
{

    /**
     * @var string
     */
    private $environment;

    /**
     * @var Uri
     */
    protected $uri;

    /**
     * UrlRegistry constructor.
     *
     * @param string $env
     */
    public function __construct(string $env = 'staging')
    {
        $enviroments = include("config/environments.php");
        $envs = array_keys($enviroments);
        # get the available environment
        $this->environment = !in_array(strtolower($env), $envs, true) ? 'staging' : strtolower($env);
        $base = $enviroments[$this->environment];
        dd($base);
        $this->uri = new Uri($base);
    }

    /**
     * Is it in production mode?
     *
     * @return bool
     */
    public function isProduction(): bool
    {
        return $this->environment === 'production';
    }

    /**
     * Checks the $params array for additional data to be added to the path.
     *
     * @param array $params must contain the key 'path', with value of type string | string[]
     *
     * @return string
     */
    protected function getPathParams(array $params = []): string
    {
        if (empty($params)) {
            return '';
        }
        $path = $params['path'] ?? [];
        if (is_string($path)) {
            return $path;
        }
        $path = collect($path)->map(function ($entry) {
            return (string) $entry;
        })->all();
        return implode('/', $path);
    }

    /**
     * Checks the $params array for additional data to be used in composing the query part of the URL.
     *
     * @param array $params must contain the key 'query', with value of type string | string[]
     *
     * @return string
     */
    protected function getQueryParams(array $params = []): string
    {
        if (empty($params)) {
            return '';
        }
        $query = $params['query'] ?? [];
        if (is_string($query)) {
            return $query;
        }
        return empty($query) ? '' : http_build_query($query);
    }

  /**
   * Performs the path, and query parameter processing before returning the final path.
   *
   * @param string|null $path the base path
   * @param array $params contains additional data to be used in composing the path and/or query of the URL
   *
   * @return Uri
   */
    public function getUrl(string $path = null, array $params = []): Uri
    {
       $pathParams = $this->getPathParams($params);



        # get the path parameters
       $queryParams = $this->getQueryParams($params);
        # get the query parameters

       $path .= !empty($pathParams) ? '/' . $pathParams : '';

       $path = $this->getVersion().'/'. $path;

        # append the rest of the path
        if (!empty($path) && $path[0] !== '/') {
            $path = '/' . $path;
        }
        return $this->uri->withPath($path)->withQuery($queryParams);
    }


      public function getVersion(): string
      {
        $deploy = null !== env('MODULLO_DEPLOY_MODE') ? env('MODULLO_DEPLOY_MODE') : 'default';
        $stage = null !== env('MODULLO_APIGATEWAY_STAGE') ? env('MODULLO_APIGATEWAY_STAGE') : 'staging';
        if ($deploy == "lambda") {
            return $stage . '/v1';
        } else {
            return 'v1';
        }
      }
} 