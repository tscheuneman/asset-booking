@if (count($subCat) > 0)
    <option value="{{$subCat->id}}">{{$offset}} {{$subCat->name}}</option>
    @foreach($subCat->subcats as $subCat)
        @include('layouts.categories.categoryLooperCreate', array(
                  'subCat' => $subCat,
                  'offset' => $offset . '-'
                  ))
    @endforeach
@endif