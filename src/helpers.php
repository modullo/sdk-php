<?php

use Hostville\Modullo\ModulloResponse;

/**
 * Checks if this library was installed via composer.
 *
 * @return bool
 */
function is_installed_via_composer(): bool
{
    $assumedVendorDir = dirname(__DIR__, 3);
    # try to see if we can find a vendor directory
    $isVendorDir = ends_with($assumedVendorDir, 'vendor');
    # check if it's actually a vendor directory
    $hasAutoloadFile = file_exists(implode(DIRECTORY_SEPARATOR, [$assumedVendorDir, 'autoload.php']));
    # check if there's an autoload.php file present inside the vendor directory
    return $isVendorDir && $hasAutoloadFile;
}

/**
 * Returns a path string relative to the library's root installation directory.
 *
 * @param string|null $path
 *
 * @return string
 */
function modullo_sdk_root_path(string $path = null): string
{
    $level = is_installed_via_composer() ? 4 : 1;
    # the level in the tree to reach the application root path
    $appDir = dirname(__DIR__, $level);
    return implode(DIRECTORY_SEPARATOR, [$appDir, (string) $path]);
}

/**
 * Returns a path string relative to the library's base directory.
 *
 * @param string|null $path
 *
 * @return string
 */
function modullo_sdk_app_path(string $path = null): string
{
    $appDir = dirname(__DIR__, 1);
    return implode(DIRECTORY_SEPARATOR, [$appDir, (string) $path]);
}

/**
 * Returns the HTTP Client to use for making the requests.
 *
 * @param \GuzzleHttp\Psr7\Uri|null $uri
 *
 * @return \GuzzleHttp\Client
 */
function http_client(\GuzzleHttp\Psr7\Uri $uri = null): \GuzzleHttp\Client
{
    $verify = null !== env('MODULLO_CURL_SSL_VERIFY') ? env('MODULLO_CURL_SSL_VERIFY') : true;
    $options = [
        \GuzzleHttp\RequestOptions::ALLOW_REDIRECTS => true,
        \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT => 30.0,
        \GuzzleHttp\RequestOptions::TIMEOUT => 30.0,
        \GuzzleHttp\RequestOptions::HEADERS => [
            'User-Agent' => 'modullo-sdk-php/'.Hostville\Modullo\Sdk::VERSION
        ],
        \GuzzleHttp\RequestOptions::VERIFY => $verify
    ];
    if (!empty($uri)) { //$baseUrl before
        $options['base_uri'] = $uri->getScheme() . '://' . $uri->getAuthority();
        $options['base_uri'] .= !empty($uri->getPath()) ? '/'.$uri->getPath() : '';

    }
    # the client options
    return new \GuzzleHttp\Client($options);
}

/**
 * Loads the manifest.json file into an array.
 *
 * @return array
 */
function load_manifest(): array
{
    $contents = file_get_contents(modullo_sdk_app_path('manifest.json'));
    # read the manifest.json file in
    return json_decode($contents, true) ?? [];
}

/**
 * A small utility function to wrap the PHP parse_str function.
 *
 * @param string $queryString
 *
 * @return array
 */
function parse_query_parameters(string $queryString): array
{
    $params = [];
    parse_str($queryString, $params);
    return $params;
}

/**
 * Performs a login for using the provided details; if successful, it returns the "access_token"
 * (or ModulloResponse - depending on the value of the $returnToken parameter), else it will
 * return the actual response object.
 *
 * @param \Hostville\Modullo\Sdk $sdk
 * @param array                 $credentials
 * @param bool                  $returnToken
 *
 * @return ModulloResponse
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function authorize_via_email_only(Hostville\Modullo\Sdk $sdk, array $credentials, bool $returnToken = true)
{
    $service = $sdk->createAuthorizationService();
    foreach ($credentials as $key => $value) {
        $service = $service->addBodyParam($key, $value);
    }
    $response = $service->send('post', ['email']);
    # sends a HTTP POST request with the parameters
    return $response->isSuccessful() && $returnToken ? $response->getData()['access_token'] : $response;
}

/**
 * Performs a login for using the provided details; if successful, it returns the "access_token"
 * (or ModulloResponse - depending on the value of the $returnToken parameter), else it will
 * return the actual response object.
 *
 * NOTE: The client_id, and client_secret must correspond to a Password Grant Client issued to you.
 *
 *
 * @param Hostville\Modullo\Sdk $sdk
 * @param string               $username
 * @param string               $password
 * @param bool                 $returnToken
 *
 * @return Hostville\Modullo\ModulloResponse|string
 * @throws Hostville\Modullo\Exception\ModulloException
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function login_via_password(Hostville\Modullo\Sdk $sdk, string $username, string $password, bool $returnToken = true)
{
    $service = $sdk->createPasswordLoginService();
    $response = $service->addBodyParam('username', $username)
                        ->addBodyParam('password', $password)
                        ->send('post');
    # sends a HTTP POST request with the parameters
    return $response->isSuccessful() && $returnToken ? $response->getData()['access_token'] : $response;
}

/**
 * Creates a new Modullo account with the provided details in the config array.
 *
 * @param \Hostville\Modullo\Sdk $sdk
 * @param array                 $config array containing the following keys:
 *                                      - email: the account email address
 *                                      - password: the desired plaintext account password
 *                                      - firstname: account holder's firstname
 *                                      - lastname: account holder's lastname
 *                                      - phone: account holder's contact phone number
 *                                      - company: account holder's company name
 *
 * @return ModulloResponse
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function create_account(\Hostville\Modullo\Sdk $sdk, array $config): ModulloResponse
{
    $service = $sdk->createRegistrationService();
    foreach ($config as $key => $value) {
        $service = $service->addBodyParam($key, $value);
    }
    return $service->send('post');
}

/**
 * Returns the validation errors from the response, if any.
 *
 * @param ModulloResponse $response
 *
 * @return array
 */
function get_validation_errors_from_response(ModulloResponse $response): array
{
    if (empty($response->getErrors())) {
        return [];
    }
    $errors = collect($response->getErrors());
    # get the errors as a collection
    $validationErrors = $errors->where('code', 'validation_failed')->first();
    # get the validation errors entry
    if (empty($validationErrors)) {
        return [];
    }
    $messages = [];
    foreach ($validationErrors['source'] as $field => $failure) {
        $messages[$field] = [$failure];
    }
    return $messages;
}
