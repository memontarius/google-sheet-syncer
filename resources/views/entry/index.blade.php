@extends('layouts.app')

@section('pageTitle', config('app.name', 'Laravel'))

@section('content')
    @include('partials.success-alert')

    @if ($entries->total())
        <table class="entries-table">
            <tr>
                <th class="min-w-[60px]">Id</th>
                <th style="width: 50%">Текст</th>
                <th>Статус</th>
                <th>Дата создания</th>
            </tr>
            @foreach($entries as $entry)
                <tr>
                    <td>{{$entry['id']}}</td>
                    <td>{{\Illuminate\Support\Str::limit($entry['text'], 40)}}</td>
                    <td>{{$entry['status']}}</td>
                    <td>
                        @if ($entry['created_at'])
                            {{ \Carbon\Carbon::parse($entry['created_at'])->diffForHumans() }}
                        @else
                            Не установлено
                        @endif
                    </td>
                    <td>
                        <a href="{{route('entry.show', $entry['id'])}}" class="text-blue-500 hover:text-blue-600">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{route('entry.edit', $entry['id'])}}"
                           class="text-blue-500 hover:text-blue-600 ml-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="p-6">
            {{ $entries->onEachSide(1)->links() }}
        </div>
    @endif

    <div class="mt-12 flex justify-between">
        <div>
            <a href="{{route('entry.create')}}" class="inline-block bg-blue-500 hover:bg-blue-600 rounded-lg text-white p-2 pl-5 pr-5 font-medium mb-2">
                Создать запись
            </a>

            <form action="{{route('entry.generate')}}" method="post" class="mb-2">
                @csrf
                <button class="bg-blue-500 hover:bg-blue-600 rounded-lg text-white p-2 pl-5 pr-5 font-medium"
                        type="submit">Сгенерировать 1000 записей
                </button>
            </form>
            <form action="{{route('entry.clear')}}" method="post">
                @csrf
                <button class="bg-orange-500 hover:bg-orange-600 rounded-lg text-white p-2 pl-5 pr-5 font-medium"
                        type="submit">Очистить таблицу
                </button>
            </form>
        </div>

        <div>
            <a href="{{route('settings.index')}}" class=" inline-block bg-blue-500 hover:bg-blue-600 rounded-lg text-white p-2 pl-4 pr-4 font-medium mb-2">
                <i class="fa-solid fa-gear"></i>
            </a>
        </div>
    </div>
@endsection
