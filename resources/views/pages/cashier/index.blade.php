@extends('layouts.cashier')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-square-inc-cash"></i>
    </span> POS
@endsection

@section('styles')
    <style>
        .item-image {
            /* height: 10px; */
            max-height: 150px;
        }

        .empty-stock {
            opacity: 0.5;
        }

        .action-span {
            background-color: pink;
            min-width: 50px;
            border-radius: 25px;
            filter: drop-shadow(0px 2px 5px #000000);
            cursor: pointer;
        }

        .item-card {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6">
                    <h4>POS</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body row d-flex" style="padding-block: 18px">
                            @foreach ($items as $item)
                                <div class="card item-card" data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                    data-price="{{ $item->hjl }}"
                                    style="width: 14rem; padding:8px; margin-inline: 16px; margin-block: 16px;background-color: pink">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('assets/images/prod-def.png') }}"
                                        class="card-img-top" alt="{{ $item->name }}"
                                        style="height:150px; object-fit:cover">
                                    <div class="card-body" style="padding: 10px !important;">
                                        <h5 class="card-title text-white">{{ $item->name }}</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" style="background-color: pink">Rp.
                                            {{ number_format($item->hjl, 0, '.', '.') }}</li>
                                        <li class="list-group-item" style="background-color: pink">Stock:
                                            {{ $item->itemsStock[0]->qty }}</li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <form method="POST" action="{{ route('cashier.store') }}" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Items</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="order-table-body">
                                <!-- Items will be added here dynamically -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Total:</td>
                                    <td><input type="text" style="text-align: center; font-weight: bold;"
                                            class="form-control" name="grand_total" id="total" readonly value="0">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        <button id="submit-order" class="btn btn-primary">Submit & Print</button>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            window.addEventListener("load", () => {
                clock();

                function clock() {
                    const today = new Date();

                    // get time components
                    const hours = today.getHours();
                    const minutes = today.getMinutes();
                    const seconds = today.getSeconds();

                    //add '0' to hour, minute & second when they are less 10
                    const hour = hours < 10 ? "0" + hours : hours;
                    const minute = minutes < 10 ? "0" + minutes : minutes;
                    const second = seconds < 10 ? "0" + seconds : seconds;

                    //make clock a 12-hour time clock
                    const hourTime = hour > 12 ? hour - 12 : hour;

                    // if (hour === 0) {
                    //   hour = 12;
                    // }
                    //assigning 'am' or 'pm' to indicate time of the day
                    const ampm = hour < 12 ? "AM" : "PM";

                    // get date components
                    const month = today.getMonth();
                    const year = today.getFullYear();
                    const day = today.getDate();

                    //declaring a list of all months in  a year
                    const monthList = [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ];

                    //get current date and time
                    const date = monthList[month] + " " + day + ", " + year;
                    const time = hourTime + ":" + minute + ":" + second + " " + ampm;

                    //combine current date and time
                    const dateTime = date + " <br> " + time;

                    //print current date and time to the DOM
                    document.getElementById("date-time").innerHTML = dateTime;
                    setTimeout(clock, 1000);
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const orderTableBody = document.getElementById('order-table-body');
                const totalInput = document.getElementById('total');
                const submitOrderButton = document.getElementById('submit-order');
                let orderItems = {};

                // Function to calculate and update the total price
                function updateTotal() {
                    let total = 0;
                    for (let key in orderItems) {
                        total += orderItems[key].price * orderItems[key].qty;
                    }
                    totalInput.value = total.toLocaleString();
                }

                // Function to add item to the order table
                function addItemToOrderTable(id, name, price) {
                    if (orderItems[id]) {
                        // If item already exists, increase the quantity
                        orderItems[id].qty += 1;
                        document.getElementById(`qty-${id}`).value = orderItems[id].qty;
                        document.getElementById(`price-${id}`).value = (orderItems[id].qty * price).toLocaleString();
                    } else {
                        // If item does not exist, create a new row
                        orderItems[id] = {
                            name: name,
                            price: price,
                            qty: 1
                        };
                        const newRow = document.createElement('tr');
                        newRow.setAttribute('id', `item-row-${id}`);
                        newRow.innerHTML = `
                <td style="width: 50px">${Object.keys(orderItems).length}</td>
                <td>
                    <input type="text" name="item_names[]" value="${name}" readonly>
                    <input type="hidden" name="item_ids[]" value="${id}">
                </td>
                <td><input style="width: 50px" type="number" name="quantities[]" id="qty-${id}" value="1" min="1"></td>
                <td><input type="text" name="prices[]" id="price-${id}" value="${price.toLocaleString()}" readonly></td>
                <td><span class="action-span add-row-span" data-id="${id}"><i class="mdi mdi-minus"></i></span></td>
            `;
                        orderTableBody.appendChild(newRow);
                    }
                    updateTotal();
                }

                document.querySelectorAll('.item-card').forEach(card => {
                    card.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const name = this.getAttribute('data-name');
                        const price = parseInt(this.getAttribute('data-price'), 10);
                        addItemToOrderTable(id, name, price);
                    });
                });

                // Click event for item cards
                document.querySelectorAll('.item-card').forEach(card => {
                    card.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const name = this.getAttribute('data-name');
                        const price = parseInt(this.getAttribute('data-price'), 10);
                        addItemToOrderTable(id, name, price);
                    });
                });

                // Event delegation for minus buttons in the order table
                orderTableBody.addEventListener('click', function(e) {
                    if (e.target.closest('.add-row-span')) {
                        const id = e.target.closest('.add-row-span').getAttribute('data-id');
                        if (orderItems[id].qty > 1) {
                            orderItems[id].qty -= 1;
                            document.getElementById(`qty-${id}`).value = orderItems[id].qty;
                            document.getElementById(`price-${id}`).value = (orderItems[id].qty * orderItems[id]
                                .price).toLocaleString();
                        } else {
                            // Remove the item if qty reaches 1
                            delete orderItems[id];
                            document.getElementById(`item-row-${id}`).remove();
                            reorderRows();
                        }
                        updateTotal();
                    }
                });

                // Function to reorder table row numbers after removing items
                function reorderRows() {
                    let rowIndex = 1;
                    document.querySelectorAll('#order-table-body tr').forEach(row => {
                        row.children[0].textContent = rowIndex++;
                    });
                }

                // Function to generate and open the print page

                function openPrintWindow() {
                    const printWindow = window.open('', '_blank');
                    printWindow.document.write(`
                    <html>
        <head>
            <title>Print Order</title>
            <style>
                body { font-family: Arial, sans-serif;font-size:12px }
                body.receipt .sheet { width: 58mm; }
                @media print { body.receipt { width: 58mm } }
                table { width: 100%; border-collapse: collapse;font-size:12px }
                th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
                th { background-color: #f2f2f2; }
                td { background-color: #f9f9f9; }
            </style>
        </head>
        <body class="receipt">
            <div class="sheet">
            <p>Order Summary</p>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Items</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                ${Object.keys(orderItems).map((key, index) => `
                                                                    <tr>
                                                                        <td style="min-width:fit-content;">${index + 1}</td>
                                                                        <td>${orderItems[key].name}</td>
                                                                        <td style="min-width: fit-content;">${orderItems[key].qty}</td>
                                                                        <td>Rp. ${(orderItems[key].price * orderItems[key].qty).toLocaleString()}</td>
                                                                    </tr>
                                                                `).join('')}
                </tbody>
                <tfoot>
                    <tr>
                        <td style="text-align: right" colspan="3">Total:</td>
                        <td>Rp. ${totalInput.value}</td>
                    </tr>
                </tfoot>
            </table>
            </div>
        </body>
        </html>

            `);
                    printWindow.document.close();
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();
                }

                // Submit order and open print page
                submitOrderButton.addEventListener('click', function() {
                    if (Object.keys(orderItems).length > 0) {
                        openPrintWindow();
                    } else {
                        alert('No items in the order!');
                    }
                });
            });
        </script>
    @endsection
