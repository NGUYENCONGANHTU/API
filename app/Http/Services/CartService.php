<?php

namespace App\Http\Services;

use App\Repositories\CartRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\AttributesRepositories;
use App\Services\BaseService;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartService extends BaseService
{
    /**
     * @var Repository
     */

    protected $cartRepositories;
    protected $productRepositories;
    protected $attributesRepositories;
    protected $orderRepositories;
    protected $MBBankRepository;


    /**
     * Construct
     */
    public function __construct()
    {
        $this->cartRepositories = new CartRepositories();
        $this->productRepositories = new ProductRepositories();
        $this->attributesRepositories = new AttributesRepositories();
    }

    /**
     * createCart
     * @param array $array 
     * @return mixed
     */

    public function addToCart($params, $userId, $productId)
    {
        if ($params != null && $userId != null) {
    
            if ($params['productAttributeId'] != null) {
                $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->orderBy('created_at', 'desc')->first();
                if ($cartItem) {
                    // get product
                    $product = Product::where('id', $productId)->first();
                    if ($product == null) {
                        throw new Exception($productId + "not exist!");
                    }

                    $existingProductAttributeIds = explode(',', $cartItem->product_attribute_id);
                    $parmProductAttributeIds = explode(',',$params['productAttributeId']);
                   
                    if ($existingProductAttributeIds === $parmProductAttributeIds) {
                        $attribute = [];
                        $attribute['quantity']  = $params['quantity'] +  $cartItem->quantity;
                        $attribute['total_cart'] = $cartItem->price *  $params['quantity'];
                        return  $this->cartRepositories->update($attribute, $cartItem->id);
                    } else {
                        $price = $product->sale_price > 0 ?  $product->sale_price : $product->price;
                            $quantity = $params['quantity'] > 0 ? $params['quantity'] : 1;

                            $attribute = [];
                            $attribute['user_id'] = $userId;
                            $attribute['product_id'] = (int)$productId;
                            $attribute['quantity'] = $quantity;
                            $attribute['product_attribute_id'] = $params['productAttributeId'];
                            $attribute['price'] =  $price;
                            $attribute['total_cart'] = $price * $quantity;
                            $attribute['status'] = 1;
                            $attribute['created_at'] =  Carbon::now();
                            return  $this->cartRepositories->create($attribute);
                    }
                } else {
                    // if card null add new to cart
                    $product = Product::where('id', $productId)->first();
                    if ($product == null) {
                        throw new Exception($productId + "not exist!");
                    }

                    $price = $product->sale_price > 0 ?  $product->sale_price : $product->price;
                    $quantity = $params['quantity'] > 0 ? $params['quantity'] : 1;

                    $attribute = [];
                    $attribute['user_id'] = $userId;
                    $attribute['product_id'] = (int)$productId;
                    $attribute['quantity'] = $quantity;
                    $attribute['product_attribute_id'] = $params['productAttributeId'];
                    $attribute['price'] =  $price;
                    $attribute['total_cart'] = $price * $quantity;
                    $attribute['status'] = 1;
                    $attribute['created_at'] =  Carbon::now();
                    return  $this->cartRepositories->create($attribute);
                }
            } else {
                $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
                if ($cartItem) {

                    // update cart
                    $attribute = [];
                    $attribute['quantity']  = $params['quantity'] +  $cartItem->quantity;
                    $attribute['total_cart'] = $cartItem->price *  $params['quantity'];
                    return  $this->cartRepositories->update($attribute, $cartItem->id);
                } else {
                    // get product
                    $product = Product::where('id', $productId)->first();
                    if ($product == null) {
                        throw new Exception($productId + "not exist!");
                    }

                    $price = $product->sale_price > 0 ?  $product->sale_price : $product->price;
                    $quantity = $params['quantity'] > 0 ? $params['quantity'] : 1;

                    $attribute = [];
                    $attribute['user_id'] = $userId;
                    $attribute['product_id'] = (int) $productId;
                    $attribute['quantity'] = $quantity;
                    $attribute['product_attribute_id'] = 0;
                    $attribute['price'] =  $price;
                    $attribute['total_cart'] = $price * $quantity;
                    $attribute['status'] = 1;
                    $attribute['created_at'] =  Carbon::now();
                    return  $this->cartRepositories->create($attribute);
                }
            }
        }
    }


    /**
     * update Cart
     * @param array $array 
     * @return mixed
     */

    public function updateCart($params, $userId, $productId)
    {
        if ($params != null) {

            $attribute = [];
            $cart = $this->cartRepositories->where('user_id', $userId)->where('product_id', $productId)->first();
            if ($cart != null) {
                if (isset($params['addQuantity'])) {
                    $quantity = $cart->quantity + $params['addQuantity'];
                    $attribute['quantity'] =  $quantity;
                    $attribute['total_cart'] = $cart->price * $quantity;
                    return  $this->cartRepositories->update($attribute, $cart->id);
                }
            }
        } else {
            throw new Exception("update cart unsuccessful!");
        }
    }

    /**
     * Delete Cart
     * @param array $array 
     * @return mixed
     */
    public function deleteCart($userId, $productId)
    {
        if ($productId != null) {
            $cart = $this->cartRepositories->where('user_id', $userId)->where('product_id', $productId)->first();
            if ($cart != null) {
                return $this->cartRepositories->delete($cart->id);
            }
        } else {
            throw new Exception("delete cart unsuccessful!");
        }
    }

    /**
     * Delete All Cart
     * @param array $array 
     * @return mixed
     */
    public function deleteAllCart($userId, $productId)
    {
        if ($productId != null) {
            foreach ($productId as $itemId) {
                $cart = $this->cartRepositories->where('user_id', $userId)->where('product_id', $itemId)->first();
                if ($cart != null) {
                    $deleteCart = $this->cartRepositories->delete($cart->id);
                }
            }
            return $deleteCart;
        }
    }
}
