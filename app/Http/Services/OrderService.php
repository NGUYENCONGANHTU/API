<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Repositories\CartRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\AttributesRepositories;
use App\Repositories\OrdersRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\HistoryRepository;
use App\Repositories\NotificationRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use App\Models\Users;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService
{
    /**
     * @var Repository
     */

    protected $cartRepositories;
    protected $productRepositories;
    protected $attributesRepositories;
    protected $orderRepositories;
    protected $orderDetailRepositories;
    protected $historyRepository;
    protected $notificationRepository;


    /**
     * Construct
     */
    public function __construct()
    {
        $this->cartRepositories = new CartRepositories();
        $this->productRepositories = new ProductRepositories();
        $this->attributesRepositories = new AttributesRepositories();
        $this->orderRepositories = new OrdersRepository();
        $this->orderDetailRepositories = new OrderDetailRepository();
        $this->historyRepository = new HistoryRepository();
        $this->notificationRepository = new NotificationRepository();
        
    }

    public function checkOut($userId,$params){
        $order = null;
        $attribute = [];
        $user = Users::where('id',$userId)->first();
        $radomOrderId = $this->generateRandomString(10);
        if($user == null){
            throw new Exception("user not exits!");
        }
        // add model order
        $attribute['user_id'] = $user->id;
        $attribute['order_id'] =  $radomOrderId;
        $attribute['email'] = $user->email;
        $attribute['address'] =  $user->address + $user->city;
        $attribute['phone_number'] = $user->phone_number;
        $attribute['name'] = $user->user_name;
        $attribute['status'] = 1;
        $attribute['order_pay_status'] = 0;
        $attribute['note'] = $params['note'];
        $order =  $this->orderRepositories->create($attribute);

        foreach(explode(',', $params['cartId']) as $itemCart){
            $cart = Cart::where('id',$itemCart)->where('user_id',$userId)->first();
            if($cart == null){
                throw new Exception("get cart failed");
            }

            /** 
             * add Order Detail
            */
            $this->orderDetailRepositories->addOrderDetail($cart,$order->id);

            /** 
             * get product Name 
            */
            $product = Product::where('id',$cart->product_id)->first();
            /** 
             *add History Cart
            */
            $this->historyRepository->addHistoryCart($cart, $product->name);
            $this->productRepositories->UpdateProductPurchases($product);
        }

        $attributeNotification = [];
        $attributeNotification['title'] = 'Bạn vừa đăt thành đơn hàng' + $order->order_id;
        $attributeNotification['order_id'] = $order->order_id;
        $attributeNotification['user_id'] = $userId;
        $attributeNotification['description'] = '';
        $attributeNotification['status'] = 1;
        $this->notificationRepository->createNotification( $attributeNotification);

        return $order;

    }

    function generateRandomString($length = 6)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function setRowInformation()
    {
        $userId = Auth::guard('app-users')->user()->id;
        return $this->orderRepositories->userOrder($userId);
    }
}
