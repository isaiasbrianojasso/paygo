@include('layouts.header')
@php $total=0 ;@endphp
<!-- BEGIN #content -->
<div id="content" class="app-content">
    <div class="mb-3 d-flex align-items-center">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Pagos Recibidos</li>
            </ul>
            <h1 class="mb-0 page-header">Todos Los pagos</h1>
        </div>
        <div class="ms-auto">
            <a href="javascript:;" onclick="abrirEnviarSms()"
                class="px-4 btn btn-primary btn-rounded rounded-pill "><svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                    <path
                        d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                    <path
                        d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                </svg> Validar Pago</a>
        </div>
    </div>
    <div class="border-0 card">
        <div class="p-3 tab-content">
            <div class="tab-pane fade show active" id="allTab">
                <!-- BEGIN input-group -->
                <div class="mb-3 input-group">
                    <button class="btn btn-info" type="button" onclick="buscarMensaje()">
                        <i class="fa fa-search opacity-5"></i> Buscar</button>
                    <div class="flex-fill position-relative">
                        <div class="input-group">

                            <input type="text" onchange="buscarMensaje()" name="buscarSms"
                                class="form-control px-35px bg-light"
                                placeholder="Ingresa El Numero Transaccion O El TRX A Buscar" />
                        </div>
                    </div>
                </div>
                <!-- END input-group -->

                <!-- BEGIN table -->
                <div class="mb-3 table-responsive">
                    <table class="table mb-0 align-middle table-hover table-panel text-nowrap">
                        <thead>
                            <tr>
                                <th>Transaccion ID</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Monto</th>
                                <th>Acreditado</th>
                                <th>Fecha</th>

                            </tr>
                        </thead>
                        @php
                        $total = 0;
                       $mensajes  = \App\Models\detalle_transaccion::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();
                        @endphp

                        <tbody id="filtradosms">
                            @foreach ($mensajes as $tabla)
                            <tr onclick='detailMessage(@json($tabla))'>
                                <td><pre class="text-primary">{{ $tabla->trx }}</pre></td>
                                <td>
                                    <pre class="text-primary">{{ $tabla->cuenta_origen }}</pre>
                                </td>
                                <td>
                                    <pre class="text-primary">{{ $tabla->cuenta_destino }}</pre>
                                </td>
                                <td>
                                    <pre class="text-primary">$ {{ $tabla->monto }} {{ strtoupper($tabla->moneda) }}</pre>
                                </td>
                                <td>
                                    @if ($tabla->acreditado)
                                    <span
                                        class="px-2 border rounded badge border-success text-success pt-1 pb-1 fs-12px d-inline-flex align-items-center">
                                        <i class="fa fa-circle fs-9px fa-fw me-1"></i> Success
                                    </span>
                                    @else
                                    <span
                                        class="px-2 border rounded badge border-danger text-danger pt-1 pb-1 fs-12px d-inline-flex align-items-center">
                                        <i class="fa fa-circle fs-9px fa-fw me-1"></i> Failed
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $tabla->created_at->translatedFormat('l j F Y \a \l\a\s H:i') }}
                                    @php $total += $tabla->costo ?? 0; @endphp
                                </td>
                            </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div>

                <!-- END table -->
                <div class="d-md-flex align-items-center">
                    <div class="mb-2 text-center me-md-auto text-md-left mb-md-0">
                        <span id="filtradoCount">{{ $mensajes->count() }}</span> messages
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END #content -->
<!-- BEGIN scroll-top-btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i
        class="fa fa-angle-up"></i></a>
<!-- END scroll-top-btn -->
<x-modalshow></x-modalshow>
</div>
<!-- END #app -->



@include('layouts.footer')
