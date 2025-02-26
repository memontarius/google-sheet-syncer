@extends('layouts.app')

@section('pageTitle', 'Создать Запись')

@section('content')
    @include('partials.success-alert')
    @include('partials.validation-errors')

    <form action="{{route('entry.store')}}" method="post">
        @csrf
        <label class="font-bold ">Текст:</label>
        <textarea name="text" class="block rounded-md resize" rows="4" cols="50" type="text">{{ old('text') }}</textarea>
        <span class="font-bold block">Статус:</span>
        <select name="status" id="status-select" class="rounded-md block">
            @foreach(\App\Models\Enums\EntryStatus::toArray() as $status)
                <option {{ old('status') == $status ? 'selected' : '' }} value="{{$status}}">{{$status}}</option>
            @endforeach
        </select>
        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 rounded-lg text-white p-2 pl-5 pr-5 font-medium mt-4 mb-12">
            Создать
        </button>
    </form>
    <div>
        <a href="{{route('entry.index')}}" class="text-blue-500 hover:text-blue-600">
            <i class="fa-solid fa-circle-left mr-2"></i>Назад к списку
        </a>
    </div>
@endsection

