@extends("lightcms::admin.layout")

@section("content")

    <div class="w-100 d-flex justify-content-between mb-3">
        <span class="h4">Contents: {{$page->name}}</span>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">Add Content</button>
    </div>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($page->contents as $content)
                <tr>
                    <th scope="row">{{$content->id}}</th>
                    <td>{{$content->name}}</td>
                    <td>{{$content->type}}</td>
                </tr>
            @endforeach

        </tbody>
      </table>

      <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Content</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route("lightcms-admin-contents-store", $page->id)}}"  enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mt-2">
                        <label class="fw-bold">Name</label>
                        <input type="text" class="form-control" name="name" value="">
                    </div>
                    <div class="form-group mt-2">
                        <label class="fw-bold">Type</label>
                        <select id="content-type" name="type" class="form-control">
                            <option value="text">Text</option>
                            <option value="textarea">Text Area</option>
                            <option value="list">List</option>
                            <option value="objects">Objects</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                    <div id="content-data" class="form-group mt-2">
                        <label class="fw-bold">Value</label>
                        <input type="text" class="form-control" name="value" value="">
                    </div>
                    <hr />
                    <div class="w-100 my-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" value="Save" />
                    </div>
                </form>
            </div>

          </div>
        </div>
      </div>
@endsection

@section("script")
    <script type="text/javascript">
        $(document).ready(function(){
            $("#content-type").change(function(){
                switch($(this).val()) {
                    case "textarea":
                        $("#content-data").html("\
                            <label class=\"fw-bold\">Value</label>\
                            <textarea class=\"form-control\" name=\"value\"></textarea>\
                        ");
                        break;

                        case "list":
                        $("#content-data").html("\
                            <label class=\"fw-bold\">Items</label>\
                            <div class=\"input-group mb-2\">\
                                <input id=\"txt-add\" type=\"text\" class=\"form-control\">\
                                <button type=\"button\" class=\"input-group-text btn btn-success list-add\">\
                                    <i class=\"fa fa-plus\"></i>\
                                </button>\
                            </div>\
                            <ul class=\"list-group\">\
                            </ul>\
                        ");
                        break;
                    case "objects":
                        $("#content-data").html("\
                            <label class=\"fw-bold\">Structure</label>\
                            <div class=\"input-group mb-2\">\
                                <input id=\"txt-add\" type=\"text\" class=\"form-control\">\
                                <button type=\"button\" class=\"input-group-text btn btn-success objects-add\">\
                                    <i class=\"fa fa-plus\"></i>\
                                </button>\
                            </div>\
                            <ul class=\"list-group objects-group\">\
                            </ul>\
                        ");
                        break;
                    case "image":
                        $("#content-data").html("\
                            <label class=\"fw-bold\">Path</label>\
                            <input type=\"file\" class=\"form-control\" name=\"value\">\
                        ");
                        break;
                    default:
                        $("#content-data").html("\
                            <label class=\"fw-bold\">Value</label>\
                            <input type=\"text\" class=\"form-control\" name=\"value\">\
                        ");
                }
            })
            $(document).on('click', '.list-add', function(){
                let data = $("#txt-add").val();
                $("#content-data").children(".list-group").append("\
                    <li class=\"list-group-item  d-flex justify-content-between\">\
                        <div class=\"input-group mb-2\">\
                            <input name=\"value[]\" type=\"text\" class=\"form-control\" value=\"" + data + "\">\
                            <button type=\"button\" class=\"btn btn-danger p-1 list-delete\"><i class=\"fa fa-close fa-xl\"> </i></button>\
                        </div>\
                    </li>\
                ");
                $("#txt-add").val("")
            })
            $(document).on('click', '.list-delete', function(){
                $(this).parents(".list-group-item").remove()
            })
            $(document).on('click', '.objects-add', function(){
                let data = $("#txt-add").val();
                $("#content-data").children(".objects-group").append("\
                    <li class=\"list-group-item  d-flex justify-content-between\">\
                        <div class=\"input-group mb-2\">\
                            <input name=\"value[name][]\" type=\"text\" class=\"form-control\" value=\"" + data + "\">\
                            <select  name=\"value[type][]\" id=\"select-add\" class=\"input-group-text\">\
                                <option value='text'>Text</option>\
                                <option value='textarea'>Text Area</option>\
                            </select>\
                            <button type=\"button\" class=\"btn btn-danger p-1 list-delete\"><i class=\"fa fa-close fa-xl\"> </i></button>\
                        </div>\
                    </li>\
                ");
                $("#txt-add").val("")
            })
        })
    </script>
@endsection
