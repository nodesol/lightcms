@extends("lightcms::admin.layout")

@section("content")
    <h4>Edit Page: {{$page->name}}</h4>
    <form id="edit-form" method="post" action="{{route("lightcms-admin-pages-update", $page->id)}}">
        @csrf
        <input type="hidden" name="_method" value="put" />
        <div class="row gx-4">
            <div class="col-12 my-5">
                <h5>Page Details</h5>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="{{$page->title}}">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>Meta Description</label>
                    <input type="text" class="form-control" name="meta_description" value="{{$page->meta_description}}">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>Meta Keywords</label>
                    <input type="text" class="form-control" name="meta_keywords" value="{{$page->meta_keywords}}">
                </div>
            </div>
            <div class="col-12 my-5">
                <h5>Contents</h5>
            </div>
                @foreach($page->contents as $content)
                    <div class="col-12 col-md-6">
                        @switch($content->type)
                            @case("textarea")
                                <div class="form-group mt-2">
                                    <label class="fw-bold">{{$content->name}}</label>
                                    <textarea class="form-control" name="contents[{{$content->name}}]">{{$content->value}}</textarea>
                                </div>
                                @break
                            @case("list")
                                <div class="form-group mt-2 list-component" data-name="{{$content->name}}">
                                    <label class="fw-bold">{{$content->name}}</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control">
                                        <button type="button" class="input-group-text btn btn-success list-add">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <ul class="list-group">

                                        @foreach($content->value ?? [] as $value)
                                            <li class="list-group-item  d-flex justify-content-between">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" value="{{$value}}">
                                                    <button type="button" class="btn btn-danger p-1 list-delete"><i class="fa fa-close fa-xl"> </i></button>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @break
                            @case("objects")
                                <div class="form-group mt-2 objects-component" data-name="{{$content->name}}" data-objects="{{$content->data}}">
                                    <div class="w-100 d-flex justify-content-between mb-2">
                                        <label class="fw-bold">{{$content->name}}</label>
                                        <button type="button" class="btn btn-success objects-add"><i class="fa fa-plus fa-lg"> </i></button>
                                    </div>
                                    <ul class="list-group">
                                        @foreach($content->value ?? [] as $items)
                                            <li class="list-group-item mb-1">
                                                <div class="w-100 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary p-1 objects-edit"><i class="fa fa-pencil fa-xl"> </i></button> &nbsp;
                                                    <button type="button" class="btn btn-danger p-1 objects-delete"><i class="fa fa-trash fa-xl"> </i></button>
                                                </div>
                                                @foreach($items as $key => $value)
                                                    <span>{{$key}}</span>: <span data-key="{{$key}}" class='objects-value'>{{$value}}</span> <br />
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @break;
                            @default
                                <div class="form-group mt-2">
                                    <label class="fw-bold">{{$content->name}}</label>
                                    <input type="text" class="form-control" name="contents[{{$content->name}}]" value="{{$content->value}}">
                                </div>
                        @endswitch
                    </div>
                @endforeach
            <div class="col-12 d-flex justify-content-end mt-5">
                <button class="btn btn-success btn-save">Save</button>
                <a class="btn btn-link ms-2" href="{{route("lightcms-admin-pages-index")}}">Cancel</a>
            </div>
        </div>
    </form>

    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="objects-form">

                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success objects-modal-submit"  data-bs-dismiss="modal">Save</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section("script")
    <script type="text/javascript">
        $(document).ready(function(){
            $(".list-add").click(function(){
                let data = $(this).parents(".input-group").children(".form-control").val()
                $(this).parents(".list-component").children(".list-group").append("\
                    <li class=\"list-group-item  d-flex justify-content-between\">\
                        <div class=\"input-group mb-2\">\
                            <input type=\"text\" class=\"form-control\" value=\"" + data + "\">\
                            <button type=\"button\" class=\"btn btn-danger p-1 list-delete\"><i class=\"fa fa-close fa-xl\"> </i></button>\
                        </div>\
                    </li>\
                ");
                $(this).parents(".input-group").children(".form-control").val("")
            })

            function objectsModal(e){
                let title = e.parents(".objects-component").data("name");
                values = {};
                if(e.hasClass("objects-edit")) {
                    e.parents(".objects-component").find(".objects-value")
                }
                $("#modal").find(".modal-title").text("Add " + title)
                $("#modal").find(".modal-title").data("name", title)
                if(e.hasClass("objects-edit")) {
                    $("#modal").find(".modal-title").text("Edit " + title)
                    $("#modal").find(".modal-title").data("item", e.parents('.list-group-item'))
                }
                let items = e.parents(".objects-component").data("objects").structure
                let fields = "";
                Object.keys(items).forEach(function(key) {
                    value = ""
                    if(e.hasClass("objects-edit")) {
                        e.parents(".list-group-item").find(".objects-value").each(function(item){
                            if($(this).data("key") == key) {
                                value = $(this).text()
                            }
                        })
                    }
                    switch(items[key]) {
                        case "textarea":
                            fields += "\
                                <div class=\"form-group mt-2\">\
                                    <label class=\"fw-bold\">" + key + "</label>\
                                    <textarea class=\"form-control\" name=\"" + key + "\">" + value + "</textarea>\
                                </div>\
                            "
                            break;
                        default:
                            fields += "\
                                <div class=\"form-group mt-2\">\
                                    <label class=\"fw-bold\">" + key + "</label>\
                                    <input type=\"text\" class=\"form-control\" name=\"" + key + "\" value=\"" + value + "\">\
                                </div>\
                            "
                    }
                })
                $("#objects-form").html(fields)
                const modal = new bootstrap.Modal("#modal")
                modal.show();
            }

            $(".objects-add").click(function(){
                objectsModal($(this))
            })

            $(document).on('click', '.objects-edit', function(){
                objectsModal($(this))
            })

            function addObjects(form, name) {
                let html = "\
                    <li class=\"list-group-item mb-1\">\
                        <div class=\"w-100 d-flex justify-content-end\">\
                            <button type=\"button\" class=\"btn btn-primary p-1 objects-edit\"><i class=\"fa fa-pencil fa-xl\"> </i></button> &nbsp;\
                            <button type=\"button\" class=\"btn btn-danger p-1 objects-delete\"><i class=\"fa fa-close fa-xl\"> </i></button>\
                        \</div>\
                "
                form.serializeArray().forEach(function(item){
                    html += "\
                        <span>" + item.name + "</span>: <span  data-key='" + item.name + "' class='objects-value'>" + item.value + "</span> <br />\
                    "
                })
                html += "</li>"
                $(".objects-component").each(function(index, item){

                    if($(item).data("name") == name) {
                        $(item).find(".list-group").append(html)
                    } else {
                        console.log(item)
                    }
                })
            }

            function editObjects(data, item) {
                console.log(data)
                data.forEach(function(d){
                    item.children(".objects-value").each(function(){
                        if(d.name == $(this).data("key")) {
                            $(this).text(d.value)
                        }
                    })
                })
                //console.log(item)
            }

            $(".objects-modal-submit").click(function(){
                let form = $("#objects-form");
                if($(this).parents("#modal").find(".modal-title").data("item")) {
                    editObjects(form.serializeArray(), $(this).parents("#modal").find(".modal-title").data("item"))
                } else {
                    addObjects(form, $(this).parents("#modal").find(".modal-title").data("name"))
                }
            })

            $(document).on('click', '.list-delete', function(){
                $(this).parents(".list-group-item").remove()
            })

            $(document).on('click', '.objects-delete', function(){
                $(this).parents(".list-group-item").remove()
            })

            $(document).on('click', '.btn-save', function(e){
                e.preventDefault();
                let form = $("#edit-form");
                $(".list-component").each(function(){
                    let items = "[";
                    $(this).find(".list-group-item").each(function(){
                        items += "\"" + $(this).find(".form-control").val() + "\","
                    })
                    items = items.substr(0, items.length - 1)
                    items += "]"
                    form.append("<input type=hidden name=\"contents[" + $(this).data("name") + "]\" value='" + items + "' />")

                });
                $(".objects-component").each(function(){
                    let items = "[";
                    $(this).find(".list-group-item").each(function(){
                        items += "{"
                        $(this).find(".objects-value").each(function(){
                            items += "\"" + $(this).data("key") + "\": \"" + $(this).text() + "\","
                        })
                        items = items.substr(0, items.length - 1)
                        items += "},"
                    })
                    items = items.substr(0, items.length - 1)
                    items += "]"
                    form.append("<input type=hidden name=\"contents[" + $(this).data("name") + "]\" value='" + items + "' />")

                });
                console.log(form)

                form.submit();
            })
        })
    </script>
@endsection
