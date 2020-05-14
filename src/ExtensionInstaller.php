<?php

namespace Rose\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class ExtensionInstaller extends LibraryInstaller
{
	private function getExtensionName ($packageName)
	{
        $result = null;
        preg_match ('/rose-ext-([A-Za-z0-9_-]+)/', $packageName, $result, 0);
        return sizeof($result) == 0 ? null : $result[1];
	}

    public function getInstallPath (PackageInterface $package)
    {
        $repositoryManager = $this->composer->getRepositoryManager();
        if (!$repositoryManager)
            throw new \InvalidArgumentException('Unable to get repository manager.');

        $repos = $repositoryManager->getLocalRepository();
		if (!$repos)
			throw new \InvalidArgumentException('Unable to get local repository.');

		$host = $repos->findPackage('rsthn/rose-core', '*');
		if (!$host)
			throw new \InvalidArgumentException('Host package "rsthn/rose-core" was not found.');

        return $this->composer->getConfig()->get('vendor-dir').'/rsthn/rose-core/src/Ext/'.$this->getExtensionName($package->getPrettyName());
    }

    public function supports ($packageType)
    {
        return 'rose-extension' === $packageType;
    }
};
