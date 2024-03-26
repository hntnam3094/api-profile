@extends('layouts.master')

@section('content')

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
</div>
<!-- Spinner End -->

<!-- Carousel Start -->
<div class="container-fluid px-0 mb-5">
    <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @isset($structionData['slider_top'])
                @foreach ($structionData['slider_top'] as $key => $item)
                    <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                        <img class="w-100" src="<?= $item['image_cover'] ?>" alt="Image">
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-7 text-center">
                                        <p class="fs-4 text-white animated zoomIn"><?= $item['title'] ?></p>
                                        <h1 class="display-1 text-dark mb-4 animated zoomIn"><?= $item['sub_title'] ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Carousel End -->


<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        @isset($structionData['home_story'])
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6 text-end">
                        <img class="img-fluid bg-white w-100 mb-3 wow fadeIn" data-wow-delay="0.1s" src="<?= $structionData['home_story']['image_in_list_1'] ?>" alt="">
                        <img class="img-fluid bg-white w-50 wow fadeIn" data-wow-delay="0.2s" src="<?= $structionData['home_story']['image_in_list_2'] ?>" alt="">
                    </div>
                    <div class="col-6">
                        <img class="img-fluid bg-white w-50 mb-3 wow fadeIn" data-wow-delay="0.3s" src="<?= $structionData['home_story']['image_in_list_3'] ?>" alt="">
                        <img class="img-fluid bg-white w-100 wow fadeIn" data-wow-delay="0.4s" src="<?= $structionData['home_story']['image_in_list_4'] ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="">
                    <p class="fs-5 fw-medium fst-italic text-primary">Về chúng tôi</p>
                    <h1 class="display-6"><?= $structionData['home_story']['title'] ?></h1>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-sm-4">
                        <img class="img-fluid bg-white w-100" src="<?= $structionData['home_story']['image_1'] ?>" alt="">
                    </div>
                    <div class="col-sm-8">
                        <h5><?= $structionData['home_story']['title_1'] ?></h5>
                        <p class="mb-0"><?= $structionData['home_story']['sub_title_1'] ?></p>
                    </div>
                </div>
                <div class="border-top mb-4"></div>
                <div class="row g-3">
                    <div class="col-sm-8">
                        <h5><?= $structionData['home_story']['title_2'] ?></h5>
                        <p class="mb-0"><?= $structionData['home_story']['sub_title_2'] ?></p>
                    </div>
                    <div class="col-sm-4">
                        <img class="img-fluid bg-white w-100" src="<?= $structionData['home_story']['image_2'] ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
        @endisset
    </div>
</div>
<!-- About End -->

<!-- Store Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class=" text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="fs-5 fw-medium fst-italic text-primary">Bán chạy nhất</p>
            {{-- <h1 class="display-6">Want to stay healthy? Choose tea taste</h1> --}}
        </div>
        <div class="row g-4">
            @foreach ($productData as $key =>  $item)
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
            <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                <a href="/san-pham" class="btn btn-primary rounded-pill py-3 px-5">Tất cả sản phẩm</a>
            </div>
        </div>
    </div>
</div>
@endsection
