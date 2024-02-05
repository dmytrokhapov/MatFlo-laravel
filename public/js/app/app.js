var globIcoAddress = {
    /*'old-ConcreteMain': "0xfA171Cda184d815D20a318fCe9920AafdC04934e",
    'old-ConcreteUser': "0x26d723acFe39f93A9702592dD9371851f81cF59F",*/

    'ConcreteMain': "0xe99373c4418c1fA0C5075Bf6196965C8C2038CDD",
    'ConcreteUser': "0xD24fc00D45F3D63a8183FACcF821A389dd99f0A6",
    'Storage': "0xa3317447562AAEA64203f79A1d15e2E39656A009"
};

var globAdminAddress = "0x669c7b5fd8f40D84d592fa7549F6D2f644f948fC"; /* This is the admin's wallet address */
var globMainContract = false;
var globMainContractEthers = false;
var globUserContract = false;
var globUsers = [];
var globUserContractEthers = false;
var globCoinbase = false;
var globCurrentUser = false;
var globProvider = false;
var globUserData = [];
var globUserSelectCal = "";
var globUserSelectVal = "";
var globCalculatorLen = 1;
var globValidatorLen = 1;
var globPartsLen = 2;
var privateKey = "0x4cf1434ed89d5ca852e95db9b3d586603e6bab17b2eed581fe7ca186313c0780";

window.addEventListener('load', async function()
{
    $("#storageContractAddress").html(globIcoAddress.Storage);
    $("#coffeeSupplychainContractAddress").html(globIcoAddress.ConcreteMain);
    $("#userContractAddress").html(globIcoAddress.ConcreteUser);

    if (typeof web3 !== 'undefined')
    {
    //   web3 = new Web3(web3.currentProvider);
    //   console.log("dd", web3.currentProvider)
          web3 = new Web3(new Web3.providers.HttpProvider("https://eth-sepolia.g.alchemy.com/v2/VfmrCWXL4WbXXLCXY9yzfXV35IgegQmP"));
          // if (!ethereum.selectedAddress) {
        // 	await ethereum.enable(); // <<< ask for permission
        // }
        // userAccount = ethereum.selectedAddress;
        var myWallet = web3.eth.accounts.privateKeyToAccount(privateKey)
        // this.alert(myWallet.address)
        userAccount = myWallet.address;
        // web3 = new Web3(ethereum);
    } else {
          // set the provider you want from Web3.providers
          web3 = new Web3(new Web3.providers.HttpProvider("https://eth-sepolia.g.alchemy.com/v2/VfmrCWXL4WbXXLCXY9yzfXV35IgegQmP"));
          var myWallet = web3.eth.accounts.privateKeyToAccount(privateKey)
        // this.alert(myWallet.address)
        userAccount = myWallet.address;
    }

    getCurrentAccountAddress((address)=>{
        /*  To Restrict User in Admin Section */
        var currentPath = window.location.pathname;
        var tmpStack = currentPath.split("/");
        var currentPanel = tmpStack.pop();
        if(currentPanel == "admin.php")
        {
            if(address == globAdminAddress){
                window.location = "index.php";
            }
        }
    });

    initContract();

    updateLoginAccountStatus();
    /* setInterval(function () {
        updateLoginAccountStatus();
    }, 500); */

});

function initContract()
{
    globProvider = new ethers.providers.JsonRpcProvider("https://eth-sepolia.g.alchemy.com/v2/VfmrCWXL4WbXXLCXY9yzfXV35IgegQmP");
    var wallet = new ethers.Wallet(privateKey, globProvider);

    globMainContract = new web3.eth.Contract(CoffeeSupplyChainAbi,globIcoAddress.ConcreteMain);
    globMainContractEthers = new ethers.Contract(globIcoAddress.ConcreteMain, CoffeeSupplyChainAbi, wallet);

    $(window).trigger("mainContractReady");

    globUserContract = new web3.eth.Contract(SupplyChainUserAbi,globIcoAddress.ConcreteUser);
    globUserContractEthers = new ethers.Contract(globIcoAddress.ConcreteUser, SupplyChainUserAbi, wallet);
    $(window).trigger("userContractReady");
}

