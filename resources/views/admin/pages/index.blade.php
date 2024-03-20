@extends("lightcms::admin.layout")

@section("content")

    <h4>Pages </h4>
    @foreach($pages as $page)
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
                        <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach

        </tbody>
      </table>
    @endforeach
@endsection
