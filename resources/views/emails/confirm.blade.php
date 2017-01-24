@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Welcome!',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Your verification code is: <b>{{$token}}</b></p>

    <p>Click below to confirm your email.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Click me',
            'link' => $url
    ])

@stop