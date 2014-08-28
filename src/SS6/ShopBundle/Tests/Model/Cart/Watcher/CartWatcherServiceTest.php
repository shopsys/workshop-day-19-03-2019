<?php

namespace SS6\ShopBundle\Tests\Model\Cart\Watcher;

use SS6\ShopBundle\Component\Test\FunctionalTestCase;
use SS6\ShopBundle\Model\Cart\Cart;
use SS6\ShopBundle\Model\Cart\CartItem;
use SS6\ShopBundle\Model\Customer\CustomerIdentifier;
use SS6\ShopBundle\Model\Pricing\Vat\Vat;
use SS6\ShopBundle\Model\Pricing\Vat\VatData;
use SS6\ShopBundle\Model\Product\Product;
use SS6\ShopBundle\Model\Product\ProductData;

class CartWatcherServiceTest extends FunctionalTestCase {

	
	public function testShowErrorOnModifiedItems() {
		$customerIdentifier = new CustomerIdentifier('randomString');

		$vat = new Vat(new VatData('vat', 21));
		$product = new Product(new ProductData('Product 1', null, null, null, null, 100, $vat));

		$cartItem = new CartItem($customerIdentifier, $product, 1);
		$cartItems = array($cartItem);
		$cart = new Cart($cartItems);

		$flashMessageFront = $this->getContainer()->get('ss6.shop.flash_message.bag.front');
		/* @var $flashMessageFront \SS6\ShopBundle\Model\FlashMessage\Bag */
		
		// clear...
		$flashMessageFront->getErrorMessages();
		$flashMessageFront->getInfoMessages();
		$flashMessageFront->getSuccessMessages();

		$cartWatcherService = $this->getContainer()->get('ss6.shop.cart.cart_watcher_service');
		/* @var $cartWatcherService \SS6\ShopBundle\Model\Cart\Watcher\CartWatcherService */
		
		$cartWatcherService->showErrorOnModifiedItems($cart);
		$this->assertTrue($flashMessageFront->isEmpty());

		$product->edit(new ProductData('Product 1', null, null, null, null, 200, $vat, null, null, null, null));
		$cartWatcherService->showErrorOnModifiedItems($cart);
		$this->assertFalse($flashMessageFront->isEmpty());
	}

}
