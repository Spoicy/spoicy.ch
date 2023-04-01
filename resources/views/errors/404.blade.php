@extends('errors::layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@if (str_contains(Request::url(), 'blog'))
    @section('additional', "No blog post could be found with this title.")
@endif