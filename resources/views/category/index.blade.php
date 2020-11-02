@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('partials.flash')
                <div class="card">
                    <div class="card-header">{{ $pageTitle }}
                        <div class="float-right">
                            <a href="{{route('categories.create')}}" class="btn btn-success">Create new Category</a>
                        </div>
                    </div>


                    <div class="card-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th> Name </th>
                                <th> Slug </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <form action="{{route('categories.destroy', $category->id)}}" method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="_method" value="delete">
                                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">edit</a>
                                                <button type="submit" class="btn btn-sm btn-danger">delete</button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
@endpush
