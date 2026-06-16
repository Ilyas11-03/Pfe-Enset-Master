@extends('layouts.blank')

@section('title', '404 PAGE')

@section('content')
<div class="container">
    <div class="text-center">
        <h1 class="mb-2 mx-2 mt-5" style="line-height: 6rem; font-size: 6rem;">404</h1>
        <h4 class="mb-2 mx-2">Page Not Found️ ⚠️</h4>
        <p class="mb-6 mx-2">We couldn't find the page you are looking for.</p>
        <a href="javascript:history.back()" class="btn btn-primary">Back to previous page</a>
        <div class="mt-4">
            <img src="/assets/img/illustrations/page-misc-error-light.png"
                 alt="404" width="500" class="img-fluid"
                 data-app-dark-img="illustrations/page-misc-error-dark.png"
                 data-app-light-img="illustrations/page-misc-error-light.png">
        </div>
    </div>
</div>
@endsection
