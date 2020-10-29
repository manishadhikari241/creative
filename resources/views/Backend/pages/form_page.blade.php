@extends('Backend.layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <table class="table">
                <tbody>
                @foreach($data as $key=>$value)
                    <tr style="background-color: {{$value->color}}">
                        <td>
                            <p class="letter_bold">{{$value->users->name}}</p>
                            #{{$value->post_counts->post_count}} of this author
                        </td>
                        <td><p class="letter_bold">{{$value->title}}</p>
                            {{$value->content}}
                            <br>
                            <br>
                            Date: {{$value->created_at}}
                        </td>
                        <td class="d-flex">
                            <a href="javascript: edit({{$value->id}});">Modify</a> &ensp;

                            <a href="javascript:checkDelete({{$value->id}});">Delete</a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div id="editData" class="container" style="background-color: #CFE2F3">
                <form method="post" id="save_form">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="title">Title</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="title" class="form-control" id="title">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="content">Content</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="content" class="form-control" id="content">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="name">Your Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="name" class="form-control" id="name"
                                       aria-describedby="emailHelp">

                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="chooseBackground">Color</label>
                            </div>
                            <div class="col-md-8">
                                <select name="color" class="form-control" id="chooseBackground">
                                    <option disabled selected>Choose Background Color</option>
                                    <option>Yellow</option>
                                    <option>Purple</option>
                                    <option>Green</option>

                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                            </div>
                            <div class="col-md-7">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>


                </form>

            </div>
            {{--<div  class="container" id="editData" style="background-color: blue">--}}

            {{--</div>--}}
        </div>

    </div>

@endsection
@push('scripts')
    <script>
        function checkDelete(id) {
            if (confirm('Are you sure?')) {
                var tempEditUrl = "{{route('test.destroy',':id')}}";
                tempEditUrl = tempEditUrl.replace(':id', id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: tempEditUrl,
                    success: function (response) {

                        window.location = response.route;
                    }
                });
            }
        }

        function edit(id) {
            var tempEditUrl = "{{route('test.edit',':id')}}";
            tempEditUrl = tempEditUrl.replace(':id', id);


            $.ajax({
                type: "GET",
                url: tempEditUrl,
                success: function (response) {
                    $('#editData').replaceWith($('#editData').html(response));
                }
            });
        }

        $(document).ready(function () {
            $('#save_form').on('submit', function (e) {

                e.preventDefault();

                let myForm = document.getElementById('save_form');
                let formData = new FormData(myForm);


                $.ajax({
                    type: 'post',
                    url: '{{ route('test.store') }}',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        window.location = response.route;
                    },
                    error: function (response) {
                        jQuery.each(response.responseJSON.errors, function (key, value) {
                            toastr.warning(value);
                        });
                    }
                });

            });

        });
    </script>
@endpush