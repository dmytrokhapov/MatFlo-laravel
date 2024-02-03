var batchNo;
window.addEventListener('load', function()
{
  batchNo = $("#batchNo").val();
	if(batchNo!="" || batchNo!=null || batchNo!=undefined){

		getCultivationData(globMainContract,batchNo,function(result)
		{
			var parentSection = $("#cultivationSection");
			var activityName =  "PerformCultivation";
			var built = buildCultivationBlock(result);

			populateProducerSection(parentSection,built,activityName,batchNo)
		});

		// getProducerData(globMainContract,batchNo,function(result){

		// 	var parentSection = $("#farmInspectionSection");
		// 	var activityName = "DoneInspection";
		// 	var built = buildFarmInspectionBlock(result);

		// 	populateSection(parentSection,built,activityName,batchNo);
		// });

		globMainContract.getPastEvents('DoneHarvesting', {
      fromBlock: 0
    },function(error, result){
			const res = result.filter(event => event.returnValues.batchNo == batchNo)
			var parentSection = $("#harvesterSection");
			var activityName = "DoneHarvesting";
			var built = buildHarvesterBlock(res);

			populateSection(parentSection,built,activityName,batchNo);
		});

    globMainContract.getPastEvents('DoneExporting', {
      fromBlock: 0
    },function(error, result){
      const res = result.filter(event => event.returnValues.batchNo == batchNo)
      var parentSection = $("#exporterSection");
      var activityName = "DoneExporting";
      var built = buildHarvesterBlock(res);

      populateSection(parentSection,built,activityName,batchNo);
    });
	}

});
function populateProducerSection(parentSection,built,activityName,batchNo) {
  if(built.isDataAvail==true)
  {
  	getActivityTimestamp(activityName,batchNo, function(resultData)
  	{

      if(resultData.dataTime)
  		{
        var userAddress = resultData.user;
        if($(window).width() <= 565){
          userAddress = userAddress.substring(0,15)+'...';
        }

        var refLink = 'https://sepolia.etherscan.io//tx/'+resultData.transactionHash;
        var html = `<span class="text-info"><i class='fa fa-user'> </i>
                        `+userAddress+` <br/>
                        `+`
                    </span>
                    <i class='fa fa-clock'> </i> `+resultData.dataTime.toLocaleString()+`
                    <a href='`+refLink+`' target='_blank'><i class='fa fa-external-link text-danger'></i></a>
                    <br>`;
        $(parentSection).find(".activityDateTime").html(html);
  			$(parentSection).find(".timeline-body .activityData").append('<img src="/plugins/images/verified.svg" alt="user-img" style="width:80px;height:80px" class="verify">');
  		}

      if(resultData.transactionHash){
        var url = 'https://sepolia.etherscan.io//tx/'+resultData.transactionHash;
        var qrCode = 'https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs=400x400&chl='+url;
        var qrCodeSec = `<a href="`+qrCode+`" title="`+resultData.transactionHash+`" class="qr-code-magnify float-right" data-effect="mfp-zoom-in">
                          <img src="`+qrCode+`" class="img-responsive" style="width:70px; height:70px; margin-top:-75px;"/>
                        </a>`;

        $(parentSection).find(".activityQrCode").html(qrCodeSec);
      }
  	});

	  var tmpTimelineBadge = $(parentSection).prev(".timeline-badge");


		$(tmpTimelineBadge).removeClass("danger").addClass("success");
		$(tmpTimelineBadge).find("i").removeClass().addClass("fa fa-check");
	}


	$(parentSection).find(".activityData").html(built.html);
}
function populateSection(parentSection,built,activityName,batchNo)
{
  if(built.isDataAvail>0)
  {
  	getActivityTimestamp(activityName,batchNo, function(resultData)
  	{
      var html = "";
      $(parentSection).find(".activityDateTime").html("");
      built.result.forEach(element => {
        // getUserDetailsByAddress
        var refLink = 'https://sepolia.etherscan.io//tx/'+element.transactionHash;
        getUserDetailsByAddress(globUserContractEthers, element.returnValues.user, function(res) {
          globProvider.getBlock(element.blockNumber).then(function(result){
            html = `<span class="text-info"><i class='fa fa-user'> </i> `+element.returnValues.user+` <br/>
                  </span>
                    <i class='fa fa-clock'> </i> `+new Date(result.timestamp*1000).toLocaleString()+`
                    <a href='`+refLink+`' target='_blank'><i class='fa fa-external-link text-danger'></i></a>
                  <br>`;
            $(parentSection).find(".activityDateTime").append(html);
          })

        })

      });


  	});

	  var tmpTimelineBadge = $(parentSection).prev(".timeline-badge");
    var total = (activityName == "DoneHarvesting"?globPartsLen*globCalculatorLen:globPartsLen*globValidatorLen);
    if(built.result.length == total){
      $(parentSection).find(".timeline-body").append('<img src="/plugins/images/verified.svg" alt="user-img" style="width:80px;height:80px" class="verify">');
      $(tmpTimelineBadge).removeClass("danger").addClass("success");
      $(tmpTimelineBadge).find("i").removeClass().addClass("fa fa-check");
    } else {
      $(tmpTimelineBadge).removeClass("danger").addClass("info");
      $(tmpTimelineBadge).find("i").removeClass().addClass("fa fa-spinner");
    }

	}


	$(parentSection).find(".activityData").html(built.html);
}

