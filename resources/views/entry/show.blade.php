@extends('layouts.app')

@section('pageTitle', "Запись {$entry['id']}")

@section('content')
    <div>
        <span class="font-bold ">Id:</span> {{$entry['id']}}
    </div>
    <div>
        <span class="font-bold ">Текст:</span> {{$entry['text']}}
    </div>
    <div>
        <span class="font-bold ">Статус:</span>
        <span>{{$entry['status']}}
    </div>
    <div>
        <span class="font-bold ">Дата создания:</span>
        @if ($entry['created_at'])
            {{ \Carbon\Carbon::parse($entry['created_at'])->diffForHumans() }}
        @else
            Не установлено
        @endif
    </div>
    <a href="{{route('entry.edit', $entry['id'])}}" class="text-blue-500 hover:text-blue-600 block mt-4 mb-12">
        <i class="fa-solid fa-pen-to-square mr-2"></i>Редактировать
    </a>
    <div>
        <a href="{{route('entry.index')}}" class="text-blue-500 hover:text-blue-600">
            <i class="fa-solid fa-circle-left mr-2"></i>Назад к списку
        </a>
    </div>
@endsection
