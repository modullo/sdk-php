<?php

namespace Hostville\Modullo\Services;


use GuzzleHttp\Exception\GuzzleException;
use Hostville\Modullo\Exception\ModulloException;
use Hostville\Modullo\ModulloResponse;
use Hostville\Modullo\RequestInterface;
use Hostville\Modullo\Sdk;
use Hostville\Modullo\SendsHttpRequestTrait;
use GuzzleHttp\Psr7\Uri;

abstract class AbstractService implements ServiceInterface
{
    use SendsHttpRequestTrait {
        SendsHttpRequestTrait::send as httpSend;
    }

    /** @var Sdk  */
    protected Sdk $sdk;

    /** @var array */
    protected array $query;

    /**
     * AbstractService constructor.
     *
     * @param Sdk $sdk
     */
    public function __construct(Sdk $sdk)
    {
        $this->sdk = $sdk;
        $this->query = [];
    }

    /**
     * @inheritdoc
     */
    public function requiresAuthorization(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getAuthorizationHeader(): string
    {
        return 'Bearer ' . $this->sdk->getAuthorizationToken();
    }

    /**
     * @inheritdoc
     */
    public function getRequestUrl(array $extras = []): Uri
    {
        $path = $this->sdk->getManifest()->getService(static::getName(), 'path');
        # get the path for the service
        if (!empty($this->id)) {
            # requesting data off a service item
            $path .= '/' . $this->id;
        }
        # compose the full request URL
        return $this->sdk->getUrlRegistry()->getUrl($path, ['path' => $extras, 'query' => $this->getQuery()]);
    }

    /**
     * @inheritdoc
     */
    public function addQueryArgument(string $name, $value, bool $overwrite = false): RequestInterface
    {
        if (array_key_exists($name, $this->query) && !$overwrite) {
            return $this;
        }
        if (is_null($value)) {
            unset($this->query[$name]);
            return $this;
        }
        $this->query[$name] = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setQuery(array $params = []): RequestInterface
    {
        $this->query = $params;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @inheritdoc
     */
    public function validate(): bool
    {
        $parameters = $this->sdk->getManifest()->getService(static::getName(), 'parameters');
        $headers = $this->sdk->getManifest()->getService(static::getName(), 'headers');
        # get the parameters and headers
        $required = $parameters['required'] ?? [];
        if (empty($required) && empty($headers)) {
            return true;
        }
        $missing = ['body' => [], 'headers' => []];
        # missing container
        if (!empty($headers)) {
            foreach ($headers as $header) {
                if (array_key_exists($header, $this->headers)) {
                    continue;
                }
                $missing['headers'][] = $header;
            }
        }
        if (!empty($required)) {
            foreach ($required as $parameter) {
                if (array_key_exists($parameter, $this->body)) {
                    continue;
                }
                $missing['body'][] = $parameter;
            }
        }
        if (!empty($missing['header']) || !empty($missing['body'])) {
            throw new ModulloException('Some required parameters are missing in the request.', $missing);
        }
        return true;
    }

    /**
     * @param string $method
     * @param array  $path
     *
     * @return ModulloResponse
     * @throws GuzzleException
     */
    public function send(string $method, array $path = []): ModulloResponse
    {
        return $this->httpSend($method, $this->sdk->getHttpClient(), $path);
    }

    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    abstract function getName(): string;
}