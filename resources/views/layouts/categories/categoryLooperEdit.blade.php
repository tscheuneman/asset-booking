@if (count($subCat) > 0)
    @if($subCat->id == $parent)
        <option value="{{$subCat->id}}" selected>{{$offset}} {{$subCat->name}}</option>

    @else
        <option value="{{$subCat->id}}">{{$offset}} {{$subCat->name}}</option>
    @endif
        @foreach($subCat->subcats as $subCat)
            @if ($currentID != $subCat->id)
            @include('layouts.categories.categoryLooperEdit', array(
                      'subCat' => $subCat,
                      'offset' => $offset . '-',
                      'parent' => $parent,
                      'currentID' => $currentID,
                      ))
            @endif
        @endforeach
@endif