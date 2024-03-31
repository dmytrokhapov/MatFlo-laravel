<x-app-layout :search=$search>
    <script type="text/javascript" src="{{asset('js/app/auth.js')}}"></script>

<style>
/**
 * Checkbox Toggle UI
 */
 input[type="checkbox"].js-switch {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-tap-highlight-color: transparent;
    width: auto;
    height: auto;
    vertical-align: middle;
    position: relative;
    border: 0;
    outline: 0;
    cursor: pointer;
    margin: 0 4px;
    background: none;
    box-shadow: none;
}
input[type="checkbox"].js-switch:focus {
    box-shadow: none;
}
input[type="checkbox"].js-switch:after {
    content: '';
    font-size: 11px;
    font-weight: 400;
    line-height: 18px;
    text-indent: 14px;
    color: #fff;
    width: 44px;
    height: 18px;
    display: inline-block;
    background-color: #a7aaad;
    border-radius: 72px;
    box-shadow: 0 0 12px rgb(0 0 0 / 15%) inset;
}
input[type="checkbox"].js-switch:before {
    content: '';
    width: 14px;
    height: 14px;
    display: block;
    position: absolute;
    top: 2px;
    left: 2px;
    margin: 0;
    border-radius: 50%;
    background-color: #ffffff;
}
input[type="checkbox"].js-switch:checked:before {
    left: 28px;
    margin: 0;
    background-color: #ffffff;
}
input[type="checkbox"].js-switch,
input[type="checkbox"].js-switch:before,
input[type="checkbox"].js-switch:after,
input[type="checkbox"].js-switch:checked:before,
input[type="checkbox"].js-switch:checked:after {
    transition: ease .15s;
}

input[type="checkbox"].js-switch:checked:after {
    content: '';
    background-color: #0F8EFF;
    text-indent: -14px;
}

