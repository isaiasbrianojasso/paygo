@include('layouts.header')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0 fw-bold">Check Binance Payment</h4>
                    <small class="text-light">Sponsor: paygo.lat</small>
                </div>
                <div class="card-body p-4">

                    @if(session('status'))
                        <div class="alert alert-{{ session('status_type', 'info') }} mb-3 rounded-3">
                            <strong>{{ session('status_title', 'Notice:') }}</strong> {{ session('status') }}
                        </div>
                    @else
                        <div class="alert alert-info mb-3 rounded-3">
                            <strong>Note:</strong> Please enter the TXID to verify the payment status.
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/valid_trx.png') }}" class="img-fluid rounded shadow-sm" alt="Example Screenshot">
                        <p class="mt-2 text-muted">Example of a valid transaction with TRX or from other panels.</p>
                    </div>

                    <ul class="mb-4 small">
                        <li class="text-success">
                            <strong>Valid:</strong> TxID like <code>255246137489</code> or <code>d53af47e585a29ae471cc18494aa1e0ef78ed3108d5b0655523fc614c701d05e</code>from external wallets or TRX transfers.
                        </li>
                        <li class="text-danger">
                            <strong>Invalid:</strong> Internal Binance payment IDs (e.g., P2P or Funding).
                        </li>
                    </ul>

                    <form action="/binance_check" method="POST">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            <label for="txId" class="form-label">Transaction ID (TxID)</label>
                            <input type="text" name="txId" id="txId" class="form-control form-control-lg"
                                placeholder="Enter TXID" required autofocus>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fa fa-search me-2"></i>Verify Payment
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