function updateLoginAccountStatus(){
    initAccountDetails();
}

function initAccountDetails(){
    /*
    * Get Current wallet account address
    */
    getCurrentAccountAddress((address)=>{
        if(address != 0) {
            $(window).trigger("coinbaseReady");
        }

    });
}


function getCurrentAccountAddress(callback){
    callback = callback || false;
    var myWallet = web3.eth.accounts.privateKeyToAccount(privateKey)
    callback(myWallet.address)
}

function getUserDetails(contractRef,userName,callback){
    callback = callback || false;

    contractRef.getUserByName(userName)
    .then((result)=>{
        callback(result);
    })
    .catch((error)=>{
        sweetAlert("Error","Unable to get User Details","error");
        callback(0);
    });
}

function getUserDetailsByAddress(contractRef,userAddress,callback){
    callback = callback || false;

    contractRef.getUser(userAddress)
    .then((result)=>{
        callback(result);
    })
    .catch((error)=>{
        sweetAlert("Error","Unable to get User Details","error");
        callback(0);
    });
}

function getCultivationData(contractRef,batchNo,callback){

    if(batchNo == undefined)
    {
        callback(0);
        return;
    }

    callback = callback || false;

    contractRef.methods.getBasicDetails(batchNo).call()
    .then((result)=>{
        callback(result);
    })
    .catch((error)=>{
        sweetAlert("Error","Unable to get Cultivation Details","error");
        callback(0);
    });
}

function getProducerData(contractRef,batchNo,callback){

    if(batchNo == undefined)
    {
        callback(0);
        return;
    }


    callback = callback || false;

    contractRef.methods.getProducerData(batchNo).call()
    .then((result)=>{
        callback(result);
    })
    .catch((error)=>{
        sweetAlert("Error","Unable to get Farm Inspection Details","error");
        callback(0);
    });
}

function getCalculatorData(contractRef,batchNo,callback){

    if(batchNo == undefined)
    {
        callback(0);
        return;
    }


    callback = callback || false;

    contractRef.methods.getCalculatorData(batchNo).call()
    .then((result)=>{
        callback(result);
    })
    .catch((error)=>{
        sweetAlert("Error","Unable to get Harvesting Details","error");
        callback(0);
    });
}

function getValidatorData(contractRef,batchNo,callback){

    if(batchNo == undefined)
    {
        callback(0);
        return;
    }

    callback = callback || false;

    contractRef.methods.getValidatorData(batchNo).call()
    .then((result)=>{
        callback(result);
    })
    .catch((error)=>{
        sweetAlert("Error","Unable to get Exporting Details","error");
        callback(0);
    });
}

function getUserEvents(contractRef)
{
    contractRef.getPastEvents('UserUpdate',{
        fromBlock: 0
    }).then(function (events){
        var dataTable = '';
        if(dataTable != ''){
            dataTable.destroy();
        }
        // $("#tblUser").DataTable().destroy();
        $("#tblUser tbody").html(buildUserDetails(events));
        $("#calculators").html(globUserSelectCal);
        $("#validators").html(globUserSelectVal);
        dataTable = $("#tblUser").DataTable({
            "displayLength": 10,
            "order": [[ 1, "asc" ]]
        });
    }).catch((err)=>{
        console.log(err);
    });
}

