@extends('layouts.admin')
@section('title')
    Edit Specification
@stop
@section('content')
    <h2>Edit {{$spec->name}}</h2>
    <hr>
    <form id="submit" method="POST" action="{{ url('/admin/specification') }}/{{$spec->id}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$spec->id}}">

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{$spec->name}}">
        </div>

        <div class="form-group">
            <label for="type">Input Type</label>
            <select class="form-control" id="type" name="type" required>
                @if($spec->type === 'text')
                    <option value="text" selected>Text</option>
                 @else
                    <option value="text">Text</option>
                @endif

                @if($spec->type === 'number')
                    <option value="number" selected>Number</option>
                @else
                     <option value="number">Number</option>
                @endif

                @if($spec->type === 'select')
                   <option value="select" selected>Select</option>
                @else
                   <option value="select">Select</option>
                @endif

                 @if($spec->type === 'checkbox')
                    <option value="checkbox" selected>Checkbox</option>
                 @else
                    <option value="checkbox">Checkbox</option>
                 @endif

                  @if($spec->type === 'checkbox')
                     <option value="date" selected>Date</option>
                  @else
                      <option value="date">Date</option>
                  @endif
            </select>
        </div>

        <div id="options">
            <p>Add Options (If Applicable)</p>
            <div id="add">+</div>
        </div>

        <div id="optionsList">
            @foreach ( json_decode($spec->options) as $tag)
                @if($tag->label !== '' && $tag->label  !== "")
                    <div class="returnEntry" data-label="{{$tag->label}}" data-value="{{$tag->value}}">
                        <div class="deleteEntry" onClick="deleteEntry(this)">X</div>
                     <strong>Label: </strong> {{$tag->label}}
                        <br>
                         <strong>Value: </strong>{{$tag->value}}
                    </div>
                @endif
            @endforeach
        </div>
        <br style="clear:both;" />

        <hr>
        <input type="hidden" name="jsonOptions" id="jsonOptions" value='[{"value":"","label":""}]'>
        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')

    </form>
    <script>
        $(document).ready(function() {
            let returnData = '<div class="showData" style="display:none">' +
                '<div id="closeOverlay" onClick="removeEntry()">X</div>'+
                '<label for="chooseLabel"> Label </label>'+
                '<br>'+
                '<input name="chooseLabel" id="chooseLabel" />' +
                '<br><br>'+
                '<label for="chooseValue"> Value </label>'+
                '<br>'+
                '<input name="chooseValue" id="chooseValue" />' +
                '<br><br>' +
                '<button onClick="submitOption(this)">Submit</button>' +
                '</div>';
            $('#add').on('click', function() {
                var position = $(this).position();
                $('body').append(returnData);
                $('.showData').css("top", position.top + "px").css("left", position.left + "px").fadeIn(150);
            });

            $('#submit').submit(function() {
                try {
                    let data = fillData();
                    $('#jsonOptions').val(data);
                }
                catch(err) {
                    return false;
                }
            });

        });
        function removeEntry() {
            $('.showData').fadeOut(500, function() {
                $(this).remove();
            })
        }
        function deleteEntry(elm) {
            let parent = $(elm).parent();
            $(parent).fadeOut(500, function() {
                $(this).remove();
            });
        }
        function submitOption(elm) {
            let label = $('input#chooseLabel').val();
            let value = $('input#chooseValue').val();
            if(label !== "" && value !== "") {
                let returnEntry = '<div class="returnEntry" data-label="'+label+'" data-value="'+value+'">' +
                    '<div class="deleteEntry" onClick="deleteEntry(this)">X</div>'+
                    '<strong>Label: </strong>'+ label +
                    '<br>'+
                    '<strong>Value: </strong>'+ value +
                    '</div>';
                $('#optionsList').append(returnEntry);

                let data = fillData();
                $('#jsonOptions').val(data);

                $(elm).parent().remove();
            }
            else {
                alert("Ensure all fields are filled in");
            }
        }

        function fillData() {
            jsonObj = [];
            $('.returnEntry').each(function() {
                let value = $(this).attr("data-value");
                let label = $(this).attr("data-label");
                item = {}

                item["value"] = value;
                item["label"] = label;
                jsonObj.push(item);
            });
            return JSON.stringify(jsonObj);
        }
    </script>
@stop