@extends('andor9229.adminpanelgenerator.layouts.app')

@section('content')
     <div class="flex mb-10 justify-center">
        <card-component class="w-full">
            <div slot="header" class="w-full flex justify-between">
                <h3>AdminPanelPages</h3>
                <div class="flex justify-end">
                    <form action="{{ route('adminpanelpage.trash') }}" method="get">
                        <button
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                            type="submit"
                        ><i class="fas fa-trash"></i>&nbsp;&nbsp;
                            Trash
                        </button>
                    </form>
                    <form action="{{ route('adminpanelpage.create') }}" method="get">
                        <button
                            class="ml-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit"
                        ><i class="fas fa-plus"></i>&nbsp;&nbsp;
                            New AdminPanelPage
                        </button>
                    </form>
                </div>
            </div>
            @include('andor9229.adminpanelgenerator.pages.AdminPanelPage.table')
        </card-component>
    </div>
@endsection

