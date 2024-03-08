var globCurrentEditingBatchNo = false;
var globCurrentUser = false;

var userForm,
    farmInspectionForm,
    harvesterForm,
    exporterForm,
    importerForm,
    processingForm;

$(document).ready(function(){

  userForm =  $("#updateUserForm").parsley();
  farmInspectionForm =  $("#farmInspectionForm").parsley();
  harvesterForm =  $("#harvesterForm").parsley(); exporterForm =  $("#exporterForm").parsley(); importerForm =  $("#importerForm").parsley();
  processingForm =  $("#processingForm").parsley();

  $('.datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true,
        format:"dd-mm-yyyy"
    });
  setTimeout(function(){
    getUsers();
  }, 3000);
});

/* --------------- User Section -----------------------*/
$("#editUser").on('click',function(){
  startLoader();
  getUser(globUserContract, function(data){

       $("#fullname").val(data.name);
       $("#contactNumber").val(data.contactNo);
       $("#role").val(data.role);

       var profileImageLink = 'https://ipfs.io/ipfs/'+data.profileHash;
       var btnViewImage = '<a href="'+profileImageLink+'" target="_blank" class=" text-danger"><i class="fa fa-eye"></i> View Image</a>';
       $("#imageHash").html(btnViewImage);

       changeSwitchery($("#isActive"),data.isActive);
       switchery.disable();
       stopLoader();
       $("#userFormModel").modal();
    });
});

$("#userFormBtn").on('click',function(){

    if(userForm.validate())
    {
      var fullname      = $("#fullname").val();
      var contactNumber = $("#contactNumber").val();
      var role          = globCurrentUser.role;
      var userStatus    = $("#isActive").is(":checked");
      var profileHash   = $("#userProfileHash").val();

      var userDetails = {
          fullname : fullname,
          contact : contactNumber,
          role : role,
          status : userStatus,
          profile : profileHash
      };

      updateUser(globUserContract, userDetails);
    }
});

function getUsers()
{
    //console.log("here");
  globUserContract.getPastEvents('UserUpdate',{
    fromBlock: 0
  }).then(function (events){
    var filteredUser = {};

		/*filtering latest updated user record*/
		$(events).each(function(index,event){

			if(filteredUser[event.returnValues.user] == undefined)
			{
				filteredUser[event.returnValues.user] = {};
				filteredUser[event.returnValues.user].address = event.address;
				filteredUser[event.returnValues.user].role = event.returnValues.role;
				filteredUser[event.returnValues.user].user = event.returnValues.user;
				filteredUser[event.returnValues.user].name = event.returnValues.name;
				filteredUser[event.returnValues.user].isActive = event.returnValues.isActive;
				filteredUser[event.returnValues.user].contactNo = event.returnValues.contactNo;
				filteredUser[event.returnValues.user].blockNumber = event.blockNumber;
			}
			else if(filteredUser[event.returnValues.user].blockNumber < event.blockNumber)
			{
				filteredUser[event.returnValues.user].address = event.address;
				filteredUser[event.returnValues.user].role = event.returnValues.role;
				filteredUser[event.returnValues.user].user = event.returnValues.user;
				filteredUser[event.returnValues.user].name = event.returnValues.name;
				filteredUser[event.returnValues.user].isActive = event.returnValues.isActive;
				filteredUser[event.returnValues.user].contactNo = event.returnValues.contactNo;
				filteredUser[event.returnValues.user].blockNumber = event.blockNumber;
			}
		});

		var builtUser = [];
		for(tmpUser in filteredUser)
		{
			builtUser.push(filteredUser[tmpUser]);
		}
		globUsers = builtUser;
  }).catch((err)=>{
    console.log(err);
  });
}

