@extends('layouts.admin')
@section('title')
    Edit User
@stop
@section('content')
    <h2>Edit User</h2>
    <hr>
    @if(Session::has('flash_deleted'))
        <div class="alert alert-warning"><span class="glyphicon glyphicon-remove-circle"></span><em> {!! session('flash_deleted') !!}</em></div>
    @endif
    @if(Session::has('flash_created'))
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_created') !!}</em></div>
    @endif

    <form method="POST" action="{{ url('/admin/user/users') }}" id="submit">
        {{csrf_field()}}
        <input type="hidden" class="form-control" id="username" name="username" value="{{$user->username}}">

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{$user->first_name}}" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{$user->last_name}}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" required>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <input type="text" class="form-control" id="department" name="department" value="{{$user->department}}" required readonly>
        </div>

        <div class="form-group">
            <label for="agency_org">Cost Center</label>
            <input type="text" class="form-control" id="agency_org" name="agency_org" value="{{$user->agency_org}}" required>
        </div>

        <hr>

        <h3>Assigned Departments</h3>

        <div class="form-group">
            <label for="category">Department</label>
            <select class="form-control" id="department" name="department">
                <option value="">Select</option>
                @foreach($dept as $theDept)
                    <option value="{{$theDept->id}}">{{$theDept->name}}</option>
                @endforeach
            </select>
        </div>

        <div id="deptHolder">
            @foreach($user->departments as $dept)
                <div data-id="{{$dept->department_id}}" class="deptHolder">
                    <strong style="font-size:1.3em;">{{$dept->department->name}}</strong>
                    <br class="clear" />
                    <br />
                    <a data-id="{{$dept->id}}" class="deleteUserDept deleteAction" href="#">
                        <span class="glyphicon glyphicon-trash"> </span> Delete
                    </a>


                </div>
            @endforeach
        </div>

        <br class="clear" />
        <br>
        <input type="hidden" name="theDepartments" id="theDepartments" />
        <button type="submit" class="btn btn-primary">Submit</button>

        @include('layouts.errors')
    </form>

    <script>
        $(document).ready(function() {
            $('select#department').on('change', function() {
                addDept();
            });

            $('a.deleteUserDept').on('click', function() {
                let id = $(this).data('id');
                deleteUserDept(id, $(this).parent());
            });
        });

        function addDept() {
            let value = $('select#department').val();
            let text = $('select#department option:selected').text();

            if(value !== '') {
                createElm(text, value);
            }
        }

        function createElm(text, val) {
            let cont = true;
            $('.deptHolder').each(function() {
                if($(this).data('id') === val) {
                    cont = false;
                    return false;
                }
            });
            if(cont) {
                let returnVal = '<div data-id="'+val+'" class="deptHolder">' +
                    '<strong>' + text + '</strong>' +
                    '</div>';

                $('#deptHolder').append(returnVal);
            }
        }

        $('#submit').submit(function() {
            let obj = [];
            try {
                $('#deptHolder .deptHolder').each(function() {
                    let elm = $(this);
                    let item = {};
                    item['id'] = $(this).data('id');
                    obj.push(item);
                });

                if(obj.length < 1) {
                    alert("You must assign a department to this user");
                    return false;
                }

                let returnObj = JSON.stringify(obj);
                $('#theDepartments').val(returnObj);
            }
            catch(err) {
                return false;
            }

        });

        function deleteUserDept(id, elm) {
            $.ajax({
                method: "POST",
                url: "/admin/users/departments/delete",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': id,
                }
            }).done(function( msg ) {
                let jsonData = JSON.parse(msg);
                console.log(jsonData);
                if(jsonData.status === true) {
                    elm.remove();
                }
                else {
                    alert(jsonData.message)
                }
            });
        }
    </script>
@stop