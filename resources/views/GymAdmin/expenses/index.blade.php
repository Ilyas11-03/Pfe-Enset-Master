@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">



            <!-- Analytics Section -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Expenses</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ $totalExpenses }}</h4>
                                    </div>
                                    <p class="mb-0">Total number of expenses</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="bx bx-receipt bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span>Total Amount</span>
                                    <div class="d-flex align-items-end mt-2">
                                        <h4 class="mb-0 me-2">{{ number_format($totalAmount, 2) }} DH</h4>
                                    </div>
                                    <p class="mb-0">Total amount of expenses</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="bx bx-dollar bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Expenses</span></h4>
                <a href="{{ route('gym_admin.expenses.create') }}" class="btn btn-primary">Add Expense</a>
                @if (session('success'))
                    <div class="bs-toast toast toast-placement-ex m-2 fade bg-success bottom-0 end-0 show" role="alert"
                        aria-live="assertive" aria-atomic="true" id="messageToast">
                        <div class="toast-header">
                            <i class="bx bx-bell me-2"></i>
                            <div class="me-auto fw-semibold">Status</div>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">{{ session('success') }}</div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bs-toast toast toast-placement-ex m-2 fade bg-danger bottom-0 end-0 show" role="alert"
                        aria-live="assertive" aria-atomic="true" id="errorToast">
                        <div class="toast-header">
                            <i class="bx bx-bell me-2"></i>
                            <div class="me-auto fw-semibold">Error</div>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">{{ session('error') }}</div>
                    </div>
                @endif
            </div>



            <div class="card p-3">
                <div class="table-responsive-sm table-responsive-md table-responsive-lg" style="" id="tablediv">
                    {{-- <div class="row">
                        <div class="col-md-2">
                            <div class="ms-n2">
                                <div class="dataTables_length" id="DataTables_Table_0_length"><label><select
                                            name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                            class="form-select">
                                            <option value="7">7</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="70">70</option>
                                            <option value="100">100</option>
                                        </select></label></div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label><input type="search"
                                            class="form-control" placeholder="Search User"
                                            aria-controls="DataTables_Table_0"></label></div>
                                <div class="dt-buttons btn-group flex-wrap">
                                    <div class="btn-group"><button
                                            class="btn buttons-collection dropdown-toggle btn-label-secondary mx-4"
                                            tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                            aria-haspopup="dialog" aria-expanded="false"><span><i
                                                    class="bx bx-export me-2 bx-sm"></i>Export</span></button></div>
                                    <button class="btn btn-secondary add-new btn-primary" tabindex="0"
                                        aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasAddUser"><span><i
                                                class="bx bx-plus bx-sm me-0 me-sm-2"></i><span
                                                class="d-none d-sm-inline-block">Add New User</span></span></button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Search and Filter Section -->
                    <div class="card p-3 mb-3">
                        <form action="{{ route('gym_admin.expenses.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-4">
                                    <select name="category" class="form-control">
                                        <option value="">Filter by Category</option>
                                        <option value="Rent" {{ request('category') == 'Rent' ? 'selected' : '' }}>Rent
                                        </option>
                                        <option value="Utilities"
                                            {{ request('category') == 'Utilities' ? 'selected' : '' }}>
                                            Utilities</option>
                                        <option value="Supplies" {{ request('category') == 'Supplies' ? 'selected' : '' }}>
                                            Supplies
                                        </option>
                                        <!-- Add more categories as needed -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('gym_admin.expenses.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table id="dataTable" class="table p-3 table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Expense Date</th>
                                <th>Receipt</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($expenses->count() > 0)
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="ms-2">
                                                <a href="{{ route('gym_admin.expenses.show', encrypt($expense->id)) }}"
                                                    class="text-body text-truncate"><strong>{{ $expense->name }}</strong></a>
                                            </div>
                                        </td>
                                        <td>{{ $expense->category }}</td>
                                        <td>{{ number_format($expense->amount, 2) }} DH</td>
                                        <td>
                                            <span class="badge bg-label-primary">
                                                {{ $expense->expense_date }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($expense->receipt)
                                                <a href="#" class="btn btn-sm btn-icon" data-bs-toggle="modal"
                                                    data-bs-target="#receiptModal"
                                                    onclick="showReceipt('{{ asset('storage/' . $expense->receipt) }}', '{{ $expense->name }}')">
                                                    <i class="bx bx-file"></i>
                                                </a>
                                            @else
                                                No receipt
                                            @endif
                                        </td>


                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                <!-- Edit Button -->
                                                <a href="{{ route('gym_admin.expenses.edit', encrypt($expense->id)) }}"
                                                    class="btn btn-sm btn-icon"><i class="bx bx-edit-alt me-1"></i></a>

                                                <!-- Delete Button -->
                                                <form
                                                    action="{{ route('gym_admin.expenses.destroy', encrypt($expense->id)) }}"
                                                    method="POST" class="d-inline" id="deleteform_{{ $expense->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-icon"
                                                        onclick="if (confirm('Delete?')) { document.getElementById('deleteform_{{ $expense->id }}').submit(); }">
                                                        <i class="bx bx-trash me-1"></i>
                                                    </button>
                                                </form>

                                                <!-- View Details Dropdown -->
                                                <div class="dropdown d-inline">
                                                    <button type="button"
                                                        class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('gym_admin.expenses.show', encrypt($expense->id)) }}">
                                                            <i class='bx bx-detail'></i> Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No expenses found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
                <!-- Modal -->
                <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="receiptModalLabel">Receipt Preview</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="receiptImage" src="" class="img-fluid d-none" alt="Receipt Preview">
                                <p id="nonImageFile" class="d-none">This file cannot be previewed. Click "Download" to
                                    save it.</p>
                            </div>
                            <div class="modal-footer">
                                <a id="downloadReceipt" href="#" download class="btn btn-primary">Download</a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Horizontal Line and Pagination -->
                {{-- <hr class="my-4">
                <div class="d-flex justify-content-between px-3">
                    <div class="text-muted">
                        Showing {{ $expenses->firstItem() }} to {{ $expenses->lastItem() }} of {{ $expenses->total() }}
                        entries
                    </div>
                    <div>
                        {{ $expenses->links('pagination::bootstrap-4') }}
                    </div>
                </div> --}}
            </div>




        </div>
    </div>
    @if ($expenses->isNotEmpty())
        @include('layouts.table')
    @endif
    <script>
        function showReceipt(url, filename) {
            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            const fileExtension = url.split('.').pop().toLowerCase();

            const receiptImage = document.getElementById('receiptImage');
            const nonImageFile = document.getElementById('nonImageFile');
            const downloadLink = document.getElementById('downloadReceipt');

            if (imageExtensions.includes(fileExtension)) {
                receiptImage.src = url;
                receiptImage.classList.remove('d-none');
                nonImageFile.classList.add('d-none');
            } else {
                receiptImage.classList.add('d-none');
                nonImageFile.classList.remove('d-none');
            }

            // Set download link and custom filename
            downloadLink.href = url;
            downloadLink.setAttribute('download', filename);
        }
    </script>


@endsection