function addCultivationBatch()
{

    if (batchFormInstance.validate())
    {
        var registrationNo = $("#registrationNo").val().trim();
        var producerName = $("#producerName").val().trim();
        var factoryAddress = $("#factoryAddress").val().trim();
        var activeCalculators = globUsers.filter(function(user){
          return user.isActive == true && user.role == "CALCULATOR";
        })
        var activeValidators = globUsers.filter(function(user){
          return user.isActive == true && user.role == "VALIDATOR";
        })
        if(activeCalculators.length < globCalculatorLen) {
          sweetAlert("Warning", "Calculators should be more than "+globCalculatorLen+" members", "warning");
          return;
        }
        if(activeValidators.length < globValidatorLen) {
          sweetAlert("Warning", "Validators should be more than "+globValidatorLen+" members", "warning");
          return;
        }
        var choosedCalculators = activeCalculators.sort(() => .5 - Math.random()).slice(0, globCalculatorLen).map(element => element.user);
        var choosedValidators = activeValidators.sort(() => .5 - Math.random()).slice(0, globValidatorLen).map(element => element.user);
        try {
          startLoader();
          //console.log("sds",globCoinbase,registrationNo,producerName,factoryAddress,globCalculatorLen,globValidatorLen,globPartsLen,choosedCalculators,choosedValidators)
          var tx = globMainContractEthers.addBasicDetails(globCoinbase, registrationNo, producerName, factoryAddress, globCalculatorLen, globValidatorLen, globPartsLen, choosedCalculators, choosedValidators);
          tx.then(function(transaction) {
            stopLoader();
            handleTransactionResponse(transaction.hash);
            $("#batchFormModel").modal('hide');
            transaction.wait().then(function(transactionReceipt) {
              receiptMessage = "Successfully Added";
              handleTransactionReceipt(transactionReceipt, receiptMessage);
              $("#batchFormModel").modal('hide');
              getCultivationEvents(globMainContract);
            }).catch(function(error) {
              handleGenericError(error.message);
              return;
            });
          }).catch(function(error) {
            stopLoader();
            handleGenericError(error.message);
            return;
          });
        } catch ( error ) {
          handleGenericError(error.message);
          return;
        }

    }
}

function getUser(contractRef,callback)
{
    console.log("fdf",globCoinbase);
   console.log("fgg",contractRef.methods)
   contractRef.methods.getUser(globCoinbase).call(function (error, result) {
        if(error){
            alert("Unable to get User" + error);
        }
        var newUser = result;
        if (callback)
        {
            callback(newUser);
        }
    });
}

function updateUser(contractRef,data)
{
  contractRef.methods.updateUser(data.fullname,data.contact,data.role,data.status,data.profile)
  .send({from:globCoinbase,to:contractRef.address})
  .on('transactionHash',function(hash)
        {
          $.magnificPopup.instance.close()
          handleTransactionResponse(hash);
          $("#userFormModel").modal('hide');
        })
        .on('receipt',function(receipt)
        {
            receiptMessage = "User Profile Updated Succussfully";
            handleTransactionReceipt(receipt,receiptMessage);
            $("#userFormModel").modal('hide');
        })
        .on('error',function(error)
        {
            handleGenericError(error.message);
            return;
        });
}

/* --------------- Activity Section -----------------------*/

function editActivity(batchNo)
{
  startLoader();
  globCurrentEditingBatchNo = batchNo;
}

/* --------------- Farm Inspection Section -----------------------*/


$("#updateFarmInspection").on('click',function(){

    if(farmInspectionForm.validate())
    {
      var data = {
        batchNo : globCurrentEditingBatchNo,
        // concreteFamily : $("#concreteFamily").val().trim(),
        // typeOfCement : $("#typeOfCement").val().trim(),
      };

      updateFarmInspection(globMainContract, data);
    }
});

function updateFarmInspection(contractRef,data)
{
    console.log(contractRef)
  //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
  contractRef.methods.updateProducerData(globCoinbase, data.batchNo)
  .send({from:globCoinbase, to:contractRef.address})
  .on('transactionHash',function(hash)
        {
          $.magnificPopup.instance.close()
          handleTransactionResponse(hash);
        })
        .on('receipt',function(receipt)
        {
            receiptMessage = "Producer Data Updated Succussfully";
            handleTransactionReceipt(receipt,receiptMessage)
        })
        .on('error',function(error)
        {
            handleGenericError(error.message);
            return;
        });
}

/* --------------- Harvest Section -----------------------*/


