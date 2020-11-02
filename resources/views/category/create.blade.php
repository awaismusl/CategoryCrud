@extends('layouts.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.flash')
                <div class="card">
                    <div class="card-header">{{ $pageTitle }}</div>

                    <div class="card-body">
                        <form action="{{ route('categories.store') }}" method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="tile-body">
                                <div class="form-group">
                                    <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                                    @error('name') {{ $message }} @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="description">Description</label>
                                    <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Category Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Category</button>
                                &nbsp;&nbsp;&nbsp;
                                <a class="btn btn-secondary" href="{{ route('categories.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

