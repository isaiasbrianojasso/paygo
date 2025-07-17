@include('layouts.header')

<!-- BEGIN #content -->
<div id="content" class="app-content">
    <div class="card border-0">
        <div class="panel">
            <div class="panel-heading bg-blue-700 text-white strong">Usuarios</div>
        </div>
        <div class="tab-content p-3">
            <div class="tab-pane fade show active" id="allTab">
                <a href="" class="btn btn-success">Agregar Usuario</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Tiempo</th>

                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(App\Models\User::all() as $user)
                        <tr>
                            <td>{{ $user->name}}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $fechaInicio = \Carbon\Carbon::parse($user->fecha_inicio);
                                    $fechaFinal = \Carbon\Carbon::parse($user->fecha_final);
                                    $diferencia = $fechaInicio->diff($fechaFinal);
                                    $meses = $diferencia->format('%m');
                                    $dias = $diferencia->format('%d');
                                @endphp
                                {{ $meses }} meses, {{ $dias }} días
                            </td>
                            <td>
                                <div style="width:130px;">
                                    <a class="btn btn-icon btn-circle btn-info"
                                        href="/admin/user/?token={{ base64_encode($user->id) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
                                    <a class="btn btn-icon btn-circle btn-warning"
                                        href="/accesoSecure/usersSecure/creditos/?id={{ $user->id }}">
                                        <i class="ace-icon fa fa-usd bigger-120"></i>
                                    </a>
                                    <a class="btn btn-icon btn-circle btn-success"
                                        href="/accesoSecure/dashboard/?user={{ $user->id }}" target="_blank">
                                        <i class="ace-icon fa fa-line-chart bigger-120"></i>
                                    </a>
                                    <a class="btn btn-icon btn-circle btn-danger " href="?del=88">
                                        <i class="ace-icon fa fa-trash-o bigger-120 text-white"></i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            @include('layouts.footer')
