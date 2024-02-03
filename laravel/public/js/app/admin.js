
$(window).on('coinbaseReady',function(){
	getUserEvents(globUserContract);
	getCultivationEvents(globMainContract);
});

function userFormSubmit(){
    if($("form#userForm").parsley().isValid()){
        var userWalletAddress = $("#userWalletAddress").val();
		// var userName          = $("#userName").val();
		// var userContactNo     = $("#userContactNo").val();
		// var password          = $("#password").val();
		var userRoles         = $("#userRoles").val();
		var isActive          = $("#isActive").is(":checked");
		var userImageAddress  = $("#userProfileHash").val();
		var imageUrl  = $("#imageUrl").val();
        // startLoader();
        $("#userFormBtn").prop('disabled', true);
        $("#userFormModel .fa-spinner").show();
		globUserContractEthers.updateUserForAdmin(userWalletAddress,userRoles,isActive,userImageAddress)
		.then(function(transaction) {
            handleTransactionResponse(transaction.hash);
            transaction.wait().then(function(transactionReceipt) {
                receiptMessage = "Successfully Updated";
                handleTransactionReceipt(transactionReceipt, receiptMessage);
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: _url,
                    data: {
                        "_token": _token,
                        "wallet": userWalletAddress,
                        "role":userRoles,
                        "imageUrl": imageUrl,
                        "status":isActive
                    },
                    success: function (response) {
                        console.log("response", response);
                        if(response.flag){
                            toastr.success(response.message);
                        }
                        else{
                            toastr.error(response.message);
                        }

                    },
                    error: function (response) {
                        // $("#afterImportExcel").modal('hide');
                        toastr.warning("Something went wrong.");
                        // console.error(xhr.responseJSON.error);
                        // $('#submitBtn').prop('disabled', false);
                    }
                });
                $("#userFormBtn").prop('disabled', false);
                $("#userFormModel .fa-spinner").hide();
                $("#userFormModel").modal('hide');
                getUserEvents(globUserContract);

            }).catch(function(error) {
                console.log("error", error);
                handleGenericError(error.message);
                $("#userFormBtn").prop('disabled', false);
                $("#userFormModel .fa-spinner").hide();
              return;
            });
        }).catch(function(error) {
            stopLoader();
            console.log(error);
            handleGenericError(error.message);
            $("#userFormBtn").prop('disabled', false);
            $("#userFormModel .fa-spinner").hide();
            return;
        });
	}
}


function getCultivationEvents(contractRef) {
    contractRef.getPastEvents('PerformCultivation', {
        fromBlock: 0
    }).then(function (events)
    {
      $("#totalBatch").html(events.length);
      counterInit();

        var finalEvents = [];
        $.each(events,function(index,elem)
        {
            var tmpData = {};
            tmpData.batchNo = elem.returnValues.batchNo;
            tmpData.transactionHash = elem.transactionHash;
            getBatchStatus(contractRef, tmpData.batchNo).then(result => {
                tmpData.status = result;
                finalEvents.push(tmpData);
            });
        });

        setTimeout(function()
        {
          if(finalEvents.length > 0){
              var table = buildCultivationTable(finalEvents);
              $("#userCultivationTable").find("tbody").html(table);

              reInitPopupForm();
          }
        },1000);



        // $("#transactions tbody").html(buildTransactionData(events));
    }).catch(error => {
        console.log(error)
    });
}


function getCultivationEvents(contractRef) {
    contractRef.getPastEvents('PerformCultivation', {
        fromBlock: 0
    }).then(function (events)
    {
    	$("#totalBatch").html(events.length);

        var finalEvents = [];
        $.each(events,function(index,elem)
        {
            var tmpData = {};
            tmpData.batchNo = elem.returnValues.batchNo;
            tmpData.transactionHash = elem.transactionHash;
            getBatchStatus(contractRef, tmpData.batchNo).then(result => {
                console.log(result)
                tmpData.status = result;

                finalEvents.push(tmpData);
            });
        });

        setTimeout(function()
        {
        	if(finalEvents.length > 0){
	            var table = buildCultivationTable(finalEvents);
	            $("#adminCultivationTable").find("tbody").html(table);
	            $('.qr-code-magnify').magnificPopup({
				    type:'image',
				    mainClass: 'mfp-zoom-in'
				});
	        }

            counterInit();
        },1000);

    }).catch(error => {
        console.log(error)
    });
}

function buildCultivationTable(finalEvents)
{
    var table = "";

    for (var tmpDataIndex in finalEvents)
    {
        var elem = finalEvents[tmpDataIndex];

        var batchNo = elem.batchNo;
        var transactionHash = elem.transactionHash;
        var tr = "";
        var url = 'https://sepolia.etherscan.io//tx/'+transactionHash;
        var qrCode = 'https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs=400x400&chl='+url;

        var commBatchTd = `<td>`+batchNo+` <a href="`+url+`" class="text-danger" target="_blank"><i class="fa fa-external-link"></i></a></td>`;
        var commQrTd = `<td><a href="`+qrCode+`" title="`+transactionHash+`" class="qr-code-magnify" data-effect="mfp-zoom-in">
				        	<img src="`+qrCode+`" class="img-responsive" style="width:30px; height:30px;">
				        </a>
				    </td>`;
                    var commActionTd = `<td><a href="view-batch/`+batchNo+`/`+transactionHash+`" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><img src="`+list_image_url+`"></a> </td>`;

        console.log("wl",elem);
		if (elem.status == "PRODUCER") {
            tr = `<tr>
            		`+commBatchTd+commQrTd+`
                    <td><span class="badge badge-warning font-weight-100">Processing</span></td>
                    <td><span class="badge badge-danger font-weight-100">Not Available</span> </td>
                    <td><span class="badge badge-danger font-weight-100">Not Available</span> </td>
                    `+commActionTd+`
                </tr>`;
        } else if (elem.status == "CALCULATOR") {
            tr = `<tr>
                    `+commBatchTd+commQrTd+`
                    <td><span class="badge badge-success font-weight-100">Completed</span></td>
                    <td><span class="badge badge-warning font-weight-100">Processing</span> </td>
                    <td><span class="badge badge-danger font-weight-100">Not Available</span> </td>
                    `+commActionTd+`
                </tr>`;
        } else if (elem.status == "VALIDATOR") {
            tr = `<tr>
                    `+commBatchTd+commQrTd+`
                    <td><span class="badge badge-success font-weight-100">Completed</span></td>
                    <td><span class="badge badge-success font-weight-100">Completed</span> </td>
                    <td><span class="badge badge-warning font-weight-100">Processing</span> </td>
                    `+commActionTd+`
                </tr>`;
        } else if (elem.status == "DONE") {
            tr = `<tr>
                    `+commBatchTd+commQrTd+`
                    <td><span class="badge badge-success font-weight-100">Completed</span></td>
                    <td><span class="badge badge-success font-weight-100">Completed</span> </td>
                    <td><span class="badge badge-success font-weight-100">Completed</span> </td>
                    `+commActionTd+`
                </tr>`;
        }

        table+=tr;
    }

    return table;

}

function getBatchStatus(contractRef, batchNo)
{
    return contractRef.methods.getNextAction(batchNo)
        .call();

}


