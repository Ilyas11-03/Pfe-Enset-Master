@section('style')
    <style>
        /* Custom styling for the search input */
        #dt-search-0 {

            margin-bottom: 10px;
            /* Add some space below the search input */

        }

        #tablediv .pagination {
            margin: 10px
        }

        #tablediv th {
            text-align: left;
            vertical-align: top
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                //  "scrollY": 'auto', // Enable auto vertical scrolling
                //  "scrollCollapse": true, // Collapse the table to fit content
                "searching": true,
                "pageLength": 8, // Set pagination to display 10 rows per page
                "lengthChange": false // Hide the "Entries per page" dropdown
            });

        });
    </script>
@endsection
