@include('layouts.header')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-1 fw-bold">Check Binance Payment</h4>
                    <small>Sponsor: <strong>paygo.lat</strong></small>
                </div>
                <div class="card-body p-4">

                    <div class="alert alert-warning rounded-3 mb-4">
                        <strong>Note:</strong> To check payments using Binance ID, API credentials must be configured.
                        <a href="/" class="alert-link">View instructions</a>.
                    </div>

                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/valid_binance.jpeg') }}"
                             style="max-width: 60%; height: auto;"
                             class="img-fluid rounded shadow-sm"
                             alt="Example Screenshot">
                        <p class="mt-2 text-muted small">
                            Example of a valid transaction made via TRX or from external panels.
                        </p>
                    </div>

                    <ul class="mb-4 small">
                        <li class="text-success">
                            <strong>Valid:</strong> Binance ID like <code>362497063368261633</code> from spot or external wallets.
                        </li>
                        <li class="text-danger">
                            <strong>Invalid:</strong> Internal Binance payment IDs (e.g., Funding Account, P2P).
                        </li>
                    </ul>

                    <form action="/binance_check_id" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <!-- Check via ID -->
                        <div class="mb-4">
                            <label for="txId" class="form-label fw-semibold">Binance ID</label>
                            <input type="text" name="txId" id="txId" class="form-control form-control-lg"
                                   placeholder="Enter Binance Transaction ID">
                        </div>

                        <div class="text-center text-muted mb-3">— <strong>OR</strong> —</div>

                        <!-- Check via image -->
                        <div class="mb-4">
                            <label for="payment_image" class="form-label fw-semibold">Upload Payment Screenshot</label>
                            <input type="file" name="payment_image" id="payment_image"
                                   class="form-control form-control-lg"
                                   accept="image/*">
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fa fa-search me-2"></i> Verify Payment
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
