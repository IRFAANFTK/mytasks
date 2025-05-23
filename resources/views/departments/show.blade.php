@extends('layouts.app')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="float-start">
                        Informations sur le département
                    </div>
                    <div class="float-end">
                        <a href="{{ route('departments.index') }}" class="btn btn-primary btn-sm">&larr; Retour</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Nom :</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $department->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
