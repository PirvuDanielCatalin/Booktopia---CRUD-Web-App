@extends('general.shop')

@section('shop-scripts')
    <script type="text/javascript"
            src="{{ secure_asset('libs/jquery.session.js') }}" defer></script>
    <script type="text/javascript"
            src="{{ secure_asset('js/general/shopping-cart.js') }}" defer></script>
@endsection

@section('shop-styles')
    <link rel="stylesheet" type="text/css"
          href="{{ secure_asset('css/general/shopping-cart.css') }}">
@endsection

@section('scontent')
    <div class="col-md-12">
        <h3>Your shopping cart:</h3>
    </div>
    <div class="col-md-12">
        <h5 class="no-products-h" style="display: {{ (empty($products)) ? 'block' : 'none'}}">
            @lang('dictionary.general.shopping-cart.nothing-in-cart')<br>
            <a href="{{ url('/') }}"
               class="no-products-redirect">@lang('dictionary.general.shopping-cart.go-to-shop')</a>
        </h5>
        @if(!empty($products))
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th class="tbl-book-id">ID:</th>
                    <th class="tbl-book-title">@lang('dictionary.book.title')</th>
                    <th class="tbl-book-quantity">@lang('dictionary.book.quantity')</th>
                    <th class="tbl-book-price">@lang('dictionary.book.price')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="tbl-book-id">{{ $product['book']->book_id }}</td>
                        <td class="tbl-book-title">{{ $product['book']->title }}</td>
                        <td class="tbl-book-quantity">
                            <input book-price="{{ $product['book']->price }}"
                                   type="hidden">
                            <button class="btn btn-outline-secondary d-inline-block quantity-minus"
                                    type="button">-1
                            </button>
                            <input class="form-control d-inline-block text-center"
                                   type="number"
                                   value="{{ $product['quantity'] }}">
                            <button type="button"
                                    class="btn btn-outline-secondary d-inline-block quantity-plus">+1
                            </button>
                        </td>
                        <td class="tbl-book-price">
                            <input class="form-control text-center"
                                   disabled
                                   type="number"
                                   value="{{ round($product['quantity'] * $product['book']->price, 2) }}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                <div class="user-points-div">
                    <div class="user-points-value-div">
                        <b>@lang('dictionary.general.shopping-cart.fidelity-points')</b>
                    </div>
                    @if(Auth::user())
                        <div class="user-points-value">
                            <b>10</b>
                        </div>
                        <button class="btn btn-outline-secondary"
                                data-placement="top"
                                data-toggle="tooltip"
                                title="@lang('dictionary.actions.use')">
                            <i class="fas fa-certificate"></i>
                        </button>
                    @else
                        <div class="user-points-value">
                            <b>@lang('dictionary.general.shopping-cart.use-points')</b>
                        </div>
                    @endif
                </div>
                <div class="products-total-price-div">
                    <div class="products-total-price-value-div"><b>Total:</b></div>
                    <div class="products-total-price-value"><b></b></div>
                </div>
                <button class="btn btn-outline-secondary btn-lg products-total-price-checkout-btn"
                        type="button"
                        user-logged="{{ (Auth::user()) ? 'true' : 'false' }}">
                    <b>@lang('dictionary.actions.checkout')</b>
                </button>
                <form method="post" action="{{ route('invoices.store') }}">
                    @csrf
                    <div class="card billing_address_card">
                        <div class="card-header text-center">
                            @lang('dictionary.invoice.billing_address')
                            <span class="caret-down float-right" style="display: none;">
                                <i class="fas fa-caret-down fa-2x"></i>
                            </span>
                            <span class="caret-up float-right">
                                <i class="fas fa-sort-up fa-2x"></i>
                            </span>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6">
                                <label class="d-flex">
                                    <input type="radio"
                                           name="billing_address_radio"
                                           value="">
                                    <div class="w-100 under-radio-input">
                                        Lorem ipsum dolor sit amet, consectetur
                                        adipisicing elit. Accusantium aliquam, dignissimos, harum incidunt molestiae
                                        natus nisi numquam perferendis
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="d-flex">
                                    <input type="radio" name="billing_address_radio">
                                    <textarea rows="2"
                                              class="form-control"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card delivery_address_card">
                        <div class="card-header text-center">
                            @lang('dictionary.invoice.delivery_address')
                            <span class="caret-down float-right" style="display: none;">
                                <i class="fas fa-caret-down fa-2x"></i>
                            </span>
                            <span class="caret-up float-right">
                                <i class="fas fa-sort-up fa-2x"></i>
                            </span>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6">
                                <label class="d-flex">
                                    <input type="radio"
                                           name="delivery_address_radio"
                                           value="">
                                    <div class="w-100 under-radio-input">
                                        Lorem ipsum dolor sit amet, consectetur
                                        adipisicing elit. Accusantium aliquam, dignissimos, harum incidunt molestiae
                                        natus nisi numquam perferendis
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="d-flex">
                                    <input type="radio" name="delivery_address_radio">
                                    <textarea rows="2"
                                              class="form-control"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card payment_method_card">
                        <div class="card-header text-center">
                            @lang('dictionary.invoice.payment_method')
                            <span class="caret-down float-right" style="display: none;">
                                <i class="fas fa-caret-down fa-2x"></i>
                            </span>
                            <span class="caret-up float-right">
                                <i class="fas fa-sort-up fa-2x"></i>
                            </span>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6">
                                <label class="d-flex">
                                    <input type="radio"
                                           name="payment_method_radio"
                                           value="">
                                    <div class="w-100 under-radio-input">
                                        Ramburs
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="d-flex">
                                    <input type="radio" name="payment_method_radio" disabled>
                                    <div class="w-100 under-radio-input">
                                        Card (PayU)
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card price_card">
                        <div class="card-header text-center">
                            @lang('dictionary.book.price')
                            <span class="caret-down float-right" style="display: none;">
                                <i class="fas fa-caret-down fa-2x"></i>
                            </span>
                            <span class="caret-up float-right">
                                <i class="fas fa-sort-up fa-2x"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 p-4">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aliquid cum dolorem
                                earum inventore molestiae nesciunt placeat quidem. Cumque dolor eligendi molestiae
                                nostrum pariatur quas ratione sapiente soluta tenetur unde?
                            </div>
                            <div class="col-md-12">
                                <input class="btn btn-success btn-block" type="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection
