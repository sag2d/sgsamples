@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    <div class="block">
        {{ __('Not Found') }}
    </div>
    <br>
    <div class="block text-neutral-600 dark:text-neutral-400">
        {{ __('Sorry, the page you\'re looking for doesn\'t exist.') }}
    </div>
    <br>
    <div class="block">
        <a href="/" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150">
            &laquo; {{ __('Back to Home') }}
        </a>
    </div>
@endsection


