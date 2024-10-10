@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> {{ $appointments[0]->receipt_code }}
@endsection

@section('styles')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6">
                    <h4>{{ $appointments[0]->customer->name }}</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>
        </div>
        <form action="{{ route('appointments.update.tr', $appointments[0]->receipt_code) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="container">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Treatment</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach ($appointments[0]->details as $key => $treat)
                                <tr>
                                    <td>#</td>
                                    <td>
                                        <select required class="form-select treatment_id[{{ $key }}]"
                                            id="treatment_id[{{ $key }}]" name="treatment_id[]">
                                            <option value="">-- Pick Treatment --</option>
                                            @foreach ($treatment as $t)
                                                <option value="{{ $t->id }}"
                                                    {{ $t->id == $treat->treatment_id ? 'selected' : '' }}>
                                                    {{ $t->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input required type="text" readonly class="form-control"
                                            name="treatment_price[]"
                                            value="Rp. {{ number_format($treat->treatment->price, 0, '.', '.') }}">
                                    </td>
                                    <td>
                                        @if ($key == 0)
                                            <span class="action-span add-row-span">
                                                <i class="mdi mdi-plus"></i>
                                            </span>
                                        @else
                                            <span class="action-span remove-row-span">
                                                <i class="mdi mdi-minus"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end"><strong>Total:</strong></td>
                                <td>
                                    <input type="text" id="grand-total" class="form-control" readonly>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" required> Accept Changes <i class="input-helper"></i></label>
                      </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button type="button" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Function to format currency and remove trailing zeros
            function formatCurrency(amount) {
                if (isNaN(amount)) return '';
                let formattedAmount = parseFloat(amount).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                return 'Rp. ' + formattedAmount;
            }

            // Function to update treatment price based on selected treatment
            function updateTreatmentPrice(selectElement) {
                const treatmentId = selectElement.val();
                const $priceInput = selectElement.closest('tr').find('input[name="treatment_price[]"]');

                if (treatmentId) {
                    $.ajax({
                        url: "{{ route('treatment.price') }}",
                        type: 'GET',
                        data: {
                            treatment_id: treatmentId
                        },
                        success: function(response) {
                            if (response.price) {
                                const formattedPrice = formatCurrency(response.price);
                                $priceInput.val(formattedPrice);
                                calculateGrandTotal(); // Update grand total after price change
                            } else {
                                $priceInput.val('');
                                calculateGrandTotal(); // Update grand total after price change
                            }
                        },
                        error: function() {
                            $priceInput.val('');
                            calculateGrandTotal(); // Update grand total after price change
                        }
                    });
                } else {
                    $priceInput.val('');
                    calculateGrandTotal(); // Update grand total after price change
                }
            }

            // Function to calculate and update the grand total
            function calculateGrandTotal() {
                let grandTotal = 0;

                $('input[name="treatment_price[]"]').each(function() {
                    // Remove currency symbols and non-numeric characters, then parse the value
                    const priceText = $(this).val().replace(/[^\d]/g, '');
                    const price = parseFloat(priceText) || 0;
                    grandTotal += price;
                });

                $('#grand-total').val(formatCurrency(grandTotal)); // Update grand total field
            }

            // Initialize Select2 for treatment_id selects
            $('select[name="treatment_id[]"]').select2({
                theme: 'bootstrap-5',
                width: '100%'

            });

            // Calculate grand total on page load
            calculateGrandTotal();

            // Event listener for Select2 change to update treatment price
            $('select[name="treatment_id[]"]').on('change', function() {
                updateTreatmentPrice($(this));
            });

            // Event listener for dynamically added rows
            $(document).on('change', 'select[name="treatment_id[]"]', function() {
                updateTreatmentPrice($(this));
            });

            // Add new row
            $(document).on('click', '.add-row-span', function() {
                const newRow = `
            <tr>
                <td>#</td>
                <td>
                    <select required class="form-select treatment_id[]" data-placeholder="Pick Treatment" name="treatment_id[]">
                        <option value="">-- Pick Treatment --</option>
                        @foreach ($treatment as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input required type="text" readonly class="form-control" name="treatment_price[]" value="">
                </td>
                <td>
                    <span class="action-span remove-row-span">
                        <i class="mdi mdi-minus"></i>
                    </span>
                </td>
            </tr>
        `;
                $('.table-body').append(newRow);
                $('select[name="treatment_id[]"]').select2({
                    theme: 'bootstrap-5',
                    width: '100%'

                }); // Re-initialize Select2
            });

            // Remove row
            $(document).on('click', '.remove-row-span', function() {
                $(this).closest('tr').remove();
                calculateGrandTotal(); // Update grand total after removing a row
            });
        });
    </script>
@endsection
