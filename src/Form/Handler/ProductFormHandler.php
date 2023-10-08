<?php

namespace App\Form\Handler;

use App\Entity\Product;
use App\Form\DTO\EditProductModel;
use App\Utils\File\FileSaver;
use App\Utils\Manager\ProductManager;
use App\Utils\Manager\ProductImageManager;
use Symfony\Component\Form\Form;

class ProductFormHandler
{
	/**
	 * @var ProductManager
	 */
	private $productManager;

	/**
	 * @var ProductImageManager
	 */
	private $productImageManager;

	/**
	 * @var FileSaver
	 */
	private $fileSaver;

	public function __construct(ProductManager $productManager, ProductImageManager $productImageManager, FileSaver $fileSaver)
	{
		$this->productManager = $productManager;
		$this->productImageManager = $productImageManager;
		$this->fileSaver = $fileSaver;
	}

	public function getProduct(?int $idProduct)
	{
		if ($idProduct) {
			$product = $this->productManager->getRepository()->find($idProduct);
		} else {
			$product = new Product();
		}

		return $product;
	}

	public function getProductImage(?int $idProductImage)
	{
		if ($idProductImage) {
			$productImage = $this->productImageManager->getRepository()->find($idProductImage);
		} else {
			$productImage = null;
		}

		return $productImage;
	}

	public function processEditForm(EditProductModel $editProductModel, Form $form)
	{
		$product = new Product();

		if ($editProductModel->id) {
			$product = $this->productManager->find($editProductModel->id);
		}

		$product->setTitle($editProductModel->title);
		$product->setPrice($editProductModel->price);
		$product->setQuantity($editProductModel->quantity);
		$product->setDescription($editProductModel->description);
		$product->setIsPublished($editProductModel->isPublished);
		$product->setIsDeleted($editProductModel->isDeleted);

		$this->productManager->save($product);

		$imageFileForm = $form->get('newImage')->getData();
		$newImageFile = $imageFileForm
			? $this->fileSaver->saveUploadFileInfoTemp($imageFileForm)
			: null;


		$this->productManager->updateProductImage($product, $newImageFile);
		$this->productManager->save($product);

		return $product;
	}
}
