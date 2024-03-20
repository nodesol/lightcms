@extends("lightcms::admin.layout")

@section("content")
    <h4>Edit Page: {{$page->name}}</h4>
    <form id="edit-form" method="post" action="{{route("lightcms-admin-pages-update", $page->id)}}">
        @csrf
        <input type="hidden" name="_method" value="put" />
        <div class="row gx-4">
            <div class="col-12 col-md-6">
                <h5>Page Details</h5>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="{{$page->title}}">
                </div>
                <div class="form-group">
                    <label>Meta Description</label>
                    <input type="text" class="form-control" name="meta_description" value="{{$page->meta_description}}">
                </div>
                <div class="form-group">
                    <label>Meta Keywords</label>
                    <input type="text" class="form-control" name="meta_keywords" value="{{$page->meta_keywords}}">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h5>Contents</h5>
                @foreach($page->contents as $content)
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
                                            <span>{{$value}}</span>
                                            <button type="button" class="btn btn-danger p-1 list-delete"><i class="fa fa-close fa-xl"> </i></button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @break
                        @case("objects")
                            <div class="form-group mt-2 objects-component" data-name="{{$content->name}}">
                                <div class="w-100 d-flex justify-content-between mb-2">
                                    <label class="fw-bold">{{$content->name}}</label>
                                    <button type="button" class="btn btn-success objects-add" data-objects="{{$content->data}}"><i class="fa fa-plus fa-lg"> </i></button>
                                </div>
                                <ul class="list-group">
                                    @foreach($content->value ?? [] as $items)
                                        <li class="list-group-item mb-1">
                                            <div class="w-100 d-flex justify-content-end">
                                                <button type="button" class="btn btn-danger p-1 objects-delete"><i class="fa fa-close fa-xl"> </i></button>
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
                @endforeach
            </div>
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
                <form id="objects-add-form">

                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success objects-modal-add"  data-bs-dismiss="modal">Save</button>
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
                        <span>" + data + "</span>\
                        <button class=\"btn btn-danger p-1 list-delete\"><i class=\"fa fa-close fa-xl\"> </i></button>\
                    </li>\
                ");
                $(this).parents(".input-group").children(".form-control").val("")
            })

            $(".objects-add").click(function(){
                let title = $(this).parents(".objects-component").data("name");
                $("#modal").find(".modal-title").text("Add " + title)
                $("#modal").find(".modal-title").data("name", title)
                let items = $(this).data("objects").structure
                let fields = "";
                Object.keys(items).forEach(function(key) {
                    switch(items[key]) {
                        case "textarea":
                            fields += "\
                                <div class=\"form-group mt-2\">\
                                    <label class=\"fw-bold\">" + key + "</label>\
                                    <textarea class=\"form-control\" name=\"" + key + "\"></textarea>\
                                </div>\
                            "
                            break;
                        default:
                            fields += "\
                                <div class=\"form-group mt-2\">\
                                    <label class=\"fw-bold\">" + key + "</label>\
                                    <input type=\"text\" class=\"form-control\" name=\"" + key + "\" value=\"\">\
                                </div>\
                            "
                    }
                })
                $("#objects-add-form").html(fields)
                const modal = new bootstrap.Modal("#modal")
                modal.show();
            })

            $(".objects-modal-add").click(function(){
                let form = $("#objects-add-form");
                let html = "\
                    <li class=\"list-group-item mb-1\">\
                        <div class=\"w-100 d-flex justify-content-end\">\
                            \<button type=\"button\" class=\"btn btn-danger p-1 objects-delete\"><i class=\"fa fa-close fa-xl\"> </i></button>\
                        \</div>\
                "
                form.serializeArray().forEach(function(item){
                    html += "\
                        <span>" + item.name + "</span>: <span  data-key='" + item.name + "' class='objects-value'>" + item.value + "</span> <br />\
                    "
                })
                html += "</li>"
                let name = $(this).parents("#modal").find(".modal-title").data("name")
                $(".objects-component").each(function(index, item){

                    if($(item).data("name") == name) {
                        $(item).find(".list-group").append(html)
                    } else {
                        console.log(item)
                    }
                })


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
                        items += "\"" + $(this).children("span").text() + "\","
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