.producer_body input[type="checkbox"].js-switch:checked:after {
    background-color: #6B37FF;
}
.calculator_body input[type="checkbox"].js-switch:checked:after {
    background-color: #BF37FF;
}
.verifier_body input[type="checkbox"].js-switch:checked:after {
    background-color: #FF37A3;
}
</style>

    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                {{-- <li class="breadcrumb-item active">Home</li> --}}
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                @if(session('success') == "Email verified successfully.")
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    <script>
                        //setTimeout(() => {
                            postSignUp("{{\Auth::user()->wallet}}", "{{\Auth::user()->role}}", "");
                       // }, 1000);
                    </script>
                @endif
            @endif
            @if(\Auth::user()->role == 'ADMIN')
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <figure><img src="{{asset('img/register-user.svg')}}"></figure>
                    <div class="inner">
                      <p>Regitered Users</p>
                      <h3 id="totalUsers" >{{count($res)}}</h3>
                      
                    </div>

                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <!-- small box -->
                  <div class="small-box bg-success">
                    <figure><img src="{{asset('img/total-roles.svg')}}"></figure>
                    <div class="inner">
                      
                      <p>Total Role</p>
                      <h3>2</h3>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <figure><img src="{{asset('img/total-batches.svg')}}"></figure>
                    <div class="inner">
                      
                      <p>Total Batches</p>
                      <h3  id="totalBatch">{{count($documentAll)}}</h3>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                  </div>
                </div>

                <!-- ./col -->
              </div>
            @endif
            <div class="card work-flow">
                <div class="card-header">
                  <h3 class="card-title m-0">Documents</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table product-overview" id="adminCultivationTable">
                            <thead>
                                <tr>
                                    <th>Document ID</th>
                                    <th>Name</th>
                                    <th>Producer</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($documentAll as $document)
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" align="center">No Data Available</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
              </div>

              @if(\Auth::user()->role == 'ADMIN')
              <div class="card work-flow user">
                <div class="card-header">
                  <h3 class="card-title">Users</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  
                    <table class="table product-overview" id="tblUser">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Joined Date</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse($res as $user)
                          <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user_name }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->created_at }}</td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="4" align="center">No Data Available</td>
                          </tr>
                          @endforelse
                        </tbody>
                    </table>
                  
                </div>
                <!-- /.card-body -->
              </div>
              @endif
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>

      <!-- Update User Form -->
      <div id="userFormModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-top:0px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h2 class="modal-title" id="userModelTitle">Add User</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="userForm" class="createForm" onsubmit="return false;">
                        <fieldset style="border:0;">
                            <input type="hidden" class="form-control" id="userWalletAddress" name="userWalletAddress" placeholder="Wallet Address" data-parsley-required="true" minlength="42" maxlength="42">
                            <div class="form-group">
                                <label class="control-label" for="userName">User Name</label>
                                <input type="text" class="form-control" id="userName" name="userName" placeholder="Name" data-parsley-required="true" disabled>
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label" for="userContactNo">User Contact <i class="red">*</i></label>
                                <input type="text" class="form-control" id="userContactNo" name="userContactNo" placeholder="Contact No." data-parsley-required="true" data-parsley-type="digits" data-parsley-length="[10, 15]" maxlength="15">
                            </div> -->
                            <div class="form-group">
                                <label class="control-label" for="userRoles">User Role <i class="red">*</i></label>
                                <select class="form-control" id="userRoles" name="userRoles" data-parsley-required="true">
                                    <option value="">Select Role</option>
                                    <option value="PRODUCER">Producer</option>
                                    <option value="CALCULATOR">Calculator</option>
                                    <option value="VERIFIER">Verifier</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="isActive">User Status</label>
                                <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" id="isActive" name="isActive" data-size="small"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="userProfileHash">Profile Image <i class="red">*</i></label>
                                <input type="file" class="form-control" onchange="handleFileUpload(event);" />
                                <input type="hidden" class="form-control" id="userProfileHash" name="userProfileHash" placeholder="User Profile Hash" data-parsley-required="true" >
                                <span id="imageHash"></span>
                                <input type="hidden" name="imageUrl" id="imageUrl">
                            </div>
                        </fieldset>

                </div>
                <div class="modal-footer border-0">
                    <i style="display: none;" class="fa fa-spinner fa-spin"></i>
                      <button type="submit" onclick="userFormSubmit();" class="fcbtn btn submit-btn btn-1f" id="userFormBtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
      </div>

      <div id="workflowFormModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-top: 20px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h3 class="modal-title">Add Batch</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="batchForm" class="createForm" onsubmit="return false;">
                    <fieldset style="border:0;">
                        <div class="form-group">
                            <label class="control-label" for="registrationNo">Registration No <i class="red">*</i></label>
                            <input type="text" class="form-control" id="registrationNo" name="registrationNo" placeholder="Registration No" data-parsley-required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="producerName">Producer Name <i class="red">*</i></label>
                            <input type="text" class="form-control" id="producerName" name="producerName" placeholder="Producer Name" data-parsley-required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="factoryAddress">Factory Address <i class="red">*</i></label>
                            <input class="form-control" id="factoryAddress" name="factoryAddress" placeholder="Factory Address" data-parsley-required="true">
                        </div>
                    </fieldset>

                </div>
                <div class="modal-footer border-0">
                    <button type="submit" onclick="addCultivationBatch();" class="fcbtn btn submit-btn btn-1f">Submit</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
    
      <script>
        var res = '<?php echo json_encode($res);?>';
        //console.log(res);
        var users_res = JSON.parse(res);
        //console.log(users_res);
      </script>
      <script>
         var _token = "{{ csrf_token() }}";
         var _url = "{{ route('updateUser') }}";
         var list_image_url = "{{asset('img/list-action.svg')}}";
         
      </script>
    <script type="text/javascript" src="{{asset('js/app/admin.js')}}"></script>
    
</x-app-layout>