$("#updateHarvest").on('click',function(){

    if(harvesterForm.validate())
    {
      var data = {
        batchNo : globCurrentEditingBatchNo,
        // cementUsed : $("#cementUsed").val().trim(),
        // gravelUsed : $("#gravelUsed").val().trim(),
        // waterUsed : $("#waterUsed").val().trim(),
      };

      updateHarvest(globMainContract, data);
    }
});

function updateHarvest(contractRef,data)
{
  //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
  contractRef.methods.getBasicDetails(data.batchNo).call()
  .then((result)=>{
    var lenParts = globPartsLen;
    console.log(result)
    contractRef.getPastEvents('DoneHarvesting', {
      fromBlock: 0
    }).then(function(events) {
      console.log('ev', events)
      var lenDid = events.filter(event => event.returnValues.user == globCoinbase && event.returnValues.batchNo == data.batchNo).length;
      if(lenDid < lenParts) {
        try {
          startLoader();
          var tx = globMainContractEthers.updateCalculatorData(globCoinbase, data.batchNo);
          tx.then(function(transaction) {
            stopLoader();
            handleTransactionResponse(transaction.hash);
            $.magnificPopup.instance.close()
            transaction.wait().then(function(transactionReceipt) {
              receiptMessage = "Calculator Data Updated Succussfully";
              handleTransactionReceipt(transactionReceipt, receiptMessage);
            }).catch(function(error) {
              handleGenericError(error.message);
              return;
            });
          }).catch(function(error) {
            stopLoader();
            handleGenericError(error.message);
            return;
          });
        } catch ( error ) {
          handleGenericError(error.message);
          return;
        }

        // contractRef.methods.updateCalculatorData(data.batchNo)
        // .send({from:globCoinbase,to:contractRef.address})
        // .on('transactionHash',function(hash)
        //       {
        //         $.magnificPopup.instance.close()
        //         handleTransactionResponse(hash);
        //       })
        //       .on('receipt',function(receipt)
        //       {
        //           receiptMessage = "Calculator Data Updated Succussfully";
        //           handleTransactionReceipt(receipt,receiptMessage)
        //       })
        //       .on('error',function(error)
        //       {
        //           handleGenericError(error.message);
        //           return;
        //       });
      } else {
        sweetAlert("Note","You had signed all parts","info");
      }
    })
  })
  .catch((error)=>{
    sweetAlert("Error","Unable to get Details","error");
    return;
  });


}


/* --------------- Export Section -----------------------*/


$("#updateExport").on('click',function(){

    if(exporterForm.validate())
    {
      var data = {
        batchNo : globCurrentEditingBatchNo,
      };

      updateExport(globMainContract, data);
    }
});

function updateExport(contractRef,data)
{
  //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
  contractRef.methods.getBasicDetails(data.batchNo).call()
  .then((result)=>{
    var lenParts = globPartsLen;
    contractRef.getPastEvents('DoneExporting', {
      fromBlock: 0
    }).then(function(events) {
      var lenDid = events.filter(event => event.returnValues.user == globCoinbase && event.returnValues.batchNo == data.batchNo).length;
      if(lenDid < lenParts) {
        try {
          startLoader();
          var tx = globMainContractEthers.updateValidatorData(globCoinbase, data.batchNo);
          tx.then(function(transaction) {
            stopLoader();
            handleTransactionResponse(transaction.hash);
            $.magnificPopup.instance.close()
            transaction.wait().then(function(transactionReceipt) {
              receiptMessage = "Validator Data Updated Succussfully";
              handleTransactionReceipt(transactionReceipt, receiptMessage);
            }).catch(function(error) {
              handleGenericError(error.message);
              return;
            });
          }).catch(function(error) {
            stopLoader();
            handleGenericError(error.message);
            return;
          });
        } catch ( error ) {
          handleGenericError(error.message);
          return;
        }

      } else {
        sweetAlert("Error","You had signed all parts","error");
      }
    })
  })
  .catch((error)=>{
    sweetAlert("Error","Unable to get Details","error");
    return;
  });


}

/* --------------- Import Section -----------------------*/


