@extends('layouts.master')

@section('content')

<div class="container-fluid  py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-dark mb-4 animated slideInDown"><?= $data['about_us']['title'] ?? '' ?></h1>
    </div>
</div>
<!-- Page Header End -->


<!-- About Start -->
<div class="container-xxl py-5">
    <?= $data['about_us']['content'] ?? '' ?>
</div>
<!-- About End -->
@endsection
