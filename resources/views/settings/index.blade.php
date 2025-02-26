@extends('layouts.app')

@section('pageTitle', 'Создать Запись')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @include('partials.validation-errors')

    <form action="{{route('settings.store')}}" method="post">
        @csrf
        @method('patch')
        <label class="font-bold" for="document-url">Документ Google Sheet URL:</label>
        <br/>
        <input name="document-url" value="{{ $url }}" id="document-url" class="rounded-md w-3/4"/>
        <br/>
        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 rounded-lg text-white p-2 pl-5 pr-5 font-medium mt-4">
            Сохранить
        </button>
    </form>
    <div class="mt-12">
        <a href="{{route('entry.index')}}" class="text-blue-500 hover:text-blue-600">
            <i class="fa-solid fa-circle-left mr-2"></i>Назад к списку
        </a>
    </div>
@endsection

