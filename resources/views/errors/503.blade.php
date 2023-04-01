@extends('errors::layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Service Unavailable'))
@section('additional', "We're currently down for maintenance. We'll be back shortly!")