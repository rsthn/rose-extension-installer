<?php

namespace Rose\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

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

		$extra = $package->getExtra();
		if (!isset($extra['rose-ext-identifier']))
			throw new \InvalidArgumentException('Package extra field \'rose-ext-identifier\' was not found.');

		return 'vendor/rsthn/extensions/'.$extra['rose-ext-identifier'];
    }

    public function supports ($packageType)
    {
        return 'rose-extension' === $packageType;
	}
};
