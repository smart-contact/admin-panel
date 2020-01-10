@extends('andor9229.adminpanelgenerator.layouts.app')

@section('content')
<card-component>
    <div slot="header">
       <h3>Update AdminPanelPage</h3>
    </div>
    <form slot="body" method="POST" action="{{ route('adminpanelpage.update', $adminpanelpage) }}">
        @csrf
        @method('patch')
        @foreach($data as $index => $d)
            @switch($d['type'])
                @case('boolean')
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4 text-left">
                        <div class="form-check">
                            <input name="{{ $index }}"  class="form-check-input @error($index) is-invalid @enderror" type="checkbox" id="{{ $index }}" value="{{ $adminpanelpage[$index] }}" >
                            @error($index)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label class="form-check-label capitalize-text" for="{{ $index }}">
                                {{ $index }}
                            </label>
                        </div>
                    </div>
                </div>
                @break

                @case('select')
                    <div class="form-group row">
                        <label for="{{ $index }}" class="col-md-4 col-form-label text-md-right text-capitalize">{{ $index }}</label>

                        <div class="col-md-6">
                            <select id="{{ $index }}" name="{{$index}}[]" class="form-control" multiple></select>
                        </div>
                    </div>
                @break

                @default
                <div class="md:flex md:items-center mb-6">
                     <div class="md:w-1/3">
                        <label for="name" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">{{ $index }}</label>
                    </div>
                    <div class="md:w-2/3">
                        <input id="{{ $index }}" type="text" class="{{ $errors->has($index) ? 'border-red-500' : 'border-gray-200'}} bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" name="{{ $index }}" value="{{ $adminpanelpage[$index] }}"  required autocomplete="{{ $index }}" autofocus>

                        @error($index)
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endswitch
        @endforeach
        <div class="md:flex md:items-center">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3">
                <button class="shadow bg-blue-400 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                    Salva
                </button>
            </div>
        </div>
    </form>
</card-component>
@endsection