$("#updateImport").on('click',function(){

    if(importerForm.validate())
    {
      var data = {
        batchNo : globCurrentEditingBatchNo,
        quantity : parseInt($("#quantity").val().trim()),
        shipName : $("#shipName").val().trim(),
        shipNo : $("#shipNo").val().trim(),
        transportInfo : ($("#transportInfo").val().trim()),
        warehouseName : ($("#warehouseName").val().trim()),
        warehouseAddress : ($("#warehouseAddress").val().trim()),
        importerId : parseInt($("#importerId").val().trim()),
      };

      updateImport(globMainContract, data);
    }
});

function updateImport(contractRef,data)
{
  //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
  contractRef.methods.updateImporterData(data.batchNo, data.quantity, data.shipName, data.shipNo, data.transportInfo, data.warehouseName, data.warehouseAddress,data.importerId)
  .send({from:globCoinbase,to:contractRef.address})
  .on('transactionHash',function(hash)
        {
          $.magnificPopup.instance.close()
          handleTransactionResponse(hash);
        })
        .on('receipt',function(receipt)
        {
            receiptMessage = "Import Updated Succussfully";
            handleTransactionReceipt(receipt,receiptMessage)
        })
        .on('error',function(error)
        {
            handleGenericError(error.message);
            return;
        });
}

/* --------------- Processor Section -----------------------*/

$("#updateProcessor").on('click',function(){

    if(processingForm.validate())
    {
      var tmpDate = $("#packageDateTime").val().trim().split("-");
      tmpDate = tmpDate[1]+"/"+tmpDate[0]+"/"+tmpDate[2];

      var data = {
        batchNo : globCurrentEditingBatchNo,
        quantity : parseInt($("#quantity").val().trim()),
        temperature : $("#processingTemperature").val().trim(),
        rostingDuration : parseInt($("#rostingDuration").val().trim()),
        internalBatchNo : ($("#internalBatchNo").val().trim()),
        packageDateTime : new Date(tmpDate).getTime() / 1000 ,
        processorName : ($("#processorName").val().trim()),
        processorAddress : ($("#processorAddress").val().trim()),
      };

      updateProcessor(globMainContract, data);
    }
});

function updateProcessor(contractRef,data)
{
  //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
  contractRef.methods.updateProcessorData(data.batchNo, data.quantity, data.temperature, data.rostingDuration, data.internalBatchNo, data.packageDateTime, data.processorName,data.processorAddress)
  .send({from:globCoinbase,to:contractRef.address})
  .on('transactionHash',function(hash)
        {
          $.magnificPopup.instance.close()
          handleTransactionResponse(hash);
        })
        .on('receipt',function(receipt)
        {
            receiptMessage = "Processing Updated Succussfully";
            handleTransactionReceipt(receipt,receiptMessage)
        })
        .on('error',function(error)
        {
            handleGenericError(error.message);
            return;
        });
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

        setTimeout(async function()
        {
          if(finalEvents.length > 0){
              var table = await buildCultivationTable(finalEvents);
              $("#userCultivationTable").find("tbody").html(table);

              reInitPopupForm();
          }
        },1000);



        // $("#transactions tbody").html(buildTransactionData(events));
    }).catch(error => {
        console.log(error)
    });
}

