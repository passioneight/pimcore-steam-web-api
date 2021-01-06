<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\MethodUtility;
use Pimcore\Model\DataObject\Concrete;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractSteamService
{
    /**
     * @param mixed$object
     * @param array $values
     * @return mixed
     */
    protected function populate(Concrete $object, array $values)
    {
        foreach ($values as $key => $value) {
            $setter = MethodUtility::createSetter($key);

            if(method_exists($object, $setter)) {
                $object->{$setter}($value);
            }
        }
        
        return $object;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function getContent(ResponseInterface $response): array
    {
        return $this->get($response->toArray(), 'response');
    }

    /**
     * @param array $data
     * @param string $key
     * @param array $defaultValue
     * @return mixed
     */
    protected function get(array $data, string $key, $defaultValue = [])
    {
        return array_key_exists($key, $data) ? $data[$key] : $defaultValue;
    }
}