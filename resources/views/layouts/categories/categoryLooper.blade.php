@if (count($subCat) > 0)
    <tr class="child">
        <td style="width: 20px;"></td>
        <td style="text-indent: {{$offset}}px">
            {{$subCat->name}}
        </td>
        <td>
            {{$subCat->slug}}
        </td>
        <td>
            {{$subCat->updated_at->format('Y-m-d')}}
        </td>
        <td>
            <a class="editAction" href="/admin/category/edit/{{$subCat->id}}"><span class="glyphicon glyphicon-pencil"> </span> Edit</a>
        </td>
    </tr>
    @foreach($subCat->subcats as $subCat)
        @include('layouts.categories.categoryLooper', array(
                  'subCat' => $subCat,
                  'offset' => $offset + 20
                  ))
    @endforeach
@endif