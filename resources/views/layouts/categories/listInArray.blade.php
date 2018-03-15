@if($subCat != null)
    <span class="specialRight">{{$subCat->name}} <strong>/</strong> </span>
    @include('layouts.categories.listInArray', array(
      'subCat' => $subCat->parentcatrecursive,
     ))
@endif