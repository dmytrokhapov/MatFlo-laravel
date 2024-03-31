<x-app-layout :search=$search>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">

    <script type="text/javascript" src="{{asset('js/app/auth.js')}}"></script>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if(request()->has('success')) <div class="alert alert-success"> {{ request()->get('success') }} </div>
            @endif
            @if(request()->has('error')) <div class="alert alert-danger"> {{ request()->get('error') }} </div> @endif
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @if(session('success') == "Email verified successfully.")

            <script>
            //setTimeout(() => {
            postSignUp("{{\Auth::user()->wallet}}", "{{\Auth::user()->role}}", "");
            // }, 1000);
            </script>

            @endif
            @endif

            <div class="card work-flow">
                <div class="card-header">
                    <h3 class="card-title">WorkFlows</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info" id="divOngoingTransaction" style="display: none">Ongoing
                                Transaction: <span id="linkOngoingTransaction">None</span> </div>
                        </div>
                    </div>
                    <!--row -->
                    <!-- /.row -->

                    <!-- Preview Document Modal -->
                    <div id="previewDocumentModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-top: 20px;">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h3 class="modal-title">Preview Document</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <!-- Loading indicator -->
                                    <div id="loadingIndicator" style="display: none;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div>Loading...</div>
                                    </div>

                                    <img id="previewImage" src="" style="width: 100%; max-height: 500px; display: none;">
                                    <iframe id="previewFrame" src="" frameborder="0" style="width: 100%; height: 500px;"></iframe>
                                </div>
                                <div class="modal-footer">
                                    <a id="downloadButton" href="#" class="btn btn-primary btn-sm">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Preview Document Modal -->

                    <!-- Verify Document Modal -->
                    <div id="verifyDocumentModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-top: 20px;">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h3 class="modal-title">Sign Document</h3>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('dashboard.sign') }}" id="batchForm" class="createForm" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <fieldset style="border:0;">
                                                    <div class="form-group">
                                                        <label class="control-label" for="document_name">Document Name</label>
                                                        <input type="text" class="form-control" id="document_name" name="document_name" placeholder="Document Name" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label" for="document_id">Document ID</label>
                                                        <input type="text" class="form-control" id="document_id" name="document_id" placeholder="Document ID" readonly>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-6">
                                                <fieldset style="border:0;">
                                                    <div class="form-group">
                                                        <label class="control-label" for="producer_id">Producer</label>
                                                        <input type="text" class="form-control" id="producer_id" name="producer_id" placeholder="Producer Name" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label" for="created_date">Create Date</label>
                                                        <input type="text" class="form-control" id="created_date" name="created_date" placeholder="Created Date" readonly>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="note">Note</label>
                                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Upload Documents</label>
                                            <div id="fileUpload" class="dropzone border border-dashed mt-2">
                                                <div class="dz-message" data-dz-message>
                                                    <span>Drag files here to upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn submit-btn" id="submitButton" disabled>Submit</button>
                                </div>
                            </div>
                            <!-- Progress bar -->
                            <div class="progress" style="display: none;">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                    </div>
                    <!-- End Verify Document Modal -->

                </div>

                <!-- row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">

                            {{-- <h3 class="box-title">Batches Overview</h3> --}}
                            <div class="table-responsive">
                                <table class="table product-overview" id="userCultivationTable">
                                    <thead>
                                        <tr>
                                            <th>Document ID</th>
                                            <th>Document Name</th>
                                            <th>Producer</th>
                                            <th>Created Date</th>
                                            <th>Status</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($documents as $document)
                                        <tr>
                                            <td><a href="{{route('viewBatch', $document->document_id)}}" target="_blank">{{ $document->document_id }}</a></td>
                                            <td>{{ $document->name }}</td>
                                            <td>{{ $document->producer->user_name ?? null }}</td>
                                            <td>{{ $document->created_at->format('d M, Y') }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = '';
                                                    switch($document->status) {
                                                        case 'Ready for preview':
                                                            $badgeClass = 'badge-warning';
                                                            break;
                                                        case 'Signing':
                                                            $badgeClass = 'badge-primary';
                                                            break;
                                                        case 'Signed':
                                                            $badgeClass = 'badge-success';
                                                            break;
                                                        default:
                                                            $badgeClass = 'badge-danger';
                                                    }
                                                @endphp
                                                <span class="badge badge {{ $badgeClass }}">{{ $document->status }}</span>
                                            </td>
                                            <td>{{ $document->note ?? 'N/A' }}</td>
                                            <td>
                                                <!-- Include other actions like sign, reject, verify -->
                                                <a href="{{ route('verifier.document.accept', $document->id) }}" class="btn btn-primary btn-sm @if($document->status !== 'Ready for preview') disabled @endif" onclick="startLoader(); return confirm('Are you sure?')">Accept</a>
                                                <a href="{{ route('verifier.document.reject', $document->id) }}" class="btn btn-danger btn-sm @if($document->status !== 'Ready for preview' && $document->status !== 'Signing') disabled @endif" onclick="return confirm('Are you sure?')">Reject</a>

                                                @if(Auth::user()->role == 'VERIFIER')
                                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm previewBtn"
                                                        data-document-path="{{ route('verifier.document.preview', $document->id) }}"
                                                        data-document-download="{{ route('document.download', $document->id) }}"
                                                        data-document-id="{{ $document->id }}"
                                                        onclick="previewDocument(this)">Preview</a>

                                                    <a href="javascript:void(0);" class="btn btn-success btn-sm previewBtn @if($document->status !== 'Signing') disabled @endif"
                                                        data-document-form="{{ $document }}"
                                                        data-document-id="{{ route('verifier.document.verify', $document->id) }}"
                                                        onclick="verifyDocument(this)">Verify</a>
                                                @endif

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" align="center">No Data Available</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Update User Form -->
                                <div id="userFormModel" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true"
                                    style="display: none; padding-top: 170px;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h3 class="modal-title" id="userModelTitle">Update Profile</h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>

                                            <div class="modal-body">
                                                <form id="updateUserForm" class="createForm" onsubmit="return false;">
                                                    <fieldset style="border:0;">
                                                        <div class="form-group">
                                                            <label class="control-label" for="fullname">Full Name <i
                                                                    class="red">*</i></label>
                                                            <input type="text" class="form-control" id="fullname"
                                                                name="fullname" placeholder="Name"
                                                                data-parsley-required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="contactNumber">Contact
                                                                No<i class="red">*</i></label>
                                                            <input type="text" class="form-control" id="contactNumber"
                                                                name="contactNumber" placeholder="Contact No."
                                                                data-parsley-required="true" data-parsley-type="digits"
                                                                data-parsley-length="[10, 15]" maxlength="15">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="role">Role </label>
                                                            <select class="form-control" id="role" disabled="true"
                                                                name="role">
                                                                <option value="">Select Role</option>
                                                                <option value="PRODUCER">Producer</option>
                                                                <option value="CALCULATOR">Calculator</option>
                                                                <option value="VERIFIER">Verifier</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="isActive">User
                                                                Status</label>
                                                            <input type="checkbox" class="js-switch"
                                                                data-color="#99d683" data-secondary-color="#f96262"
                                                                id="isActive" name="isActive" data-size="small" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="userProfileHash">Profile
                                                                Image <i class="red">*</i></label>
                                                            <input type="file" class="form-control"
                                                                onchange="handleFileUpload(event);" />
                                                            <input type="hidden" class="form-control"
                                                                id="userProfileHash" name="userProfileHash"
                                                                placeholder="User Profile Hash"
                                                                data-parsley-required="true">
                                                            <span id="imageHash"></span>
                                                        </div>
                                                    </fieldset>

                                            </div>
                                            <div class="modal-footer border-0">
                                                <i style="display: none;" class="fa fa-spinner fa-spin"></i>
                                                <button type="button" class="btn submit-btn"
                                                    id="userFormBtn">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- Farm Inspection Form -->
                                <form id="farmInspectionForm" class="mfp-hide white-popup-block">
                                    <h1>Farm Inspection</h1><br>
                                    <fieldset style="border:0;">
                                        <!-- <div class="form-group">
                                            <label class="control-label" for="InspectorId">Inspector ID Number</label>
                                            <input type="text" class="form-control" id="InspectorId" name="inspectorId" placeholder="inspector id number" data-parsley-required="true">
                                        </div>   -->
                                        <!-- <div class="form-group">
                                            <label class="control-label" for="typeOfCement">Type of Cement</label>
                                            <input type="text" class="form-control" id="typeOfCement" name="typeOfCement" placeholder="type of cement" data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="concreteFamily">Concrete Family</label>
                                            <input type="text" class="form-control" id="concreteFamily" name="concreteFamily" placeholder="concrete family" data-parsley-required="true">
                                        </div>
                                         <div class="form-group float-right">
                                            <button type="reset" class="btn btn-default waves-effect" >Reset</button>
                                            <button type="button" id="updateFarmInspection" class="btn btn-primary">Submit</button>
                                        </div> -->
                                        <p>Are you sure to submit this?</p>
                                    </fieldset>
                                </form>

                                <!-- Harvesting Form -->
                                <form id="harvesterForm" class="createForm mfp-hide white-popup-block ">
                                    <h1>Calculating</h1><br>
                                    <fieldset style="border:0;">

                                        <!-- <div class="form-group">
                                            <label class="control-label" for="cementUsed">Cement</label>
                                            <input type="text" class="form-control" id="cementUsed" name="cementUsed" placeholder="cement" data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="gravelUsed">Gravel</label>
                                            <input type="text" class="form-control" id="gravelUsed" name="gravelUsed" placeholder="gravel" data-parsley-required="true">
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label" for="waterUsed">Water</label>
                                            <input type="text" class="form-control" id="waterUsed" name="waterUsed" placeholder="water" data-parsley-required="true">
                                        </div>                                 -->
                                        <p>Are you sure to submit this?</p>
                                        <div class="form-group float-right">
                                            <button type="reset" class="btn cancel-btn">Reset</button>
                                            <button type="button" id="updateHarvest"
                                                class="btn submit-btn">Submit</button>
                                        </div>
                                    </fieldset>
                                </form>

                                <!-- Exporter Form -->
                                <form id="exporterForm" class="createForm mfp-hide white-popup-block">
                                    <h1>Verifying</h1><br>
                                    <fieldset style="border:0;">

                                        <!-- <div class="form-group">
                                            <label class="control-label" for="quantity">Quantity (in Kg)</label>
                                            <input type="number" min="1" class="form-control" id="quantity" name="quantity" placeholder="Quantity" data-parsley-required="true">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="quality">Quality</label>
                                            <input type="text" class="form-control" id="quality" name="quality" placeholder="Quality" data-parsley-required="true">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="exportNo">Export No</label>
                                            <input type="text" class="form-control" id="exportNo" name="exportNo" placeholder="Export No" data-parsley-required="true">
                                        </div>

                                         <div class="form-group">
                                            <label class="control-label" for="validatorId">Validator ID</label>
                                            <input type="number" class="form-control" id="validatorId" name="validatorId" placeholder="Exporter ID" data-parsley-required="true">
                                        </div> -->
                                        <p>Are you sure to submit this?</p>

                                        <div class="form-group float-right">
                                            <button type="reset" class="btn cancel-btn">Reset</button>
                                            <button type="button" id="updateExport"
                                                class="btn submit-btn">Submit</button>
                                        </div>
                                    </fieldset>
                                </form>

                                <!-- Importer Form -->
                                <form id="importerForm" class="createForm mfp-hide white-popup-block">
                                    <h1>Importing</h1><br>
                                    <fieldset style="border:0;">

                                        <div class="form-group">
                                            <label class="control-label" for="quantity">Quantity</label>
                                            <input type="number" min="1" class="form-control" id="quantity"
                                                name="quantity" placeholder="Quantity" data-parsley-required="true">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="shipName">Ship Name</label>
                                            <input type="text" class="form-control" id="shipName" name="shipName"
                                                placeholder="Ship Name" data-parsley-required="true">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="shipNo">Ship No</label>
                                            <input type="text" class="form-control" id="shipNo" name="shipNo"
                                                placeholder="Ship No" data-parsley-required="true">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="transportInfo">Transport Info</label>
                                            <input type="text" class="form-control" id="transportInfo"
                                                name="transportInfo" placeholder="Transport Info"
                                                data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="warehouseName">Warehouse Name</label>
                                            <input type="text" class="form-control" id="warehouseName"
                                                name="warehouseName" placeholder="Warehouse Name"
                                                data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="warehouseAddress">Warehouse
                                                Address</label>
                                            <input type="text" class="form-control" id="warehouseAddress"
                                                name="warehouseAddress" placeholder="Warehouse Address"
                                                data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="importerId">Importer Id</label>
                                            <input type="number" min="1" class="form-control" id="importerId"
                                                name="importerId" placeholder="Importer Id"
                                                data-parsley-required="true">
                                        </div>

                                        <div class="form-group float-right">
                                            <button type="reset" class="btn btn-default waves-effect">Reset</button>
                                            <button type="button" id="updateImport"
                                                class="btn btn-primary">Submit</button>
                                        </div>
                                    </fieldset>
                                </form>

                                <!-- Processor Form -->
                                <form id="processingForm" class="createForm mfp-hide white-popup-block">
                                    <h1>Processing</h1><br>
                                    <fieldset style="border:0;">
                                        <div class="form-group">
                                            <label class="control-label" for="quantity">Quantity (in Kg)</label>
                                            <input type="number" min="1" class="form-control" id="quantity"
                                                name="quantity" placeholder="Quantity" data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="processingTemperature">Temperature (in
                                                Fahrenheit)</label>
                                            <input type="text" class="form-control" id="processingTemperature"
                                                name="temperature" placeholder="Temperature"
                                                data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="rostingDuration">Time for Roasting (in
                                                Seconds)</label>
                                            <input type="number" min="1" class="form-control" id="rostingDuration"
                                                name="rostingDuration" placeholder="Time for roasting"
                                                data-parsley-required="true">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="internalBatchNo">Internal Batch
                                                no</label>
                                            <input type="text" class="form-control" id="internalBatchNo"
                                                name="internalBatchNo" placeholder="Internal Batch no"
                                                data-parsley-required="true">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="packageDateTime">Packaging Date &
                                                Time</label>
                                            <input type="text" class="form-control datepicker-master"
                                                id="packageDateTime" name="packageDateTime" placeholder="Packaging Date"
                                                data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="processorName">Processor Name</label>
                                            <input type="text" class="form-control" id="processorName"
                                                name="processorName" placeholder="Processor Name"
                                                data-parsley-required="true">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="processorAddress">Processor
                                                Address</label>
                                            <input type="text" class="form-control" id="processorAddress"
                                                name="processorAddress" placeholder="Processor Address"
                                                data-parsley-required="true">
                                        </div>
                                        <div class="form-group float-right">
                                            <button type="reset" class="btn btn-default waves-effect">Reset</button>
                                            <button type="button" id="updateProcessor"
                                                class="btn btn-primary">Submit</button>
                                        </div>
                                    </fieldset>
                                </form>
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
    @if(\Auth::user())
    <script>
    globCoinbase = "{{\Auth::user()->wallet}}";
    </script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        const myDropzone = new Dropzone("#fileUpload", {
            url: "{{ route('dashboard.sign') }}",
            maxFilesize: 1024,
            maxFiles:1,
            autoProcessQueue: false,
            acceptedFiles: ".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip",
            addRemoveLinks: true,
            createImageThumbnails: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function() {
                let progressBarInner;

                // Prevent default behaviors for drag and drop events
                this.on("dragenter dragover drop", function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append('document_id', $('#document_id').val());
                    formData.append('note', $('#note').val());
                });

                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });

                this.on("success", function(file, response) {
                    console.log(response.message);
                    if (file.upload.progress === 100) {
                        console.log("Success: File uploaded successfully");

                        // var provider = new ethers.providers.JsonRpcProvider("@php echo env('RPC_URL') @endphp");
		                // var wallet = new ethers.Wallet("@php echo env('PRIVATE_KEY') @endphp", provider);

                        // var mainContract = new ethers.Contract("@php echo env('CONTRACT_ADDRESS') @endphp", DocChainAbi, wallet);

                        // var tx = globMainContractEthers.storeDocumentHash(globCoinbase, registrationNo, producerName, factoryAddress, globCalculatorLen, globValidatorLen, globPartsLen, choosedCalculators, choosedValidators);
                        // tx.then(function(transaction) {
                        //     console.log(transaction.hash);
                        //     transaction.wait().then(function(transactionReceipt) {
                                
                        //     }).catch(function(error) {
                        //         alert("Error: ", error.message);
                        //         return;
                        //     });
                        // }).catch(function(error) {
                        //     alert(error.message);
                        //     return;
                        // });

                        // Enable the submit button
                        window.location.href = "/dashboard?success=Document signed successfully.";
                        // $('#submitButton').prop('disabled', false);
                    } else {
                        console.log("Error: File upload failed");
                        // Handle error, e.g., show error message
                    }
                });

                this.on("error", function(file, errorMessage) {
                    console.error(errorMessage);
                    alert(errorMessage.message)
                    stopLoader();
                    // Handle error, e.g., show error message
                });

                this.on("addedfile", function(file) {
                    console.log("File added:", file);
                    $('#submitButton').prop('disabled', false);
                    // Display progress bar when file is added
                    const progressBar = $('<div class="progress"></div>');
                    progressBarInner = $('<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>').css('width', '0%');
                    progressBar.append(progressBarInner);
                    $(file.previewElement).append(progressBar);
                });

                this.on("uploadprogress", function(file, progress) {
                    progressBarInner.css('width', progress + "%").attr('aria-valuenow', progress);
                    progressBarInner.text(progress + "%"); // Update progress bar text content
                });

                this.on("removedfile", function(file) {
                    $('#submitButton').prop('disabled', true);
                    if (!file.accepted && file.status === "canceled") {
                        console.log("File canceled:", file);
                        // Subtract the removed file's size from the uploaded size
                        myDropzone.uploadedSize -= file.size;
                    }
                });
            }
        });

        // Handle form submission
        $('#batchForm').submit(function(event) {
            event.preventDefault();
            myDropzone.processQueue();
            // You may also include other form data handling here
        });

        // Handle submit button
        $('#submitButton').click(function() {
            myDropzone.processQueue();
            startLoader();
        });

        // get current url withour params
        var cleanUrl = window.location.href.split('?')[0];

        // change URL without params
        history.replaceState({}, document.title, cleanUrl);

        // Initialize Switchery and DateTimePicker
        initSwitch();
        initDateTimePicker();

        function initSwitch() {
            var switchery = new Switchery($("#isActive")[0], $("#isActive").data());
        }

        function initDateTimePicker() {
            $('.datepicker-master').datetimepicker({
                format: 'dd-mm-yyyy hh:ii:ss',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1,
                minuteStep: 1
            });
        }

        function previewDocument(btn) {
            var documentDownload = $(btn).data('document-download');
            var documentPath = $(btn).data('document-path');
            startLoader();

            $('#previewFrame').on('load', function() {
                stopLoader();
            });

            $.ajax({
                'url' : documentPath,
                'type' : 'GET',
                'data' : {
                    'numberOfWords' : 10
                },
                'success' : function(data, status, xhr) {
                    var ct = xhr.getResponseHeader("content-type") || "";
                    if (ct.indexOf('image') > -1 || ct.indexOf('pdf') > -1) {
                        var contentType = documentPath.split('.').pop().toLowerCase();

                        updatePreview(contentType, documentPath);
                        updateDownloadLink(documentDownload);

                        $('#previewDocumentModal').modal('show');
                    } else {
                        var contentType = documentPath.split('.').pop().toLowerCase();
                        alert('Only PDF and images can be previewed. Otherwise will be downloaded.');
                        updatePreview(contentType, documentPath);
                        updateDownloadLink(documentDownload);
                        stopLoader();
                    }
                    
                },
                'error' : function(request,error)
                {
                    alert("Request: "+JSON.stringify(request));
                }
            });
        }

        $('#previewDocumentModal').on('hidden.bs.modal', function () {
            $('#previewFrame').hide().attr('src', '');
        })  

        function updatePreview(contentType, documentPath) {
            var $previewImage = $('#previewImage');
            var $previewFrame = $('#previewFrame');
            $previewFrame.show().attr('src', documentPath);
            
        }

        function updateDownloadLink(downloadLink) {
            $('#downloadButton').attr('href', downloadLink);
        }

        function verifyDocument(button) {
            var documentForm = button.getAttribute('data-document-form');
            var documentPath = button.getAttribute('data-document-path');
            var documentId = button.getAttribute('data-document-id');
            var iframe = $('#verifyDocumentModal').find('iframe');
            var downloadButton = $('#downloadButton');

            fillFormWithData(documentForm);

            $('#verifyDocumentModal').modal('show');
        }

        function fillFormWithData(data) {
            var documentNameInput = document.getElementById('document_name');
            var documentIdInput = document.getElementById('document_id');
            var producerIdInput = document.getElementById('producer_id');
            var createdDateInput = document.getElementById('created_date');
            var noteInput = document.getElementById('note');

            var documentData = JSON.parse(data);
            var createdDate = new Date(documentData.created_at);

            documentNameInput.value = documentData.name;
            documentIdInput.value = documentData.document_id;
            producerIdInput.value = documentData.producer.user_name;
            createdDateInput.value = createdDate.toLocaleDateString();
            noteInput.value = documentData.note;
        }

    </script>
    <script type="text/javascript" src="{{asset('js/app/user.js')}}"></script>


</x-app-layout>