<x-app-layout :search=$search>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">

    <script type="text/javascript" src="{{ asset('js/app/auth.js') }}"></script>
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

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card work-flow">
                <div class="card-header">
                    <h3 class="card-title">WorkFlows</h3>
                    <h4>
                        @if (Auth::user()->role == 'PRODUCER')
                            <a href="javascript:void(0);" id="btnBatch"
                                class="create-btn btn btn-info float-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light"
                                onclick="javascript:$('#batchFormModel').modal();"><i class="fa fa-plus"></i>Upload
                                Document</a>
                        @endif
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
                    <!--row -->
                    <!-- /.row -->

                    <div id="batchFormModel" class="modal fade" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-top: 20px;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h3 class="modal-title">Upload Document</h3>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('dashboard.upload') }}" id="batchForm" class="createForm"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <fieldset style="border:0;">
                                            <div class="form-group">
                                                <label class="control-label" for="documentName">Document Name <i
                                                        class="red">*</i></label>
                                                <input type="text" class="form-control" id="documentName"
                                                    name="documentName" placeholder="Document Name"
                                                    data-parsley-required="true">
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
                                    <button type="button" class="btn submit-btn" id="submitButton"
                                        disabled>Submit</button>
                                </div>
                                <!-- Progress bar -->
                                <div class="progress" style="display: none;">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <th>Created At</th>
                                            <th>Verifier</th>
                                            <th>Status</th>
                                            <th>Note</th>
                                            <th>Verified At</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($documents as $document)
                                            <tr>
                                                <td><a href="{{ route('viewBatch', $document->document_id) }}"
                                                        target="_blank">{{ $document->document_id }}</a></td>
                                                <td>{{ $document->name }}</td>
                                                <td>{{ $document->producer->user_name ?? 'N/A' }}</td>
                                                <td>{{ $document->created_at->format('d M, Y') }}</td>
                                                <td>{{ $document->verifier->user_name ?? 'N/A' }}</td>
                                                <td>
                                                    @php
                                                        $badgeClass = '';
                                                        switch ($document->status) {
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
                                                    <span
                                                        class="badge badge {{ $badgeClass }}">{{ $document->status }}</span>
                                                </td>
                                                <td>{{ $document->note ?? '' }}</td>
                                                <td>{{ $document->verified_at?->format('d M, Y') ?? '' }}</td>
                                                <td>
                                                    @if (Auth::user()->role === 'PRODUCER')
                                                        <a href="{{ route('document.download', $document->id) }}"
                                                            class="btn btn-primary btn-sm">Download</a>
                                                    @endif
                                                </td>
                                            @empty
                                                <td colspan="7" align="center">No Data Available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $documents->links() }}

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
                                                <form id="updateUserForm" class="createForm"
                                                    onsubmit="return false;">
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
                                                            <input type="text" class="form-control"
                                                                id="contactNumber" name="contactNumber"
                                                                placeholder="Contact No." data-parsley-required="true"
                                                                data-parsley-type="digits"
                                                                data-parsley-length="[10, 15]" maxlength="15">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label" for="role">Role </label>
                                                            <select class="form-control" id="role"
                                                                disabled="true" name="role">
                                                                <option value="">Select Role</option>
                                                                <option value="PRODUCER">Producer</option>
                                                                <!-- <option value="CALCULATOR">Calculator</option> -->
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
                                                                onchange="handlefileUpload(event);" />
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
                                            <input type="text" class="form-control" id="shipName"
                                                name="shipName" placeholder="Ship Name" data-parsley-required="true">
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
                                            <input type="number" min="1" class="form-control"
                                                id="importerId" name="importerId" placeholder="Importer Id"
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
                                            <input type="number" min="1" class="form-control"
                                                id="rostingDuration" name="rostingDuration"
                                                placeholder="Time for roasting" data-parsley-required="true">
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
                                                id="packageDateTime" name="packageDateTime"
                                                placeholder="Packaging Date" data-parsley-required="true">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;
        const myDropzone = new Dropzone("#fileUpload", {
            url: "{{ route('dashboard.upload') }}", // Specify the upload URL
            maxFilesize: 1024, // Maximum file size in MB
            acceptedFiles: ".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip", // Accepted file types
            addRemoveLinks: true,
            autoProcessQueue: false,
            createImageThumbnails: false,
            maxFiles: 1,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            uploadedSize: 0, // Variable to store the total uploaded size

            init: function() {
                let progressBarInner;
                this.on("dragenter", function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                });

                this.on("dragover", function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                });

                this.on("drop", function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    // You can handle drop event actions here if needed
                });

                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append("documentName", document.getElementById("documentName").value);
                });

                this.on("success", function(file, response) {
                    console.log(response.message);

                    // Check if the progress is 100% for the uploaded file
                    if (file.upload.progress === 100) {
                        console.log("Success: File uploaded successfully");

                        // Enable the submit button
                        window.location.href = "/dashboard?success=Document uploaded successfully.";
                    } else {
                        console.log("Error: File upload failed");
                        // Handle error, e.g., show error message
                    }
                });

                this.on("error", function(file, errorMessage) {
                    console.error(errorMessage);
                    stopLoader();
                });

                this.on("addedfile", function(file) {
                    // Do something when a file is added to Dropzone
                    console.log("File added:", file);
                    $('#submitButton').prop('disabled', false);

                    // Display progress bar when file is added
                    const progressBar = document.createElement("div");
                    progressBar.className = "progress";
                    progressBarInner = document.createElement("div");
                    progressBarInner.className = "progress-bar";
                    progressBarInner.setAttribute("role", "progressbar");
                    progressBarInner.setAttribute("aria-valuenow", "0");
                    progressBarInner.setAttribute("aria-valuemin", "0");
                    progressBarInner.setAttribute("aria-valuemax", "100");
                    progressBarInner.style.width = "0%";
                    progressBar.appendChild(progressBarInner);
                    file.previewElement.appendChild(
                        progressBar); // Append progress bar to the file's preview element
                });

                // Listen for uploadprogress event to update the progress bar
                this.on("uploadprogress", function(file, progress, bytesSent) {
                    progressBarInner.style.width = progress + "%";
                    progressBarInner.setAttribute("aria-valuenow", progress);
                    if (progressBarInner) {
                        progressBarInner.innerText = progress + "%"; // Update progress bar text content
                    }
                });

                // Adding a listener for the remove event
                this.on("removedfile", function(file) {
                    // Check if file is being canceled
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
            event.preventDefault(); // Prevent default form submission
            myDropzone.processQueue(); // Trigger file upload process
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
            /*For User Form Pop Up*/
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
    </script>
    <script type="text/javascript" src="{{ asset('js/app/user.js') }}"></script>


</x-app-layout>