function getActivityTimestamp(activityName, batchNo, callback)
{
	globMainContract.getPastEvents(activityName,{
		fromBlock:0,
		filter:{batchNo: batchNo}
	},function(error,eventData)
	{
		try
		{
      web3.eth.getBlock(eventData[0].blockNumber,function(error,blockData)
			{
        var resultData = {};
				var date = blockData.timestamp;
				/* Convert Seconds to Miliseconds */
			 	date = new Date(date * 1000);
			 	// $("#cultivationDateTime").html("<i class='fa fa-clock'> </i> " + date.toLocaleString());

        resultData.dataTime = date;
        resultData.transactionHash = eventData[0].transactionHash;

        var userAddress = eventData[0].returnValues.user;
        getUserDetailsByAddress(globUserContractEthers,userAddress,function(result){
            if(userAddress == globAdminAddress){
                resultData.name      = 'Admin';
                resultData.contactNo = '-';
            }else{
                resultData.name      = result.name;
                resultData.contactNo = result.contactNo;
            }

            resultData.user      = userAddress;

            callback(resultData);
        });
			})
		}
		catch(e)
		{
			callback(false);
		}
	});
}

function buildCultivationBlock(result)
{
	var cultivationData = {};
	var registrationNo = result.registrationNo;
	var producerName     = result.producerName;
	var factoryAddress    = result.factoryAddress;
	var calculators   = globCalculatorLen;
	var validators   = globValidatorLen;
	var parts   = result.parts;

	if(registrationNo!='' && producerName!='' && factoryAddress!='' && calculators!='' && validators!='' && parts != ''){
		cultivationData.html =  `<tr>
                                <td><b>Registration No:</b></td>
                                <td>`+registrationNo+` <i class="fa fa-check-circle verified_info"></i></td>
                            </tr>
                            <tr>
                                <td><b>Producer Name:</b></td>
                                <td>`+producerName+` <i class="fa fa-check-circle verified_info"></i></td>
                            </tr>
                            <tr>
                                <td><b>Factory Address:</b></td>
                                <td>`+factoryAddress+` <i class="fa fa-check-circle verified_info"></i></td>
                            </tr>
                            <tr>
                                <td><b>Parts:</b></td>
                                <td>`+"Part1, Part2"+` </td>
                            </tr>`;

        cultivationData.isDataAvail = true;
    }else{
    	cultivationData.html = ` <tr>
                                    <td colspan="2"><p>Information Not Avilable</p></td>
                            </tr>`;

        cultivationData.isDataAvail = false;
    }

    return cultivationData;
}

// function buildFarmInspectionBlock(result){
// 	var farmInspactorData = {};
// 	var concreteFamily      = result.concreteFamily;
// 	var typeOfCement        = result.typeOfCement;

// 	if(concreteFamily!='' && typeOfCement!=''){
// 		farmInspactorData.html =  `<tr>
//                                     <td><b>Concrete Family:</b></td>
//                                     <td>`+concreteFamily+` <i class="fa fa-check-circle verified_info"></i></td>
//                                   </tr>
//                                   <tr>
//                                     <td><b>Type of Cement:</b></td>
//                                     <td>`+typeOfCement+` <i class="fa fa-check-circle verified_info"></i></td>
//                                   </tr>
//                                   `;
//         farmInspactorData.isDataAvail = true;
//     }else{
//     	farmInspactorData.html = `<tr>
// 	                                    <td colspan="2"><p>Information Not Avilable</p></td>
// 	                            </tr>`;
// 	    farmInspactorData.isDataAvail = false;
//     }

//     return farmInspactorData;
// }

function buildHarvesterBlock(result){
	var harvesterData = {};
	if(result.length != 0){
  harvesterData.result = result;
  harvesterData.html =  ``;
      harvesterData.isDataAvail = result.length;
  }else{
    harvesterData.result = result;
    harvesterData.html = `<tr><td colspan="2"><p>Information Not Avilable</p></td></tr>`;
      harvesterData.isDataAvail = result.length;
  }

  return harvesterData;
}

function buildExporterBlock(result){
	var exporterData = {};

	if(result.length != 0){
		exporterData.result = result;
    exporterData.html =  ``;
        exporterData.isDataAvail = result.length;
	}else{
    exporterData.result = result;
    	exporterData.html = ` <tr><td colspan="2"><p>Information Not Avilable</p></td></tr>`;
        exporterData.isDataAvail = result.length;
    }

    return exporterData;
}
