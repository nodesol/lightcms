@extends("lightcms::admin.layout")

@section("content")

    <div class="w-100 d-flex justify-content-between mb-3">
        <span class="h4">Pages</span>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">Add Page</button>
    </div>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($pages as $page)
                <tr>
                    <th scope="row">{{$page->id}}</th>
                    <td>{{$page->name}}</td>
                    <td>{{$page->slug}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route("lightcms-admin-pages-edit",$page->id)}}"><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-primary" href="{{route("lightcms-admin-contents-index",$page->id)}}"><i class="fa fa-bars"></i></a>
                    </td>
                </tr>
            @endforeach

        </tbody>
      </table>

      <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Page</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route("lightcms-admin-pages-store")}}">
                    @csrf
                    <div class="form-group mt-2">
                        <label class="fw-bold">Name</label>
                        <input type="text" class="form-control" name="name" value="">
                    </div>
                    <div class="form-group mt-2">
                        <label class="fw-bold">Slug</label>
                        <input type="text" class="form-control" name="slug" value="">
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
