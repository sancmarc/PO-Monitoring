<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - PO Monitoring</title>

        @include('partials.header-link')
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary bg-gradient">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">PO Monitoring</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                        @csrf
                                            <div class="form-floating mb-3">
                                            
                                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" autocomplete="Username" autofocus>
                                            <label for="username">{{ __('Username') }}</label>
                                            @error('username')
                                                <span class="text-danger" >
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            </div>
                                            <div class="form-floating mb-3">
                                            
                                            <input id="password" type="password" class="form-control" name="password" autocomplete="current-password">
                                            <label for="password">{{ __('Password') }}</label>
                                            @error('password')
                                                <span class="text-danger" >
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Login') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Need an account contact? MIS 109</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website {{ now()->year }}</div>
                            <div class="text-muted">Developer: <a style="text-decoration: none;" href="https://www.facebook.com/CodeWeb023">CodeWeb</a></div>
                          
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>
