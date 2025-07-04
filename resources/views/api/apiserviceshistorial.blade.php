@include('layouts.header')
<!-- BEGIN #content -->
<div id="content" class="app-content">
    <div class="border-0 card">
        <div class="panel">
            <div class="panel-heading bg-green-700 text-white strong">Shopping</div>
        </div>
        <div class="p-3 tab-content">
            <div class="tab-pane fade show active" id="allTab">

                <div class="mx-auto col-4">
                    <button class="btn btn-info" type="button" onclick="ComprarMembresia()">Comprar
                        Membresía</button>
                </div>
            </div>
            <!-- END input-group -->

            <!-- BEGIN table -->
            <div class="mb-3 table-responsive">
                <table class="table mb-0 align-middle table-hover table-panel text-nowrap">
                    <thead>
                        <tr>
                            <th>IP</th>
                            <th>Nombre de Servicio</th>
                            <th>Descripcion</th>
                            <th>Costo</th>
                            <th>Fecha</th>
                            <th>Sync IP</th>
                            <th>Renew IP</th>

                        </tr>
                    </thead>

                    <tbody id="filtradosms">
                        @foreach (App\Models\IP::all() as $ip)
                        @if($ip->user_id == Auth::user()->id)
                        <tr>
                            <td>{{$ip->ip}}</td>
                            <td>{{$ip->nombre_servicio}}</td>
                            <td>{{$ip->descripcion_servicio}}</td>
                            <td>$ {{$ip->costo}}</td>
                            <td>   @php
                                $fechaInicio = \Carbon\Carbon::parse($ip->fecha_inicio);
                                $fechaFinal = \Carbon\Carbon::parse($ip->fecha_final);

                                $diferencia = $fechaInicio->diff($fechaFinal);

                                $anios = $diferencia->y;
                                $meses = $diferencia->m;
                                $dias = $diferencia->d;
                                @endphp

                          {{  $anios }} año  {{ $meses }} meses, {{ $dias }} días</td>

                            <td><a href="/resetipAutoremove/{{base64_encode($ip->id)}}" class="btn btn-danger"
                                    type="button">Reset
                                    IP</a></td>
                            <td><button class="btn btn-info" type="button" onclick="renewIp()">Renew
                                    IP</button></td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END table -->
            <div class="d-md-flex align-items-center">


            </div>
        </div>
    </div>
</div>
</div>

<!-- END #content -->
<x-modalshow></x-modalshow>
@include('layouts.footer')