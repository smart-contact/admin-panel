@extends('andor9229.adminpanelgenerator.layouts.app')

@section('content')
     <div class="flex mb-10 justify-center">
        <card-component class="w-full">
            <div slot="header" class="w-full flex justify-between">
                <h3>AdminPanelPage</h3>
            </div>
            <div slot="body">
                @foreach($columns as $column)
                    <p>{{ $column }}: {{ $adminpanelpage[$column] }}</p>
                @endforeach
            </div>
        </card-component>
    </div>
@endsection
