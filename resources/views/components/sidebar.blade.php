@php
$url = url('/');
$current = url()->current();
@endphp
@php
use App\Models\IP;
$apple_remove = IP::where( 'service', 'apple_remove')->where('user_id',Auth::User()->id)->first();
$google = IP::where( 'service', 'google_maps')->where('user_id',Auth::User()->id)->first();
@endphp
<!-- BEGIN #sidebar -->
<div id="sidebar" class="bg-white app-sidebar" data-disable-slide-animation="true">
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <div class="menu">
            <!-- Perfil -->
            <div class="menu-profile" style="background-color: #f8f9fa;">
                <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile"
                    data-target="#appSidebarProfileMenu">
                    <img src="assets/img/paygo.png" style="width:100%" alt="">

                </a>
            </div>

            <!-- Perfil desplegable -->
            <div id="appSidebarProfileMenu" class="collapse">
                <div class="menu-item pt-5px">
                    <a href="{{ $url }}/logout" class="menu-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="menu-icon"><i class="fa fa-lock"></i></div>
                        <div class="menu-text">LOGOUT</div>
                    </a>
                    <form id="logout-form" action="https://{{ $url }}/logout" method="POST" class="d-none">@csrf</form>
                </div>
                <div class="menu-item pt-5px">
                    <a href="#" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-usd"></i></div>
                        <div class="menu-text">ADD <i class="fas fa-user-friends "></i> ${{ Auth::user()->creditos }}
                        </div>
                    </a>
                </div>
                <div class="m-0 menu-divider"></div>
            </div>
            <div class="menu-item @if(preg_match('/\bdashboard\b/i', $current)) active @endif">
                <a href="/dashboard" class="menu-link">
                    <div class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-house-door" viewBox="0 0 16 16">
                            <path
                                d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 2 7.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7.5a.5.5 0 0 0-.146-.354l-6-6zM13 14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7.707l5-5 5 5V14z" />
                            <path d="M7 13.5V10h2v3.5a.5.5 0 0 1-1 0V11H8v2.5a.5.5 0 0 1-1 0z" />
                        </svg>
                    </div>
                    <div class="menu-text">Home</div>
                </a>
            </div>
            <!-- Panel principal -->
            <div class="bg-white menu-header text-dark">CUSTOMER SERVICES</div>
            <div class="menu-item @if(preg_match('/\bpayment_check\b/i', $current)) active @endif">
                <a href="/payment_check" class="menu-link">
                    <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="currentColor" class="bi bi-currency-bitcoin" viewBox="0 0 16 16">
                            <path
                                d="M5.5 13v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.5v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.084c1.992 0 3.416-1.033 3.416-2.82 0-1.502-1.007-2.323-2.186-2.44v-.088c.97-.242 1.683-.974 1.683-2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a.25.25 0 0 0-.25-.25h-1a.25.25 0 0 0-.25.25V3h-.573V1.75a.25.25 0 0 0-.25-.25H5.75a.25.25 0 0 0-.25.25V3l-1.998.011a.25.25 0 0 0-.25.25v.989c0 .137.11.25.248.25l.755-.005a.75.75 0 0 1 .745.75v5.505a.75.75 0 0 1-.75.75l-.748.011a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25zm1.427-8.513h1.719c.906 0 1.438.498 1.438 1.312 0 .871-.575 1.362-1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756.58 1.756 1.524 0 .953-.626 1.45-2.158 1.45H6.927z" />
                        </svg></div>
                    <div class="menu-text"> PAYMENT CRYPTO WITH TRX</div>
                </a>
            </div>
               <div class="menu-item @if(preg_match('/\bpayment_binance\b/i', $current)) active @endif">
                <a href="/payment_binance" class="menu-link">
                    <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="currentColor" class="bi bi-currency-bitcoin" viewBox="0 0 16 16">
                            <path
                                d="M5.5 13v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.5v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.084c1.992 0 3.416-1.033 3.416-2.82 0-1.502-1.007-2.323-2.186-2.44v-.088c.97-.242 1.683-.974 1.683-2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a.25.25 0 0 0-.25-.25h-1a.25.25 0 0 0-.25.25V3h-.573V1.75a.25.25 0 0 0-.25-.25H5.75a.25.25 0 0 0-.25.25V3l-1.998.011a.25.25 0 0 0-.25.25v.989c0 .137.11.25.248.25l.755-.005a.75.75 0 0 1 .745.75v5.505a.75.75 0 0 1-.75.75l-.748.011a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25zm1.427-8.513h1.719c.906 0 1.438.498 1.438 1.312 0 .871-.575 1.362-1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756.58 1.756 1.524 0 .953-.626 1.45-2.158 1.45H6.927z" />
                        </svg></div>
                    <div class="menu-text"> PAYMENT WITH BINANCE </div>
                </a>
            </div>
            <div class="menu-item @if(preg_match('/\bform\b/i', $current)) active @endif">
                <a href="/form" class="menu-link">
                    <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="currentColor" class="bi bi-dollar" viewBox="0 0 16 16">
                            <path
                                d="M5.5 13v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.5v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.084c1.992 0 3.416-1.033 3.416-2.82 0-1.502-1.007-2.323-2.186-2.44v-.088c.97-.242 1.683-.974 1.683-2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a.25.25 0 0 0-.25-.25h-1a.25.25 0 0 0-.25.25V3h-.573V1.75a.25.25 0 0 0-.25-.25H5.75a.25.25 0 0 0-.25.25V3l-1.998.011a.25.25 0 0 0-.25.25v.989c0 .137.11.25.248.25l.755-.005a.75.75 0 0 1 .745.75v5.505a.75.75 0 0 1-.75.75l-.748.011a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25zm1.427-8.513h1.719c.906 0 1.438.498 1.438 1.312 0 .871-.575 1.362-1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756.58 1.756 1.524 0 .953-.626 1.45-2.158 1.45H6.927z" />
                        </svg></div>
                    <div class="menu-text">PAYMENT CHECK MXN DEPOSIT</div>
                </a>
            </div>


            <!-- APIs -->
            <div class="bg-white menu-header text-dark">APIs</div>

            <div class="menu-item @if(preg_match('/\bpayment_check_api\b/i', $current)) active @endif">
                <a href="/payment_check_api" class="menu-link">
                    <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-currency-bitcoin" viewBox="0 0 16 16">
                            <path
                                d="M5.5 13v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.5v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.084c1.992 0 3.416-1.033 3.416-2.82 0-1.502-1.007-2.323-2.186-2.44v-.088c.97-.242 1.683-.974 1.683-2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a.25.25 0 0 0-.25-.25h-1a.25.25 0 0 0-.25.25V3h-.573V1.75a.25.25 0 0 0-.25-.25H5.75a.25.25 0 0 0-.25.25V3l-1.998.011a.25.25 0 0 0-.25.25v.989c0 .137.11.25.248.25l.755-.005a.75.75 0 0 1 .745.75v5.505a.75.75 0 0 1-.75.75l-.748.011a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25zm1.427-8.513h1.719c.906 0 1.438.498 1.438 1.312 0 .871-.575 1.362-1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756.58 1.756 1.524 0 .953-.626 1.45-2.158 1.45H6.927z" />
                        </svg></div>
                    <div class="menu-text"> PAYMENT API</div>
                </a>
            </div>
            <!-- Historial -->
            <div class="bg-white menu-header text-dark">HISTORY</div>
            <div class="menu-item @if(preg_match('/\bhistorialcall\b/i', $current)) active @endif">
                <a href="/historialCall" class="menu-link">
                    <div class="menu-icon"><i class="fa fa-list"></i></div>
                    <div class="menu-text">Payments <i class="fas fa-history "></i></div>
                </a>
            </div>

            <div class="bg-white menu-header text-dark">SHOPPING</div>

            <div class="menu-item @if(preg_match('/\bapiserviceshistorial\b/i', $current)) active @endif">
                <a href="/apiserviceshistorial" class="menu-link">
                    <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z" />
                        </svg></div>
                    <div class="menu-text text-warning">SERVICES SUBSCRIPTED</div>
                </a>
            </div>
            <div class="bg-white menu-header text-dark">Config</div>

            <div class="menu-item @if(preg_match('/\bapi_config\b/i', $current)) active @endif">
                <a href="/api_config" class="menu-link">
                    <div class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-link" viewBox="0 0 16 16">
                            <path
                                d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9q-.13 0-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z" />
                            <path
                                d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4 4 0 0 1-.82 1H12a3 3 0 1 0 0-6z" />
                        </svg></div>
                    <div class="menu-text">APi Config</div>
                </a>
            </div>
            @if(Auth::user()->email == 'gomezlopeznapoleon@gmail.com')
            <div class="menu-header">Admin</div>
            <div class="menu-item @if(preg_match('/\badmin\b/i', $current)) active @endif">
                <a href="/admin" class="menu-link">
                    <div class="menu-icon"><i class="fa fa-code-commit"></i></div>
                    <div class="menu-text">Admin Area</div>
                </a>
            </div>
            @endif
            <!-- Botón minimizar -->
            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop">
    <a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a>
</div>
<!-- END #sidebar -->
