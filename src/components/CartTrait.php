<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\components;


use yz\shoppingcart\ShoppingCart;

/**
 * Trait CartTrait
 * @package app\components
 *
 * @property ShoppingCart $cart
 */
trait CartTrait
{
    /**
     * @var ShoppingCart
     */
    protected $_cart;

    /**
     * @return ShoppingCart
     */
    public function getCart()
    {
        if (!isset($this->_cart)) {
            $this->_cart = new ShoppingCart();
        }
        return $this->_cart;
    }
} 