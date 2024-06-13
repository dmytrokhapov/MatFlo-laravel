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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li style="list-style: none;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
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
                                                        <div class="form-group">
                                                            <label class="control-label" for="keydescription">Description </label>
                                                            <input type="text" class="form-control" id="keydescription"
                                                                name="keydescription" placeholder="Short description"
                                                                data-parsley-required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="keycompany">Company Name <i
                                                                    class="red">*</i></label>
                                                            <input type="text" class="form-control" id="keycompany"
                                                                name="keycompany" placeholder="Company name"
                                                                data-parsley-required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="keysite">Company Website <i
                                                                    class="red">*</i></label>
                                                            <input type="text" class="form-control" id="keysite"
                                                                name="keysite" placeholder="https://example.com"
                                                                data-parsley-required="true">
                                                        </div>
                                                    </fieldset>

                                            </div>
                                            <div class="modal-footer border-0">
                                                <i style="display: none;" class="fa fa-spinner fa-spin"></i>
                                                <button class="btn submit-btn" id="submitBtn">Generate</button>
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

            <div class="card work-flow">
                <div class="card-header">
                    <h3 class="card-title">API Documentation</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <p><h5><b>1. Authentication</b></h5></p>
                            <p>To authenticate your requests to the API, you need to include your API key in the Authorization header.</p>
                            <p><strong>MATFLO-API-KEY:</strong> YOUR_API_KEY</p>
                            <hr />
                            <p><h5><b>2. API Endpoints</b></h5></p>

                            <p><h5>Retrieve Documents</h5></p>
                            <p><strong>Endpoint:</strong> <code>GET /v1/getDocuments</code></p>
                            <p><strong>Description:</strong> Retrieve documents from the API.</p>
                            <p><strong>Parameters:</strong> None</p>
                            <p><strong>Response:</strong></p>
                            <span>
                            {
                                "status": "success",
                                "documents": Documents
                            }
                            </span>
                            <hr />
                            <p><h5>Retrieve Publishments</h5></p>
                            <p><strong>Endpoint:</strong> <code>GET /v1/getDeclarations</code></p>
                            <p><strong>Description:</strong> Retrieve publishments from the API.</p>
                            <p><strong>Parameters:</strong> None</p>
                            <p><strong>Response:</strong></p>
                            <span>
                            {
                                "status": "success",
                                "declarations": Publishments
                            }
                            </span>
                            <hr />
                            <p><h5>Upload Document</h5></p>
                            <p><strong>Endpoint:</strong> <code>POST /v1/upload</code></p>
                            <p><strong>Description:</strong> Upload document from the API.</p>
                            <p><strong>Parameters:</strong></p>
                            <ul>
                                <li><strong>file</strong> (required, file, mimes:pdf,doc,docx,jpg,jpeg,png,zip, max size:1024): The document file to be uploaded.</li>
                                <li><strong>documentName</strong> (string, required): The title of the document.</li>
                                <li><strong>documentLocation</strong> (string): The location of the document.</li>
                            </ul>
                            <p><strong>Response:</strong></p>
                            <span>
                            {
                                "status": "success",
                                "message": "Document uploaded successfully",
                                "document": Document
                            }
                            </span>
                            <hr />
                            <p><h5>Accept Document</h5></p>
                            <p><strong>Endpoint:</strong> <code>GET /v1/accept/{document}</code></p>
                            <p><strong>Description:</strong> Accept document</p>
                            <p><strong>Parameters:</strong></p>
                            <ul>
                                <li><strong>document</strong> (required): The document id to be accepted.</li>
                            </ul>
                            <p><strong>Response:</strong></p>
                            <span>
                            {
                                "status": "success",
                                "message": "Document accepted successfully",
                            }
                            </span>
                            <hr />
                            <p><h5>Reject Document</h5></p>
                            <p><strong>Endpoint:</strong> <code>GET /v1/reject/{document}</code></p>
                            <p><strong>Description:</strong> Reject document</p>
                            <p><strong>Parameters:</strong></p>
                            <ul>
                                <li><strong>document</strong> (required): The document id to be rejected.</li>
                            </ul>
                            <p><strong>Response:</strong></p>
                            <span>
                            {
                                "status": "success",
                                "message": "Document rejected successfully",
                            }
                            </span>
                            <hr />
                            <p><h5>Sign Document</h5></p>
                            <p><strong>Endpoint:</strong> <code>POST /v1/sign/{document}</code></p>
                            <p><strong>Description:</strong> Sign document</p>
                            <p><strong>Parameters:</strong></p>
                            <ul>
                                <li><strong>document</strong> (required): The document id to be signed.</li>
                                <li><strong>file</strong> (required, file, mimes:pdf,doc,docx,jpg,jpeg,png,zip, max size:1024): The signed document.</li>
                            </ul>
                            <p><strong>Response:</strong></p>
                            <span>
                            {
                                "status": "success",
                                "message": "Document signed successfully",
                            }
                            </span>
                            <hr />
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        $("#createForm").validate({
            rules: {
                keyname: {
                    required: true,
                },
                keycompany: {
                    required: true,
                },
                keysite: {
                    required: true,
                    url: true
                }
            },
            messages: {
                keyname: {
                    required: "Please enter API key name",
                },
                keycompany: {
                    required: "Please enter company name",
                },
                keysite: {
                    required: "Please enter company website",
                    url: "Please enter valid website url"
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                $('#submitBtn').prop('disabled', true);
                // signIn();
                form.submit();
                //submit via ajax
            },
            errorPlacement: function(error, element) {
                // Customize the placement of error messages
                error.insertAfter(element);
            },
            success: function(label, element) {
                // Hide the error message label
                label.hide();
            },
        });
    </script>

</x-app-layout>
