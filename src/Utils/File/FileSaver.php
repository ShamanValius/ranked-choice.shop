<?php

namespace App\Utils\File;

use App\Utils\FileSystem\FileSystemWorker;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileSaver
{
	/**
	 * @var SluggerInterface
	 */
	private $sluggerInterface;

	/**
	 * @var FileSystemWorker
	 */
	private $fileSystemWorker;

	/**
	 * @var string
	 */
	private $uploadsTempDir;

	public function __construct(SluggerInterface $sluggerInterface, FileSystemWorker $fileSystemWorker, string $uploadsTempDir)
	{
		$this->sluggerInterface = $sluggerInterface;
		$this->uploadsTempDir = $uploadsTempDir;
		$this->fileSystemWorker = $fileSystemWorker;
	}

	public function saveUploadFileInfoTemp(UploadedFile $uploadedFile)
	{
		$originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

		// this is needed to safely include the file name as part of the URL
		// https://symfony.com/doc/current/controller/upload_file.html
		$saveFilename = $this->sluggerInterface->slug($originalFilename);
		$newFilename  = sprintf('%s-%s.%s', $saveFilename, uniqid(), $uploadedFile->guessExtension());

		$this->fileSystemWorker->createFolderIfItNotExist($this->uploadsTempDir);
		try {
			$uploadedFile->move($this->uploadsTempDir, $newFilename);
		} catch (FileException $th) {
			return null;
		}

		return $newFilename;
	}
}
