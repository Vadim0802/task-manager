@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col">
                <h1>Задачи</h1>
                @if(session('success'))
                    <div class="alert alert-primary" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-10 mb-4">
                <form action="{{ route('tasks.index') }}" method="GET">
                    <div class="d-flex gap-3">
                        <select name="status" class="form-select">
                            <option>Статус</option>
                        </select>
                        <select name="author" class="form-select">
                            <option>Автор</option>
                        </select>
                        <select name="executor" class="form-select">
                            <option>Исполнитель</option>
                        </select>
                        <button type="submit" class="btn btn-outline-primary">Применить</button>
                    </div>
                </form>
            </div>
            @auth
                <div class="col-2 d-flex justify-content-end">
                    <div>
                        <a href="{{ route('tasks.create') }}" class="btn btn-outline-primary">Создать задачу</a>
                    </div>
                </div>
            @endauth
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="row">ID</th>
                            <th scope="row">Статус</th>
                            <th scope="row">Имя</th>
                            <th scope="row">Автор</th>
                            <th scope="row">Исполнитель</th>
                            <th scope="row">Дата создания</th>
                            <th scope="row">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->status->status }}</td>
                                <td>
                                    <a class="text-decoration-none" href="{{ route('tasks.show', $task) }}">
                                        {{ Str::limit($task->title, 30) }}
                                    </a>
                                </td>
                                <td>{{ $task->author->name }}</td>
                                <td>{{ $task->executor->name }}</td>
                                <td>{{ $task->created_at->toDateString() }}</td>
                                <td>
                                    @can('update', $task)
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary mb-2">
                                            Изменить
                                        </a>
                                    @endcan
                                    @can('delete', $task)
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger">Удалить</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
