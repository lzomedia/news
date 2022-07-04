@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            @include('partials.dashboard.sidebar')
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-12">
                                <h5 class="card-title">
                                    Categories
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12 text-right">
                            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary btn-sm">
                                @lang('crud.create_button')
                            </a>
                        </div>
                        @include('crudable::notifications')
                        @if($categories->isEmpty())
                            @lang('crud.no_entries')
                        @else
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Count</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)

                                    <tr>
                                        <td>
                                            {{ $category->id }}
                                        </td>
                                        <td>
                                            {{ $category->name }}
                                        </td>
                                        <td>
                                            {{ $category->count }}
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-primary"
                                                   href="{{ route('dashboard.categories.edit',$category->id) }}">
                                                    <i class="glyphicon glyphicon-pencil"></i> @lang('crud.edit')
                                                </a>
                                                <form class="btn-group"
                                                      action="{{ route('dashboard.categories.destroy',$category->id) }}"
                                                      method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button class="btn btn-sm btn-danger"
                                                            type="submit"><i
                                                            class="glyphicon glyphicon-trash"></i> @lang('crud.delete')
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- @todo insert pagination here -->
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
