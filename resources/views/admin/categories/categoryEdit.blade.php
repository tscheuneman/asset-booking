@extends('layouts.admin')
@section('title')
    Edit Category
@stop
@section('content')
    <h2>Edit {{$category->name}}</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/category') }}/{{$category->id}}" id="submit" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$category->id}}">
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{$category->name}}">
        </div>

        @if(config('adminSettings.multi-level-cats'))
            <div class="form-group">
                <label for="description">Parent</label>
                <select class="form-control" name="parent" id="parent">
                    <option value="" selected>Top Level Category</option>
                    @foreach($cat as $theCat)
                        @if($theCat->id !== $category->id)
                            @if($theCat->id == $category->parent_cat)
                                <option value="{{$theCat->id}}" selected>{{$theCat->name}}</option>
                            @else
                                <option value="{{$theCat->id}}">{{$theCat->name}}</option>
                            @endif
                        @endif
                        @foreach($theCat->subcats as $subCat)
                                @if ($category->id != $subCat->id)
                                    @include('layouts.categories.categoryLooperEdit', array(
                                        'subCat' => $subCat,
                                        'offset' => '-',
                                        'parent' => $category->parent_cat,
                                        'currentID' => $category->id,
                                        ))
                                @endif
                         @endforeach
                    @endforeach
                </select>
            </div>
        @endif

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="6">{{$category->description}}</textarea>
        </div>

        <div class="form-group">
            <label for="marker">Marker Image</label>
            <input type="file" class="form-control-file" name="marker" id="marker">
        </div>

        @if(config('adminSettings.orderable-categories'))
            <div class="form-group">
                <label for="orderable">Orderable?</label>
                @if($category->orderable)
                    <input class="form-check-input" type="checkbox" name="orderable" checked="checked">
                @else
                    <input class="form-check-input" type="checkbox" name="orderable">
                @endif
            </div>
        @endif

        <hr>
        <h4>Specifications (Click to Select)</h4>
        <div class="specs">
            @foreach($specs as $spec)
                <div class="specification" data-id="{{$spec->id}}" data-name="{{$spec->name}}">
                    <strong>Name: </strong> {{$spec->name}}
                    <br>
                    <strong>Type: </strong> {{$spec->type}}
                    <br>
                    <strong>Options: </strong><br>
                    @foreach ( json_decode($spec->options) as $tag)
                        <span class="optionData">{{$tag->value}}</span>
                    @endforeach
                    <br><strong class="clearfix">Default: </strong><br>
                    <input type="text" class="form-control default" />
                    <br>
                    @if($spec->required != true)
                        <div class="btn btn-success addSpec">Select</div>
                    @endif
                </div>
            @endforeach
        </div>
        <input type="hidden" name="specifications" id="specifications" value='[{"id":0,"name":"","defaultVal":""}]'>

        <br style="clear:both;" />
        <br>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
        <br> <br>
        @include('layouts.errors')

    </form>

    <script>
        let jsonData = {!! $category->specifications !!}
        $(document).ready(function() {
            $('div.specification').each(function() {
                let x = false;
                let elmID = $(this).data('id');
                let thisElement = $(this);
                jsonData.forEach(function(elm) {
                    if(elm.id === elmID) {
                        $(thisElement).addClass('active');
                        $('input', thisElement).val(elm.defaultVal);
                        return;
                    }
                });
            });
            $('div.addSpec').on('click', function() {
                let elm = $(this).parent();
                $(elm).toggleClass('active');
                $('#specifications').val(getSpecs());
            });

            $('#submit').submit(function() {
                try {
                    let val = getSpecs();
                    if(val) {
                        $('#specifications').val(getSpecs());
                    }
                    else {
                        alert("Selected Specifications must have a value");
                        return false;
                    }
                }
                catch(err) {
                    return false;
                }
            });

        });

        function getSpecs() {
            let obj = [];
            let error = false;
            $('div.specification').each(function() {
                if($(this).hasClass("active")) {
                    let name = $(this).data("name");
                    let id = $(this).data("id");
                    let thisElm = $(this);
                    let defaultVal = $('input.default', thisElm).val();
                    let item = {};
                    if(defaultVal === "" || defaultVal === null) {
                        error = true;
                    }
                    item["id"] = id;
                    item["name"] = name;
                    item["defaultVal"] = defaultVal;
                    obj.push(item);
                }
            });
            if(error) {
                return false;
            }
            return JSON.stringify(obj);
        }
    </script>
@stop