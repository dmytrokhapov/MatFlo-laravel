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
                <h3 class="page-title">Explorer</h3>
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
                        <input type="text" style="max-width: 500px;" class="form-control" size="30" placeholder="Search Documents" onkeyup="filterResult(this.value)">
                        <div id="livesearch"></div>
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
                    console.log(this.responseText);
                    res = JSON.parse(this.responseText)
                    stopLoader();
                }
            }
            xmlhttp.open("GET","/search?q="+str, true);
            xmlhttp.send();
            setTimeout(() => {
                
                startLoader();
            }, 500);
        }

        function filterResult(str) {
            if (str.length==0) {
                document.getElementById("livesearch").innerHTML="";
                document.getElementById("livesearch").style.border="0px";
                return;
            }
            var innerHtml = '';
            for(doc of res) {
                var link;
                if(doc.status == 'Signed') {
                    link = 'view-batch/'+doc.document_id;
                } else {
                    link = 'view-publish/'+doc.document_id;
                }
                if(doc.name.toUpperCase().includes(str.toUpperCase()) || doc.document_id.toUpperCase().includes(str.toUpperCase())) innerHtml += "<div style='margin-bottom: 5px;'><a href='"+link+"' target='_blank'>"+doc.name+"</a></div>";
            }
            document.getElementById("livesearch").innerHTML = innerHtml;
            document.getElementById("livesearch").style.border="1px solid #A5ACB2";
            document.getElementById("livesearch").style.paddingTop="15px";
            document.getElementById("livesearch").style.paddingLeft="15px";
            document.getElementById("livesearch").style.paddingRight="15px";
            document.getElementById("livesearch").style.paddingBottom="10px";
        }

        showResult('');
    </script>
</x-public-layout>

