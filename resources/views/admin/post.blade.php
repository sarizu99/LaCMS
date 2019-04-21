@extends('layouts.admin')

@section('title', $title)

@push('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fixedHeader.dataTables.min.css') }}"/>
    <style>
        table.dataTable {
            margin-top: 0 !important;
        }
        i.fas.fa-star {
            cursor: help;
        }
    </style>
@endpush

@section('content')
<div class="row my-4">
    <div class="col-md-12">
        @if (session('delete') || session('add'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @if (session('delete'))
                    <strong>Post deleted</strong>
                @else
                    <strong>Post added</strong>
                @endif
            </div>
        @endif

        <a class="btn btn-primary mb-3" href="{{ route('post.create') }}" role="button">
            <i class="fas fa-plus"></i>
            Add New
        </a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Categories</th>
                    <th width="85">Updated at</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Categories</th>
                    <th>Updated at</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

    <div class="modal fade" id="deleteConf" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmation" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">No</button>
                    <form action="{{ url('/admin/post/') }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('node_modules\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('node_modules\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.fixedHeader.min.js') }}"></script>

    <script>
        var deletePost = el => {
            $('#deleteConf form').attr('action', '{{ url('/admin/post') }}/' + el.dataset.id);
            $('#deleteConf').modal('show');
        };

        var datata = $('.table').DataTable({
            fixedHeader: {
                header: true
            },
            select: true,
            serverSide: true,
            ajax: {
                url: '{{ url('admin/api/datatables/posts') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            order: [[3, 'desc']],
            columns: [
                { orderable: false },
                { orderable: false },
                { orderable: false },
                { orderable: true }
            ],
        });
    </script>
@endpush