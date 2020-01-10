<table class="table border w-full" slot="body">
    <tr>
    <th>Actions</th>
    @foreach(\Andor9229\AdminPanel\models\AdminPanelPage::getColumns() as $column)
      <th scope="col">{{ $column }}</th>
    @endforeach
    </tr>
   @foreach($adminpanelpages as $rows)
    <tr>
        <td class="flex items-center">
            @if($type === 'index')
                <a href="{{ route('adminpanelpage.show', [ 'adminpanelpage' => $rows['id'] ]) }}" class="button-icon-gray items-center"><i class="far fa-fw fa-eye"></i></a>
                <a href="{{ route('adminpanelpage.edit', [ 'adminpanelpage' => $rows['id'] ]) }}" class="button-icon-gray items-center"><i class="fas fa-edit"></i></a>
                <confirm-delete-component
                    class="items-center"
                    url="/adminpanelpage/{{$rows['id']}}/delete"
                    resource="{{$rows}}"
                    match="name"
                    delete-message=""
                    location-href="adminpanelpage"
                ></confirm-delete-component>
            @endif
            @if($type === 'trash')
                <a href="{{ route('adminpanelpage.restore', [ 'id' => $rows['id'] ]) }}" class="button-icon-gray items-center"><i class="fas fa-redo"></i></a>
                <confirm-delete-component
                    class="items-center"
                    url="/adminpanelpage/{{$rows['id']}}/force-destroy"
                    resource="{{$rows}}"
                    match="name"
                    delete-message=""
                    location-href="adminpanelpage/trash"
                ></confirm-delete-component>
            @endif
        </td>
        @foreach(\Andor9229\AdminPanel\models\AdminPanelPage::getColumns() as $column)
            <td scope="row">{{ $rows[$column] }}</td>
        @endforeach
    </tr>
    @endforeach
</table>