function buildUserDetails(events){

    var filteredUser = {};
    var isNewUser = false;

    /*filtering latest updated user record*/
    $(events).each(function(index,event){
        if(filteredUser[event.returnValues.user] == undefined)
        {
            if(users_res.find(user => user.wallet === event.returnValues.user) === undefined){
                return;
            }
            filteredUser[event.returnValues.user] = {};
            filteredUser[event.returnValues.user].address = event.address;
            filteredUser[event.returnValues.user].role = event.returnValues.role;
            filteredUser[event.returnValues.user].user = event.returnValues.user;
            filteredUser[event.returnValues.user].name = users_res.find(user => user.wallet === event.returnValues.user).user_name;
            filteredUser[event.returnValues.user].isActive = event.returnValues.isActive;
            filteredUser[event.returnValues.user].contactNo = event.returnValues.contactNo;
            filteredUser[event.returnValues.user].blockNumber = event.blockNumber;
        }
        else if(filteredUser[event.returnValues.user].blockNumber < event.blockNumber)
        {
            if(users_res.find(user => user.wallet === event.returnValues.user) === undefined){
                return;
            }
            filteredUser[event.returnValues.user].address = event.address;
            filteredUser[event.returnValues.user].role = event.returnValues.role;
            filteredUser[event.returnValues.user].user = event.returnValues.user;
            filteredUser[event.returnValues.user].name = users_res.find(user => user.wallet === event.returnValues.user).user_name;
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
    // globUserData = builtUser
    /*build user Table*/
    $("#totalUsers").html(builtUser.length);
    return buildUserTable(builtUser);
}

function buildUserTable(globUserData){

    var tbody = "";
    var roleClass = "";
    globUserSelectCal = "";
    globUserSelectVal = "";
    $(globUserData).each(function(index,data){

        var role = data.role;

        if(role == 'PRODUCER'){
            roleClass = "info";
        }else if(role == 'CALCULATOR'){
            roleClass = "success";
        }else if(role == 'VERIFIER'){
            roleClass = "primary";
        }
        if(role == 'CALCULATOR') {
            globUserSelectCal += "<option value='"+data.user+"'>" + data.name + "</option>";
        } else if(role == 'VERIFIER'){
            globUserSelectVal += "<option value='"+data.user+"'>" + data.name + "</option>";
        }


        tbody += `<tr>
                        <td>`+data.name+`</td>
                        <td><span class="badge badge-`+roleClass+` font-weight-100">`+role+`</span></td>
                        <td><a href="javascript:void(0);" class="text-inverse p-r-10" data-toggle="tooltip" data-wallet="`+data.user+`" onclick="openEditUser(this);" title="Edit"><img src="`+edit_image_url+`"></a> </td>
                  </tr>`;
    });

    return tbody;
}

function handleTransactionResponse(txHash,finalMessage)
{
    var txLink = "https://sepolia.etherscan.io//tx/" + txHash ;
    var txLinkHref = "<a target='_blank' href='"+txLink+"'> Click here for Transaction Status </a>" ;

    sweetAlert("Success", "Please Check Transaction Status here :  "+txLinkHref, "success");

    $("#linkOngoingTransaction").html(txLinkHref);
    $("#divOngoingTransaction").fadeIn();
    /*scroll to top*/
    $('html, body').animate({ scrollTop: 0 }, 'slow', function () {});
}

function handleTransactionReceipt(receipt,finalMessage)
{
    $("#linkOngoingTransaction").html("");
    $("#divOngoingTransaction").fadeOut();

    // sweetAlert("Success", "Token Purchase Complete ", "success");
    //sweetAlert("Success", finalMessage, "success");

    swal({
        title: "Success",
        text: finalMessage,
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#8CD4F5",
        confirmButtonText: "Ok",
        closeOnConfirm: false
      },
      function(isConfirm)
      {
        if(isConfirm==true)
        {
            window.location = "/dashboard";
        }
      });
    return;
}

function handleGenericError(error_message)
{
    if(error_message.includes("MetaMask Tx Signature"))
    {
        sweetAlert("Error", "Transaction Refused ", "error");
    }
    else
    {
        // sweetAlert("Error", "Error Occured, Please Try Again , if problem persist get in touch with us. ", "error");
        sweetAlert("Error", error_message, "error");
    }

}


function changeSwitchery(element, checked) {
  if ( ( element.is(':checked') && checked == false ) || ( !element.is(':checked') && checked == true ) ) {
    element.parent().find('.switchery').trigger('click');
  }
}

/*==================================Bootstrap Model Start=========================================*/

function startLoader(){
    // $(".preloader").fadeIn();
    $(".preloader").css({'height':'100%'});
}

function stopLoader(){
    // $(".preloader").fadeOut();
    $(".preloader").css({'height':'0'});
}

/*Set Default inactive*/
$("#userFormClick").click(function(){
    $("#userForm").trigger('reset');
    changeSwitchery($("#isActive"),false);
    $("#userModelTitle").html("Add User");
    $("#imageHash").html('');
    $("#userFormModel").modal();
});

/*Edit User Model Form*/
function openEditUser(ref){
    var userAddress = $(ref).attr("data-wallet");
    // startLoader();
    getUserDetailsByAddress(globUserContractEthers,userAddress,function(result){
        console.log(result);
        $("#userWalletAddress").val(userAddress);
        $("#userName").val(users_res.find(user => user.wallet === userAddress).user_name);
        // $("#userContactNo").val(result.contactNo);
        $("#userProfileHash").val(result.profileHash);
        $('#userRoles').val(result.role).prop('selected', true);
        // $('#password').val(result.password);
        var profileImageLink = 'https://ipfs.io/ipfs/'+result.profileHash;

        var btnViewImage = '<a href="'+profileImageLink+'" target="_blank" class=" text-danger"><i class="fa fa-eye"></i> View Image</a>';
        if(result.profileHash){
            $("#imageHash").html(btnViewImage);
            $('#imageUrl').val(profileImageLink);
        }
        // console.log(result.isActive);
        $("#isActive").prop('checked', result.isActive);
        // changeSwitchery($("#isActive"),result.isActive);
        $("#userModelTitle").html("Update User");
        stopLoader();
        $("#userFormModel").modal();
    });
}

// ipfs = window.IpfsApi('localhost', 5001);
// ipfs = window.IpfsApi('ipfs.infura.io', '5001', {protocol: 'https'})


function handleFileUpload(event){
    const file = event.target.files[0];
    saveToIpfs(file)
}

function saveToIpfs(file){

    if (file.size >= 6000000) { // 6mb
        let msj = "file size up limit 6mb.";
        alert(msj);
        throw (msj);
    }

    let formData = new FormData();
    formData.append('file', file);

    let myHeaders = new Headers();
    const projectId = '2CTKJPSesfqh0qTwGVtMus0h5xO';
    const projectSecret = '6ae4107757b4f5a0f6acda39ad819374';
    const auth = 'Basic ' + btoa(projectId + ':' + projectSecret);
    myHeaders.append('Authorization', auth);
    var btnViewImage = '<a href="#" class=" text-danger"> Uploading Image...</a>';
    $("#imageHash").html(btnViewImage);
    fetch('https://ipfs.infura.io:5001/api/v0/add', {
        method: "POST",
        headers: myHeaders,
        body: formData
    }).then((response) => {
        if (response.status >= 400 && response.status < 600) {
            throw new Error("Bad response from server");
        }
        return response.json();
    }).then((json) => {
        var imageHash = json['Hash'];
        var profileImageLink = 'https://ipfs.io/ipfs/'+imageHash;
        btnViewImage = '<a href="'+profileImageLink+'" target="_blank" class=" text-danger"><i class="fa fa-eye"></i> View Image</a>';

        $("#userProfileHash").val(imageHash);
        $("#imageHash").html(btnViewImage);
        $('#imageUrl').val(profileImageLink);

        $("#userFormBtn").prop('disabled',false);
        $("i.fa-spinner").hide();
        //Hash: Qmc5gCcjYypU7y28oCALwfSvxCBskLuPKWpK4qpterKC7z
    }).catch((error) => {
        console.log(error);
    });
}
