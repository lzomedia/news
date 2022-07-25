@extends('layouts.app')
@section('content')

    <div class="container mt-5">
        <div class="row">
            @include('partials.dashboard.errors')
            <div class="row justify-content-center">
                @include('partials.dashboard.sidebar')
                <div class="col-md-10">
                    <x-rpd::table
                        title="Article List"
                        :items="$items"
                    >

                        <x-slot name="filters">
                            <div class="col">
                                <x-rpd::input debounce="350" model="search"  placeholder="search..." />
                            </div>
                            <div class="col">
                            </div>
                        </x-slot>

                        <x-slot name="buttons">
                            <a href="#" class="btn btn-outline-dark">reset</a>
                            <a href="#" class="btn btn-outline-primary">add</a>
                        </x-slot>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>
                                    <x-rpd::sort model="id" label="id" />
                                </th>
                                <th>title</th>
                                <th>body</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $article)
                                <tr>
                                    <td>
                                        <a href="#">{{ $article->id }}</a>
                                    </td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ Str::limit($article->summary,10) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </x-rpd::table>
                </div>
            </div>
        </div>
    </div>

@endsection
