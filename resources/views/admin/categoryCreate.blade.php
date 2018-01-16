@extends('layouts.admin')
@section('title')
    Create Category
@stop
@section('content')
    <h2>Create Category</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/category') }}">
        {{csrf_field()}}


        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="6"></textarea>
        </div>

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
                    <br><strong>Default: </strong><br>
                    <input type="text" class="form-control default" />
                    <br>
                    <div class="btn btn-success addSpec">Select</div>
                </div>
            @endforeach
        </div>

        <input type="hidden" name="specifications" id="specifications" value='[{"id":0,"name":"","defaultVal":""}]'>

        <br style="clear:both;" />
        <br>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')

    </form>

    <script>
        $(document).ready(function() {
            $('div.addSpec').on('click', function() {
                let elm = $(this).parent();
                $(elm).toggleClass('active');
                $('#specifications').val(getSpecs());
            });
        });

        function getSpecs() {
            let obj = [];
            $('div.specification').each(function() {
                if($(this).hasClass("active")) {
                    let name = $(this).data("name");
                    let id = $(this).data("id");
                    let thisElm = $(this);
                    let defaultVal = $('input.default', thisElm).val();
                    let item = {};

                    item["id"] = id;
                    item["name"] = name;
                    item["defaultVal"] = defaultVal;
                    obj.push(item);
                }
            });
            return JSON.stringify(obj);
        }
    </script>
@stop