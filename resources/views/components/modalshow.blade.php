<!-- #Detail SMS -->
<div class="modal fade" id="detailSMS">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles Del SMS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 text-center">
                        <h3 id="numeroDetail"></h3>
                    </div>

                </div>
                <div class="row">
                    <div class="mb-3">
                        <div class="row">
                            <div class="text-center col-6">
                                Sender ID: <span id="apiDetail"></span><br>
                                <p id="namesenderDetail" class="text-center"></p>
                            </div>
                            <div class="text-center col-6">
                                <span id="statusDetail"></span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="mb-3">

                        <h4 class="text-center">Mensaje Enviado</h4><br>
                        <p id="msjDetail"></p>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>

            </div>
        </div>
    </div>
</div>

<!-- #Enviar Nuevo SMS -->
<div class="modal fade" id="enviarSms">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enviar Nuevo SMS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" onkeypress="handle(event)">
                <div class="row">
                    <div class="mb-3">
                        <label for="" class="form-label"><i class="fas fa-mobile-screen-button fa-lg"></i>
                            Numero Telefonico</label>
                        <input type="number" class="form-control form-control-lg" name="Numero_telefono">
                        <small class="form-text text-danger" id="errorNumber"></small>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="my-select">
                                <i class="fas fa-apple-whole fa-lg"></i> Selecciona Un Sender
                            </label>

                            <select class="form-control form-control-lg" name="senderSms" id="senderSms">
                                <option value="">-- Selecciona --</option> {{-- opción por defecto --}}
                                @foreach (App\Models\Sender::all() as $sender)
                                <option value="{{ $sender->sender_id }}">
                                    {{ $sender->sender_name }} — costo: [ ${{ $sender->costo }} C ]
                                </option>
                                @endforeach
                            </select>

                            <span class="text-danger" id="errorSender" hidden></span>
                        </div>

                    </div>

                    <div class="row">
                        <button type="button" onclick="generarWhatsappModal()" class="btn btn-warning">Generar
                            registro whatsapp</button>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label for="" class="form-label"><i class="fas fa-comment-sms fa-2x"></i> Ingresa
                                El Mensaje</label>
                            <textarea class="form-control" maxlength="158" name="mensaje_texto" rows="4"
                                onkeyup="contarTexto()"
                                placeholder="Ingresa Aqui Tu Texto No Mayor A 158 Caracteres"></textarea>
                            <span class="text-danger" id="errorMsj" hidden></span>
                            <br>
                            <p id="mostrarContar"></p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                <button class="btn btn-primary" type="button" onclick="enviarSms()">Enviar</button>
            </div>
        </div>
    </div>
</div>
<!-- #Nuevo Proveedor -->
<div class="modal fade" id="mostarComprarAutoremove">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Comprar</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="my-select"> Selecciona Tu Mejor
                                Opcion</label>
                            <select class="form-control form-control-lg" name="costo">
                                <option value="remove_apple_6m">Apple Autoremove 6 meses --- $40</option>
                                <option value="remove_apple_1y">Apple Autoremove 1 año --- $75</option>
                                <option value="check_fmi_6m">Check FMI 6 meses --- $50</option>
                                <option value="check_fmi_1m">Check FMI 1 mes --- $15</option>
                                <option value="google_clean_6m">Google Clean Domain 6 meses --- $50</option>
                                <option value="google_clean_1m">Google Clean Domain 1 mes --- $15</option>
                                <option value="google_maps_6m">Google Maps 6 meses --- $45</option>
                                <option value="google_maps_1m">Google Maps 1 mes --- $15</option>
                                <option value="smtp_6m">Email SMTP 6 meses --- $45</option>
                                <option value="smtp_1m">Email SMTP 1 mes --- $15</option>
                                <option value="xiaomi_remove_6m">Xiaomi Autoremove 6 meses --- $40</option>
                                <option value="xiaomi_remove_1y">Xiaomi Autoremove 1 año --- $75</option>

                                <option value="check_fmi_1m">API Model Check SERIAL/IMEI --- $0</option>

                            </select>
                            <span class="text-danger" id="errorSender" hidden></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-danger" onclick="solicitarMembresia()">Solicitar</a>
                        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="smsModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviar Whatsapp</h5>

            </div>
            <div class="alert alert-info" id="alertaa2" hidden>
                <div class="text-white" id="cls2"></div>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="csrf" name="_token" value="SHDip1AU1sxs31PhTevPmqGVTb12qt7wdWurC0VY" />

                    <div class="mb-2 row">

                        <div class="col-8">
                            <div class="form-group">
                                <label for="numerosms">Numero</label>
                                <div class="input-group input-group-alternative">
                                    <input class="form-control" autocomplete="nope" id="numerosmsW" type="text"
                                        name="numeroW" placeholder="Numero...">


                                </div>


                            </div>

                        </div>

                    </div>

                    <div class="mb-2 row">

                        <div class="col-8">
                            <div class="form-group">
                                <label for="numerosms">Chat_id</label>
                                <div class="input-group input-group-alternative">
                                    <input class="form-control" autocomplete="nope" id="chat_id" type="text"
                                        name="chat_id" placeholder="Chat_id...">


                                </div>


                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="sender">Seleccione Un Idioma: </label>
                            <select name="idioma" id="idiomaWhatsapp" class="form-control">

                                <option value="1">Español</option>
                                <option value="2">Ingles</option>

                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="generarWhatsapp()" class="btn bg-gradient-primary">Send
                    message</button>
            </div>
        </div>
    </div>
</div>