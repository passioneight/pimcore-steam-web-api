<?php

namespace Passioneight\PimcoreSteamWebApi\Service\Api;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\UrlUtility;
use Passioneight\PimcoreSteamWebApi\Service\Configuration\SteamWebApiConfiguration;
use Symfony\Contracts\Service\Attribute\Required;

abstract class SteamWebApi extends WebApi
{
    const VERSION_1 = "v1";
    const VERSION_2 = "v2";

    protected SteamWebApiConfiguration $bundleConfiguration;
    protected string $version;
    protected string $defaultVersion;

    /**
     * SteamWebApiService constructor.
     * @param string $version
     */
    public function __construct(string $version = self::VERSION_1)
    {
        $this->defaultVersion = $version;
        $this->version = $this->defaultVersion;
    }

    /**
     * @param string $namespace
     * @param string $endpoint
     * @return string
     */
    protected function createUrl(string $namespace, string $endpoint): string
    {
        return UrlUtility::join($this->bundleConfiguration->getBaseUrl(), $namespace, $endpoint, $this->version);
    }

    /**
     * Make the API use a specific version.
     * Attention: you need to call self#resetVersion to reset the version
     *
     * @param string $version
     * @return self
     */
    public function useVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return $this
     */
    public function resetVersion(): self
    {
        $this->version = $this->getDefaultVersion();
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultVersion(): string
    {
        return $this->defaultVersion;
    }

    /**
     * @param array $options
     * @return array
     */
    protected function addApiKey(array $options): array
    {
        $options = array_key_exists('query', $options) ? $options : ['query' => []];
        $options['query'] = array_merge($options['query'], [
            'key' => $this->bundleConfiguration->getApiKey()
        ]);
        return $options;
    }

    /**
     * @internal
     */
    #[Required]
    public function setBundleConfiguration(SteamWebApiConfiguration $bundleConfiguration): void
    {
        $this->bundleConfiguration = $bundleConfiguration;
    }
}
