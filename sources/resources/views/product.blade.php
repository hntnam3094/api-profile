@extends('layouts.master')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-dark mb-4 animated slideInDown">Sản phẩm</h1>
    </div>
</div>
<!-- Page Header End -->


<!-- Products Start -->


<div class="container-fluid product py-5">
    @foreach ($data as $category)
        @if ($category)
        <div class="container py-5">
            <div class=" text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-medium fst-italic text-primary"><?= $category['name'] ?? ''  ?></p>
            </div>
            <div class="row g-4">
                @foreach ($category['data'] as $key =>  $item)
                @php
                    if ($key > 2) {
                        break;
                    }
                @endphp
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="store-item position-relative text-center">
                            <img class="img-fluid" src="<?= $item['avatar'] ?? '' ?>" alt="<?= $item['name'] ?? '' ?>">
                            <div class="p-4">
                                {{-- <div class="text-center mb-3">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                </div> --}}
                                <h4 class="mb-3"><?= $item['name'] ?? '' ?></h4>
                                <p><?= $item['description'] ?? '' ?></p>
                                <h4 class="text-primary"><?= $item['price'] ?? '' ?> VND</h4>
                            </div>
                            <div class="store-overlay">
                                <a href="/san-pham/<?= $item['slug'] ?? '' ?>.html" class="btn btn-primary rounded-pill py-2 px-4 m-2">Chi tiết <i class="fa fa-arrow-right ms-2"></i></a>
                                {{-- <a href="" class="btn btn-dark rounded-pill py-2 px-4 m-2">Add to Cart <i class="fa fa-cart-plus ms-2"></i></a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
</div>
<!-- Products End -->
@endsection
