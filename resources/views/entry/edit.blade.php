@extends('layouts.app')

@section('pageTitle', "Редактировать Запись {$entry['id']}")

@section('content')
    <form action="{{route('entry.update', $entry['id'])}}" method="post">
        @csrf
        @method('patch')
        <div><span class="font-bold">Id:</span> {{$entry['id']}}</div>
        <label class="font-bold ">Текст:</label>
        <textarea name="text" class="block rounded-md resize" rows="4" cols="50" type="text">{{$entry['text']}}</textarea>
        <span class="font-bold block">Статус:</span>
        <select name="status" id="status-select" class="rounded-md block">
            @foreach(\App\Models\Enums\EntryStatus::toArray() as $status)
                <option {{$entry['status']->value == $status ? 'selected' : ''}} value="{{$status}}">{{$status}}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 rounded-lg text-white p-2 pl-5 pr-5 font-medium mt-4">
            Сохранить
        </button>
    </form>
    <form action="{{route('entry.destroy', $entry['id'])}}" method="post" class="mt-2">
        @csrf
        @method('delete')
        <button type="submit" class="bg-red-500 hover:bg-red-600 rounded-lg text-white p-2 pl-5 pr-5 font-medium">
            Удалить
        </button>
    </form>
    <div class="mt-12">
        <a href="{{route('entry.index')}}" class="text-blue-500 hover:text-blue-600">
            <i class="fa-solid fa-circle-left mr-2"></i>Назад к списку
        </a>
    </div>
@endsection
