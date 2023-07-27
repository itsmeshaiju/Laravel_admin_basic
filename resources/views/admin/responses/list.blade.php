@extends('admin.layouts.app')

@section('styles')
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Responses</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 mt-1">
                        <h6 class="card-title">Response List</h6>
                    </div>

                    <div style="margin-top: 10px;" class="table-responsive">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th data-orderable="false">#</th>
                                    <th>Name</th>
                                    {{-- <th>Image</th> --}}
                                    <th>Address</th>
                                    <th>Age</th>
                                    <th>Qualification</th>
                                    <th>Contact No</th>
                                    <th>Whatsapp No</th>
                                    <th>Constituency</th>
                                    <th>Panchayath</th>
                                    <th>District</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        var table = "";

        $(function() {

            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [ 10, 25, 50, 100, 500 ],
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                ajax: "{{ route('responses.index') }}",
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'excel',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    // {
                    //     data: 'thumbnail',
                    //     name: 'thumbnail'
                    // },

                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    }, {
                        data: 'qualification',
                        name: 'qualification'
                    }, {
                        data: 'contact_no',
                        name: 'contact_no'
                    }, {
                        data: 'whatsapp_no',
                        name: 'whatsapp_no'
                    },
                    {
                        data: 'constituency',
                        name: 'constituency'
                    }, {
                        data: 'panchayath',
                        name: 'panchayath'
                    }, {
                        data: 'district',
                        name: 'district'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        "targets": 1,
                        "className": "text-center",
                    },
                    {
                        "targets": 2,
                        "className": "text-center",
                    },
                    {
                        "targets": 3,
                        "className": "text-center",
                    },
                    {
                        "targets": 4,
                        "className": "text-center",
                    }, {
                        "targets": 5,
                        "className": "text-center",
                    },

                ],
            });
        });

        //code to change status
        function deleteItem(id) {

            Swal.fire({
                title: 'Do you want to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {

                if (result.value == true) {
                    var url = "{{ route('responses.delete') }}";

                    $.ajax({
                        url: url,
                        method: "GET",
                        data: {
                            'id': id
                        },
                        cache: false,
                        success: function(data) {
                            toastr.success(data.message);
                            table.ajax.reload(null, false);
                        },
                        error: function(error) {
                            toastr.error(error.responseJSON.message);
                            console.log(error.responseJSON.message);
                        }
                    });

                }
            });
        }
    </script>


    <script>
        function forceDownload(link) {
            var url = link.getAttribute("data-href");
            var fileName = link.getAttribute("download");
            // link.innerText = "Working...";
            var xhr = new XMLHttpRequest();
            xhr.open("GET", url, true);
            xhr.responseType = "blob";
            xhr.onload = function() {
                var urlCreator = window.URL || window.webkitURL;
                var imageUrl = urlCreator.createObjectURL(this.response);
                var tag = document.createElement('a');
                tag.href = imageUrl;
                tag.download = fileName;
                document.body.appendChild(tag);
                tag.click();
                document.body.removeChild(tag);
                // link.innerText = "Download Image";
            }
            xhr.send();
        }
    </script>
@endsection
