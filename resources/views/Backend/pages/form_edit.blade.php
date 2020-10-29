<form method="post" id="edit_form">
    @csrf
    <div class="form-group">
        <div class="row">
            <div class="col-md-2">
                <label for="title">Title</label>
            </div>
            <div class="col-md-8">
                <input type="text" value="{{$editData->title}}" name="title" class="form-control" id="title">

            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-2">
                <label for="content">Content</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="content" value="{{$editData->content}}" class="form-control" id="content">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-2">
                <label for="name">Your Name</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="name" class="form-control" id="name" value="{{$editData->users->name}}"
                       aria-describedby="emailHelp">

            </div>
        </div>

    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-2">
                <label for="color">Color</label>
            </div>
            <div class="col-md-8">
                <select name="color" class="form-control" id="color">
                    <option @if($editData->color == 'Yellow') selected @endif>Yellow</option>
                    <option @if($editData->color == 'Purple') selected @endif>Purple</option>
                    <option @if($editData->color == 'Green') selected @endif>Green</option>

                </select>
            </div>
        </div>


    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-5">
            </div>
            <div class="col-md-7">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>


</form>

<script>
    // $.fn.serializeObject = function () {
    //     var o = {};
    //     var a = this.serializeArray();
    //     $.each(a, function () {
    //         if (o[this.name] !== undefined) {
    //             if (!o[this.name].push) {
    //                 o[this.name] = [o[this.name]];
    //             }
    //             o[this.name].push(this.value || '');
    //         } else {
    //             o[this.name] = this.value || '';
    //         }
    //     });
    //     return o;
    // };
    $('#edit_form').on('submit', function (e) {

        e.preventDefault();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var color = $('#color').val();
        var title = $('#title').val();
        var content = $('#content').val();
        var name = $('#name').val();
        var id = "{{$editData->id}}";
        var tempEditUrl = "{{route('test.update',':id')}}";
        tempEditUrl = tempEditUrl.replace(':id', id);

        console.log(title);
        $.ajax({
            type: 'PUT',
            url: tempEditUrl,
            data: {
                name: name,
                color: color,
                content: content,
                title: title
            },


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

</script>