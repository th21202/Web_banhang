<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderServiceInterface;
use App\Services\OrderDetail\OrderDetailServiceInterface;
use App\Utilities\Constant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Utilities\VNPay;
use Illuminate\Support\Facades\Mail;

class CheckOutController extends Controller
{
    //
    private $orderService;
    private $orderDetailService;
    public function __construct(OrderServiceInterface $orderService,
                                OrderDetailServiceInterface $orderDetailService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
    }

    public function index() {
        $carts = Cart::content();
        $total = Cart::total();
        $subtotal = Cart::subtotal();
        return view('front.checkout.index', compact('carts', 'total', 'subtotal'));
    }
    public function addOrder(Request $request){
        //them don hang
        $data = $request->all();
        $data['status'] = Constant::order_status_ReceiveOrders;
        $order = $this->orderService->create($data);

        //them chi tiet don hang
        $carts = Cart::content();

        foreach ($carts as $cart){
            $data = [
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'qty' => $cart->qty,
                'amount' => $cart->price,
                'total' => $cart->qty * $cart->price,
            ];
                $this->orderDetailService->create($data);
        }
        if($request->payment_type == 'pay_later'){
            //gui email
            $total = Cart::total();
            $subtotal = Cart::subtotal();
            $this->sendEmail($order, $total, $subtotal);
            //xoa
            Cart::destroy();
            //tra ve ket qua

            return redirect('checkout/result')
                ->with('notification','Success! you will pay on delivery. Please check your email.');
        }
        if($request->payment_type == 'online_payment'){
            //lay URL thanh toasn vnpay:
            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $order->id, //ID cua don hang.
                'vnp_OrderInfo' => 'moo tar don hang o ' ,//mo ta don hang
                'vnp_Amount' => Cart::total(0, '', '') * 23070,//tong gia cua don hang nhan voi ti gia


            ]);
            //02 chuyen huong toi URL lay dc:
            return redirect()->to($data_url);

        }

    }
    public function vnPayCheck(Request $request)
    {
        //01 lay data tu url (do vnpay gui ve qua $vnp_returnurl):
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TxnRef = $request->get('vnp_TxnRef'); //order_id
        $vnp_Amount = $request->get('vnp_Amount');

        //02 kiem tra data, xem ket qua giao dich tra ve vnpay
        if ($vnp_ResponseCode != null) {
            //neu thanh cong:
            if ($vnp_ResponseCode == 00) {
                //gui email
                $this->orderService->update(['status' => Constant::order_statuss_Paid], $vnp_TxnRef);
                $order = $this->orderService->find($vnp_TxnRef);
                $total = Cart::total();
                $subtotal = Cart::subtotal();
                $this->sendEmail($order, $total, $subtotal);
                Cart::destroy();
                //thong bao ket qua
                return redirect('checkout/result')
                    ->with('notification', 'Success! you will pay on delivery. Please check your email');
            } else { //neu khong thanh cong
                //xoa don hang da them vao
                $this->orderService->delete($vnp_TxnRef);

                return redirect('checkout/result')
                    ->with('notification', 'ERROR: Payment failed or canceled.');
            }

        }
    }
    public function result(){
        $notification = session('notification');
        return view('front.checkout.result', compact('notification'));
    }
    public function sendEmail($order, $total, $subtotal){
        $email_to = $order->email;
        Mail::send('front.checkout.email',
            compact('order', 'total', 'subtotal'),
            function ($message)  use ($email_to){
            $message->from('linhvo2612002@gmail.com', 'ecommerco');
            $message->to($email_to, $email_to);
            $message->subject('Order Notification');
        });
    }
}
