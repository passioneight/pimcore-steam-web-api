<?php

namespace Passioneight\Bundle\PimcoreSiteConfigBundle;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\PathUtility;
use Pimcore\Extension\Bundle\Installer\AbstractInstaller;
use Pimcore\Extension\Bundle\Installer\Exception\InstallationException;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Service;

class Installer extends AbstractInstaller
{
    const CLASS_ID_PREFIX = "PASSIONEIGHT_";

    /**
     * @inheritDoc
     */
    public function install()
    {
        $this->installClasses();
    }

    /**
     * @inheritDoc
     */
    public function uninstall()
    {
        $this->uninstallClasses();
    }

    /**
     * @inheritDoc
     */
    public function isInstalled()
    {
        $classDefinitions = $this->getClassDefinitions();
        $classDefinitionNames = array_keys($classDefinitions);

        $missingClassDefinition = false;
        foreach ($classDefinitionNames as $classDefinitionName) {
            $classDefinition = ClassDefinition::getByName($classDefinitionName);

            if (!$classDefinition) {
                $missingClassDefinition = true;
                break;
            }
        }

        return !$missingClassDefinition;
    }

    /**
     * @inheritDoc
     */
    public function canBeInstalled()
    {
        return !$this->isInstalled();
    }

    /**
     * @inheritDoc
     */
    public function canBeUninstalled()
    {
        return $this->isInstalled();
    }

    /**
     * @inheritDoc
     */
    public function needsReloadAfterInstall()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    private function installClasses()
    {
        $classDefinitions = $this->getClassDefinitions();
        $classesToInstall = $this->getClassesToInstall();

        foreach ($classDefinitions as $classDefinitionName => $path) {
            $classDefinition = ClassDefinition::getByName($classDefinitionName);

            if ($classDefinition) {
                $this->outputWriter->write("<comment>WARNING:</comment> Skipping class '$classDefinitionName' as it already exists");
                continue;
            }

            $classDefinition = new ClassDefinition();

            $classDefinition->setName($classDefinitionName);
            $classDefinition->setId($classesToInstall[$classDefinitionName]);

            $data = file_get_contents($path);
            $success = Service::importClassDefinitionFromJson($classDefinition, $data, false, true);

            if (!$success) {
                throw new InstallationException("Failed to install class-definition '$classDefinitionName'");
            }
        }
    }

    /**
     * @inheritDoc
     */
    private function uninstallClasses()
    {
        $classDefinitions = $this->getClassDefinitions();

        foreach ($classDefinitions as $classDefinitionName => $path) {
            $classDefinition = ClassDefinition::getByName($classDefinitionName);

            if (!$classDefinition) {
                $this->outputWriter->write("<comment>WARNING:</comment> Skipping class '$classDefinitionName' as it does not exist");
                continue;
            }

            $classDefinition->delete();
        }
    }

    /**
     * @return string[]
     */
    protected function getClassDefinitions(): array
    {
        $classesToInstall = $this->getClassesToInstall();
        $classNames = array_keys($classesToInstall);

        $classDefinitions = [];
        foreach ($classNames as $className) {
            $filename = sprintf('class_%s_export.json', $className);

            $path = "{$this->getClassDefinitionsPath()}/$filename";
            $path = realpath($path);

            if (false === $path || !is_file($path)) {
                throw new InstallationException("Exported ClassDefinition '$className' was expected in '$path' but file does not exist");
            }

            $classDefinitions[$className] = $path;
        }

        return $classDefinitions;
    }

    /**
     * @return string
     */
    protected function getClassDefinitionsPath(): string
    {
        return PathUtility::join($this->getResourcesPath(), "/class-definitions");
    }

    /**
     * @return string
     */
    protected function getResourcesPath(): string
    {
        return PathUtility::join(__DIR__, "Resources", "install");
    }

    /**
     * @return string[]
     */
    protected function getClassesToInstall(): array
    {
        $classesToInstall = [];
        foreach ($classDefinitionNames as $classDefinitionName) {
            $classesToInstall[$classDefinitionName] = self::CLASS_ID_PREFIX . $classDefinitionName;
        }

        return $classesToInstall;
    }

    /**
     * @return array
     */
    public static function getClassDefinitionNames(): array
    {
        return [
            "SteamProfile",
            "SteamGame",
            "SteamAchievement",
            "SteamNews",
            "SteamBadge",
        ];
    }
}
