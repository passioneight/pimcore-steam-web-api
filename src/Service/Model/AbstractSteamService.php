<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\MethodUtility;
use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\NamespaceUtility;
use Passioneight\Bundle\PimcoreSiteConfigBundle\Installer;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\SteamProfile;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractSteamService
{
    /**
     * @param mixed$object
     * @param array $values
     * @return mixed
     */
    protected function populate(Concrete $object, array $values): Concrete
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
     * @param Concrete $object
     * @param array $values
     * @return Concrete
     */
    protected function clear(Concrete $object, array $values): Concrete
    {
        foreach ($values as $key => $value) {
            $setter = MethodUtility::createSetter($value);

            if(method_exists($object, $setter)) {
                $object->{$setter}(null);
            }
        }

        return $object;
    }

    /**
     * @return array
     */
    public function getFieldDefinitionNames(): array
    {
        $classDefinition = ClassDefinition::getById(Installer::CLASS_ID_PREFIX . NamespaceUtility::getClassNameFromNamespace($this->getRelatedObjectClass()));

        $fieldDefinitionNames = [];
        if($classDefinition) {
            $fieldDefinitions = $classDefinition->getFieldDefinitions();

            $fieldDefinitionNames = array_map(function(ClassDefinition\Data $fieldDefinition){
                return $fieldDefinition->getName();
            }, $fieldDefinitions);
        }
        
        return $fieldDefinitionNames;
    }

    /**
     * @return string
     */
    abstract protected function getRelatedObjectClass(): string;

    /**
     * @param $path
     * @return AbstractObject
     */
    protected function getOrCreateParent(string $path): AbstractObject
    {
        return DataObject\Service::createFolderByPath($path);
    }

    /**
     * @param array $player
     * @return string|null
     */
    protected function getSteamId(array $player): ?string
    {
        return $this->get($player,'steamid');
    }

    /**
     * Steam seems to send MOST of their responses containing a "response" value.
     * 
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