<x-public-layout>

    <style type="text/css">
        .verified_info{
            color: green;
        }
    </style>
    {{-- <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Home</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section> --}}

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
            <div class="bg-title workflow-card-header" style="padding-top: 20px">
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                    {{-- <h3 class="page-title">Workflow Status <a href="javascript:void(0);" onclick="javascript:window.print();" class="text-info" title="Print Page Report"><i class="fa fa-print"></i> Print</a></h3> --}}
                    <h4><b>Document ID: </b> <span style="font-size: 18px; word-break:break-all"><?php echo $document->document_id;?></span></h4>
                </div>
                <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- .row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <ul class="timeline">
                            <li>
                                <div class="timeline-badge success">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="timeline-panel" id="cultivationSection">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Producer</h4>
                                        <p><small class="text-muted text-success activityDateTime"></small> </p>
                                        <span class="activityQrCode"></span>
                                    </div>
                                    <div class="timeline-body">
                                        <table class="table activityData table-responsive" >
                                            <tr>
                                                <td colspan="3"><span>Name: </span></td>
                                                <td colspan="7"><span><?php echo $document->name;?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span>Publisher: </span></td>
                                                <td colspan="7"><span><?php echo $document->uploader->user_name;?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span>Created date: </span></td>
                                                <td colspan="7"><span><?php echo $document->created_at;?></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </li>
                            <!-- <li class="timeline-inverted">
                                <div class="timeline-badge danger">
                                    <i class="fa fa-times"></i>
                                </div>
                                <div class="timeline-panel" id="farmInspectionSection">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Producer</h4>
                                        <span><small class="text-muted text-success activityDateTime"></small> </span>
                                        <span class="activityQrCode"></span>
                                    </div>
                                    <div class="timeline-body">
                                        <table class="table activityData table-responsive">
                                            <tr>
                                                <td colspan="2"><span>Information Not Avilable</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </li> -->
                            <li class="timeline-inverted">
                                @if($document->status == "Published")
                                <div class="timeline-badge success">
                                    <i class="fa fa-check"></i>
                                </div>
                                @elseif($document->status == "Rejected")
                                <div class="timeline-badge danger">
                                    <i class="fa fa-times"></i>
                                </div>
                                @else
                                <div class="timeline-badge">
                                    
                                </div>
                                @endif
                                
                                <div class="timeline-panel" id="exporterSection">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Details</h4>
                                        <p><small class="text-muted text-success activityDateTime"></small> </p>
                                        <span class="activityQrCode"></span>
                                    </div>
                                    <div class="timeline-body">
                                        <table class="table activityData table-responsive" >
                                            <tr>
                                                <td colspan="3"><span>Name: </span></td>
                                                <td colspan="7"><span><?php echo $document->name;?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span>Location: </span></td>
                                                <td colspan="7"><span><?php echo $document->location;?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span>Producer: </span></td>
                                                <td colspan="7"><span><?php echo $document->producer;?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span>Verifier: </span></td>
                                                <td colspan="7"><span><?php echo $document->verifier;?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span>Status: </span></td>
                                                <td colspan="7"><span><?php echo $document->status;?></span></td>
                                            </tr>
                                            @if($document->status == "Published")
                                            <tr>
                                                <td colspan="3"><span>Published date: </span></td>
                                                <td colspan="7"><span><?php echo $document->published_at;?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span>On-chain proof: </span></td>
                                                <td colspan="7"><a href="https://www.oklink.com/amoy/tx/{{$document->chain_address}}" target="_blank"><?php echo substr($document->chain_address, 0, 8)."...".substr($document->chain_address, -6); ?></a></td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="3"><span>Download: </span></td>
                                                <td colspan="7"><a href="{{ route('document.download_publish', $document->id) }}" target="_blank"><?php echo $document->name;?></a></td>
                                            </tr>
                                            
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      </section>

      <script>
        stopLoader();
      </script>
      <script type="text/javascript" src="{{asset('js/app/batch-details.js')}}"></script>
</x-public-layout>

