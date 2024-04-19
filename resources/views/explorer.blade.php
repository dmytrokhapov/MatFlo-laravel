<x-public-layout>

    <style type="text/css">
        .verified_info{
            color: green;
        }
    </style>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
            <div class="bg-title workflow-card-header" style="padding-top: 20px">
                <h3 class="page-title">Matflo Explorer</h3>
                <br />
                <h5>Explore your documents!</h5>
                <p>
                    Check your document's detail. Enter the document ID number or name.
                </p>
            </div>
            <br />
            <!-- .row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <div style="display: flex; gap: 5px;">
                            <input type="text" style="max-width: 500px;" class="form-control" size="30" placeholder="Search Documents" onkeyup="filterResult(event, this.value)" onblur="hideDropDown()">
                            <button class="btn btn-primary" onclick="showTable()">Search</button>
                        </div>    
                        <div id="livesearch" style="max-width: 500px; border-radius: 5px; position: fixed; background-color: white;" ></div>
                        <div style="margin-top: 20px;">
                            <div class="table-responsive" id="resTable" style="display:none;">
                                <table class="table product-overview">
                                    <thead>
                                        <tr>
                                            <th>Document ID</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Created At</th>
                                            <th>Producer</th>
                                            <th>Verifier</th>
                                            <th>Signed / Published at</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </section>

      <!-- <script type="text/javascript" src="{{asset('js/app/batch-details.js')}}"></script> -->
      <script>
        var res;
        function showResult(str) {
            // if (str.length==0) {
            //     document.getElementById("livesearch").innerHTML="";
            //     document.getElementById("livesearch").style.border="0px";
            //     return;
            // }
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                    res = JSON.parse(this.responseText)
                    stopLoader();
                }
            }
            xmlhttp.open("GET","/search?q="+str, true);
            xmlhttp.send();
            startLoader();
        }

        function filterResult(event, str) {
            if(event.keyCode == 13) {
                showTable();
                return;
            }
                
            if (str.length==0) {
                document.getElementById("livesearch").innerHTML="";
                document.getElementById("livesearch").style.border="0px";
                document.getElementById("livesearch").style.paddingTop="0";
                document.getElementById("livesearch").style.paddingLeft="0";
                document.getElementById("livesearch").style.paddingRight="0";
                document.getElementById("livesearch").style.paddingBottom="0";
                $("#tbody").html('No Data Available');
                $("#resTable").hide();
                return;
            }
            var innerHtml = '';
            var tblHtml = '';
            
            for(doc of res) {
                var link;
                if(doc.status == 'Signed') {
                    link = 'view-batch/'+doc.document_id;
                } else {
                    link = 'view-publish/'+doc.document_id;
                }
                console.log(doc)
                if(doc.name.toUpperCase().includes(str.toUpperCase()) || doc.document_id.toUpperCase().includes(str.toUpperCase())){
                    innerHtml += "<div style='margin-bottom: 5px;'><a href='"+link+"' target='_blank'>"+doc.name+"</a></div>";
                    if(doc.status == 'Signed') {
                        tblHtml += "<tr><td><a href='view-batch/"+doc.document_id+"' target='_blank'>"+doc.document_id+"</a></td><td>"+doc.name+"</td><td>"+(doc.location ?? '')+"</td><td>"+(new Date(doc.created_at).toDateString())+"</td><td>"+doc.producer.user_name+"</td><td>"+doc.verifier.user_name+"</td><td>"+(new Date(doc.verified_at).toDateString())+"</td></tr>";
                    } else {
                        tblHtml += "<tr><td><a href='view-publish/"+doc.document_id+"' target='_blank'>"+doc.document_id+"</a></td><td>"+doc.name+"</td><td>"+(doc.location ?? '')+"</td><td>"+(new Date(doc.created_at).toDateString())+"</td><td>"+doc.producer+"</td><td>"+doc.verifier+"</td><td>"+(new Date(doc.published_at).toDateString())+"</td></tr>";
                    }
                    
                }

            }

            
            if(innerHtml === '') {
                innerHtml = "No suggestions";
                $("#tbody").html("No Data Available");
            }
            $("#tbody").html(tblHtml);
            document.getElementById("livesearch").style.paddingTop="15px";
            document.getElementById("livesearch").style.paddingLeft="15px";
            document.getElementById("livesearch").style.paddingRight="15px";
            document.getElementById("livesearch").style.paddingBottom="10px";

            document.getElementById("livesearch").innerHTML = innerHtml;
            document.getElementById("livesearch").style.border="1px solid #A5ACB2";
            
        }

        function hideDropDown() {
            document.getElementById("livesearch").innerHTML="";
            document.getElementById("livesearch").style.border="0px";
            document.getElementById("livesearch").style.paddingTop="0";
            document.getElementById("livesearch").style.paddingLeft="0";
            document.getElementById("livesearch").style.paddingRight="0";
            document.getElementById("livesearch").style.paddingBottom="0";
        }

        function showTable() {
            $("#resTable").show();
        }

        showResult('');
    </script>
</x-public-layout>

