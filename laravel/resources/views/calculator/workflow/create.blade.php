<x-app-layout>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid pt-4 pb-4">
            <div class="workflow-card calculator">
                <h3 class="heading">Review Data / EPD</h3>                    
                <!-- /.card-header -->
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="workflow-header">
                        <div class="text-left">
                            <h5>Your product EPD "Orlando | 6000 PSI at 28 Days" has been generated automtically</h5>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div>
                                    <button type="button" class="btn btn-outline-theme w-100">
                                        <img src="{{asset('img/eye.png')}}" />
                                        Review Data
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <button type="button" class="btn btn-outline-theme w-100">
                                        <img src="{{asset('img/download.png')}}" />
                                        Download or Review EPD
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" id="createForm" class="createForm" action="#">
                        @csrf
                        <div class="form-group mt-4">
                            <label for="comments">{{__('Comments')}}</label>
                            <textarea id="comments" rows="6" class="form-control" type="text" name="comments" placeholder="{{__('Enter your comments here')}}" value="{{old('comments')}}" autofocus autocomplete="comments"></textarea>
                            @error('comments')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-right mt-4">
                            <button type="reset" class="btn btn-outline cancel-btn">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="btn submit-btn" id="submitBtn">
                                {{ __('Approve') }}
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>



    <script type="text/javascript">
        $(document).ready(function() {
            // Do anything
            $("#createForm").validate({
                rules: {
                    comments:{
                        required:true,
                        normalizer: function( value ) {
                            return $.trim( value );
                        }
                    },
                },
                messages: {
                    comments:{
                        required:"Please enter comments",
                    },
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    $('#submitBtn').prop('disabled', true);
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
                    
        });
    </script>
</x-app-layout>
