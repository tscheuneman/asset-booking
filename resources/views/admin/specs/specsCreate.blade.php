@extends('layouts.admin')
@section('title')
    Create Specification
@stop
@section('content')
    <h2>Create Specification</h2>
    <hr>
    <form method="POST" action="{{ url('/admin/specification') }}" enctype="multipart/form-data" id="submit">
        {{csrf_field()}}


        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="type">Input Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="select">Select</option>
                <option value="checkbox">Checkbox</option>
                <option value="date">Date</option>
            </select>
        </div>

        <div id="options">
            <p>Add Options (If Applicable)</p>
            <div id="add">+</div>
        </div>

        <div id="optionsList">

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
                let position = $(this).position();
                $('body').append(returnData);
                $('.showData').css("top", position.top + "px").css("left", position.left + "px").fadeIn(150);
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
            let jsonObj = [];
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