async function buildCultivationTable(finalEvents)
{
    $.magnificPopup.instance.popupsCache = {};

    var table = "";

    for (var tmpDataIndex in finalEvents)
    {
        var elem = finalEvents[tmpDataIndex];
        var batchNo = elem.batchNo;
        var transactionHash = elem.transactionHash;
        var tr = "";

        if (elem.status == "PRODUCER") {
            tr = `<tr>
                    <td>`+batchNo+`</td>
                  `;

              if(globCurrentUser.role == "PRODUCER")
              {
                tr+=`<td>
                          <span class="badge badge-dark font-weight-100">
                          <a class="popup-with-form" href="#farmInspectionForm" onclick="editActivity('`+batchNo+`')">
                            <span class="badge badge-dark font-weight-100">Update</span>
                          </a>
                      </td>`;
              }
              else
              {
                 tr+=`<td><span class="badge badge-warning font-weight-100">Processing</span> </td>`;
              }


          tr+=`<td><span class="badge badge-danger font-weight-100">Not Available</span> </td>
              <td><span class="badge badge-danger font-weight-100">Not Available</span> </td>
              <td><a href="view-batch.php?batchNo=`+batchNo+`&txn=`+transactionHash+`" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><img src="`+list_image_url+`"></a> </td>
          </tr>`;

        } else if (elem.status == "CALCULATOR") {

          tr = `<tr>
                    <td>`+batchNo+`</td>
                    <td><span class="badge badge-success font-weight-100">Completed</span></td>
                    `;
                    console.log(globCurrentUser.role);
                  if(globCurrentUser.role == "CALCULATOR")
                  {
                    var events = await globMainContract.getPastEvents('DoneHarvesting', {
                      fromBlock: 0
                    });
                    console.log("e",events);

                    var lenDid = events.filter(event => event.returnValues.user == globCoinbase && event.returnValues.batchNo == batchNo).length;
                    tr+=`<td>
                              <span class="badge badge-dark font-weight-100">
                              <a class="popup-with-form" href="#harvesterForm" onclick="editActivity('`+batchNo+`')">
                                <span class="badge badge-dark font-weight-100">Update (${lenDid}/${globPartsLen})</span>
                              </a>
                          </td>`;

                  }
                  else
                  {
                     tr+=`<td><span class="badge badge-warning font-weight-100">Processing</span> </td>`;
                  }

          tr+=`
              <td><span class="badge badge-danger font-weight-100">Not Available</span> </td>
              <td><a href="view-batch.php?batchNo=`+batchNo+`&txn=`+transactionHash+`" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><img src="`+list_image_url+`"></a> </td>
          </tr>`;
        } else if (elem.status == "VALIDATOR") {
            tr = `<tr>
                    <td>`+batchNo+`</td>
                    <td><span class="badge badge-success font-weight-100">Completed</span></td>
                    <td><span class="badge badge-success font-weight-100">Completed</span> </td>
                  `;

                  if(globCurrentUser.role == "VALIDATOR")
                  {
                    var events = await globMainContract.getPastEvents('DoneExporting', {
                      fromBlock: 0
                    });

                    var lenDid = events.filter(event => event.returnValues.user == globCoinbase && event.returnValues.batchNo == batchNo).length;
                    tr+=`<td>
                              <span class="badge badge-dark font-weight-100">
                              <a class="popup-with-form" href="#exporterForm" onclick="editActivity('`+batchNo+`')">
                                <span class="badge badge-dark font-weight-100">Update (${lenDid}/${globPartsLen})</span>
                              </a>
                          </td>`;
                  }
                  else
                  {
                     tr+=`<td><span class="badge badge-warning font-weight-100">Processing</span> </td>`;
                  }

              tr+=`
                    <td><a href="view-batch.php?batchNo=`+batchNo+`&txn=`+transactionHash+`" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><img src="`+list_image_url+`"></a> </td>
                </tr>`;
        } else if (elem.status == "DONE") {
            tr = `<tr>
                    <td>`+batchNo+`</td>
                    <td><span class="badge badge-success font-weight-100">Completed</span></td>
                    <td><span class="badge badge-success font-weight-100">Completed</span> </td>
                    <td><span class="badge badge-success font-weight-100">Completed</span> </td>
                  `;
                tr+=`
                    <td><a href="/view-batch/`+batchNo+`/`+transactionHash+`" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><img src="`+list_image_url+`"></a> </td>
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

function getDetailOfBatch(contractRef, batchNo, status) {
  console.log(status)
  if(status == "VALIDATOR") {
    return contractRef.methods.getCalculatorData(batchNo)
        .call();
  } else if(status == "VALIDATOR1") {
    return contractRef.methods.getValidatorData(batchNo)
        .call();
  } else if(status == "PRODUCER") {
    return contractRef.methods.getProducerData(batchNo)
        .call();
  }
}

function reInitPopupForm()
{
  $('.popup-with-form').magnificPopup({
    type: 'inline',
    preloader: true,
    key: 'popup-with-form',
    // When elemened is focused, some mobile browsers in some cases zoom in
    // It looks not nice, so we disable it:
    callbacks: {
      open: function() {
        stopLoader();
      }
    }
  });
}

