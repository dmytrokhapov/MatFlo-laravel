<x-app-layout :search=$search>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">

    <script type="text/javascript" src="{{ asset('js/app/auth.js') }}"></script>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (request()->has('success'))
                <div class="alert alert-success"> {{ request()->get('success') }} </div>
            @endif
            @if (request()->has('error'))
                <div class="alert alert-danger"> {{ request()->get('error') }} </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @if (session('success') == 'Email verified successfully.')
                    <script>
                        // setTimeout(() => {
                        postSignUp("{{ \Auth::user()->role }}", "");
                        // }, 1000);
                    </script>
                @endif
            @endif

            <div class="card work-flow">
                <div class="card-header">
                    <h3 class="card-title">API Keys</h3>
                    <h4>
                            <a href="javascript:void(0);" id="btnBatch"
                                class="create-btn btn btn-info float-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light"
                                onclick="javascript:$('#userFormModel').modal();"><i class="fa fa-plus"></i>New Key</a>
                    </h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info" id="divOngoingTransaction" style="display: none">Ongoing
                                Transaction: <span id="linkOngoingTransaction">None</span> </div>
                        </div>
                    </div>

                </div>

                <!-- row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">

                            <div class="table-responsive">
                                <table class="table product-overview" id="userCultivationTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Key</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($apikeys as $apikey)
                                    <tr>
                                        <td>{{$apikey->name}}</td>
                                        <td>{{$apikey->api_key}}</td>
                                        <td>{{$apikey->created_at?->format('d M, Y') ?? ''}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                                <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li style="text-align: center; margin: 5px;"><a href="{{ route('apikey.delete', $apikey->id) }}">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    @empty
                                        <td colspan="7" align="center">No Data Available</td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                                <!-- Update User Form -->
                                <div id="userFormModel" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h3 class="modal-title" id="userModelTitle">New API Key</h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>

                                            <div class="modal-body">
                                                <form id="createForm" class="createForm" method="POST" action="{{route('addkey')}}">
                                                    @csrf
                                                    <fieldset style="border:0;">
                                                        <div class="form-group">
                                                            <label class="control-label" for="keyname">API Key Name <i
                                                                    class="red">*</i></label>
                                                            <input type="text" class="form-control" id="keyname"
                                                                name="keyname" placeholder="Name"
                                                                data-parsley-required="true">
                                                        </div>
                                                    </fieldset>

                                            </div>
                                            <div class="modal-footer border-0">
                                                <i style="display: none;" class="fa fa-spinner fa-spin"></i>
                                                <button type="submit" class="btn submit-btn">Generate</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

</x-app-layout>
