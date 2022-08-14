<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles -->
    <link href="{{ asset('styles.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login') && get_env('HABILITAR_LOGIN') == true)
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                Laravel
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                        Cadastar Taxa
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        Operadoras
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                        type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                        Taxas
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane"
                        type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">
                        Cadastrar Operadora
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">
                    <form id="cadastrarTaxa">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="mt-3 mb-3">
                            <label for="tarifaInput" class="form-label">Informe o valor da tarifa a ser
                                cadastrada:</label>
                            <input type="text" class="form-control" id="tarifaInput" name="tarifa"
                                aria-describedby="tarifaInput" required>
                        </div>
                        <div class="mb-3">
                            <label for="operadoraInput" class="form-label">Informe o código da operadora para a
                                tarifa:</label>
                            <div id="operadoraInputAux" class="form-text">Exemplos: OP01, OP02, OP03...</div>
                            <input type="text" class="form-control" id="operadoraInput" name="operadora"
                                aria-describedby="operadoraInput" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operators as $index => $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ $item->code }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                    tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Taxa</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fares as $index => $item)
                                <tr>
                                    <th scope="row">{{ $item->id }}</th>
                                    <td>{{ number_format($item->value, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab"
                    tabindex="0">
                    <form id="cadastrarOperadora">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="mt-3 mb-3">
                            <label for="operadoraInput" class="form-label">Informe o código da Operadora:</label>
                            <input type="text" class="form-control" id="operadoraInput" name="operadora"
                                aria-describedby="operadoraInput" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    // Ajax para Cadastrar Taxa
    $("#cadastrarTaxa").submit(function(e) {

        e.preventDefault(); // Impedir envio do form

        var form = $(this);
        var url = '{{ route('cadastrar.taxa') }}';

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // Serializar dados do form
            success: function(response) {
                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    confirmButtonText: 'Ok'
                })
            }
        });

    });

    // Ajax para Cadastrar Operadora
    $("#cadastrarOperadora").submit(function(e) {

        e.preventDefault(); // Impedir envio do form

        var form = $(this);
        var url = '{{ route('cadastrar.operadora') }}';

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // Serializar dados do form
            success: function(response) {
                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                    confirmButtonText: 'Ok'
                })
            }
        });

    });
</script>

</html>
