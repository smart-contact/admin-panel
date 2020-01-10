@extends('andor9229.adminpanelgenerator.layouts.app')

@section('content')
<div>
    <h3>Add New AdminPanelPage</h3>
    <admin-panel-form route="{{ route('adminpanelpage.store') }}"></admin-panel-form>
</div>
@endsection
