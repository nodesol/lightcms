<!DOCTYPE html>
<html>
    <head>
        <title>{{ config("app.name") }} CMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container-fluid" style="height: 100vh; background: linear-gradient(90deg, rgba(110,190,67,1) 0%, rgba(19,136,214,1) 100%);">
            <div class="row g-2">
                <div class="col flex-grow-1 p-3 m-2 bg-white rounded" >
                    <ul class="nav">
                        <li class="nav-item h4 flex-grow-1">{{ config("app.name") }}</li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user fa-xl"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{route("lightcms-admin-logout")}}">Logout</a></li>
                                </ul>
                            </div>

                        <li>
                    </ul>
                </div>
            </div>
            <div class="row m-2">
                <div class="col-12 col-md-2 bg-white rounded me-4 p-0" >
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-primary">
                            <a class="list-group-item-action" href="{{route("lightcms-admin-dashboard")}}">Dashboard</a>
                        </li>
                        <li class="list-group-item list-group-item-primary">
                            <a class="list-group-item-action" href="{{route("lightcms-admin-pages-index")}}">Pages</a>
                        </li>
                    </ul>
                </div>
                <div class="col flex-grow-1 p-4 bg-white rounded" >
                    @yield("content")
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @yield("script")
    </body>
</html>
