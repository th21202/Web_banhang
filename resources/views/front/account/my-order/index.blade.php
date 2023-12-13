@extends('front.layout.master')

@section('title', 'My Order')

@section('body')
    <!-- breadcrumb  -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="./home.html"><i class="fa fa-home"></i>Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shopping cart section begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th class="p-name">Product name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th><i class="ti-close"></i></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orders as $order)
                                @foreach($order->orderDetails as $orderDetail)
                                    <tr>
                                        @if($loop->first)
                                            <td class="cart-pic first-row"><img style="height:100px;"
                                                                                src="front/img/products/{{$orderDetail->product->productImages[0]->path}}"></td>
                                            <td class="first-row">#{{$order->id}}</td>
                                        @else
                                            <td></td>
                                            <td></td>
                                        @endif
                                        <td class="cart-title first-row">
                                            <h5>
                                                {{ $orderDetail->product->name }}
                                            </h5>
                                        </td>
                                        <td class="total-price first-row">
                                            ${{ $orderDetail->total }}
                                        </td>
                                        @if($loop->first)
                                            <td class="first-row">
                                                <a class="btn" href="./account/my-order{{$order->id}}">Details</a>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
