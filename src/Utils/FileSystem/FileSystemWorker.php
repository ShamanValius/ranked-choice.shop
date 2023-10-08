<?php

namespace App\Utils\FileSystem;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileSystemWorker
{
	/**
	 * @var Filesystem
	 */
	private $filesystem;

	public function __construct(Filesystem $filesystem)
	{
		$this->filesystem = $filesystem;
	}

	/**
	 * @param string $folder
	 */
	public function createFolderIfItNotExist(string $folder)
	{
		try {
			if (!$this->filesystem->exists($folder)) {
				$this->filesystem->mkdir($folder);
			}
		} catch (FileException  $th) {
			//throw $th;
		}
	}

	/**
	 * @param string $item
	 */
	public function remove(string $item)
	{
		if ($this->filesystem->exists($item)) {
			$this->filesystem->remove($item);
		}
	}
}
