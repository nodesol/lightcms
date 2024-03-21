<!DOCTYPE html>
<html>
    <head>
        <title>{{ config("app.name") }} Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    </head>
    <body style="background: linear-gradient(90deg, {{config("lightcms.colors.0")}} 0%, {{config("lightcms.colors.1")}} 100%);">
        <div class="container-fluid d-flex p-0" style="min-height: 100vh;">
            <div class="row justify-content-center align-self-center w-100">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4 p-4 bg-white rounded" >
                    <h4 class="text-center">{{ config('app.name') }} Login</h4>
                    <hr />
                    <form method="post" action="{{route("lightcms-admin-postlogin")}}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <hr />
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary float-right">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>
