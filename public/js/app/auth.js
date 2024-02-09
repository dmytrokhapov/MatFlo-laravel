function hashCode(str) {
    var hash = 0, i, chr;
    if (str.length === 0) return hash;
    for (i = 0; i < str.length; i++) {
        chr = str.charCodeAt(i);
        hash = ((hash << 5) - hash) + chr;
        hash |= 0; // Convert to 32bit integer
    }
    return hash>>>0;
}
function signUp () {
    var userName          = $("#userName").val();
    var userContactNo     = $("#userContactNo").val();
    var userPassword     = $("#password").val();
    var userRoles         = $("#userRoles").val();
    if(!userName || !userPassword || !userRoles) {
        handleGenericError("Please fill all the information.");
        return;
    }
    const wallet = ethers.Wallet.createRandom();
    $("#wallet").val(wallet.address);
    $("#btnSignUp").attr('disabled','disabled');
    $("#formSignUp").submit();
}

function postSignUp(wallet, role, image) {
    try {
        console.log(wallet,role,image);
        startLoader();
        var tx = globUserContractEthers.updateUserForAdmin(wallet, role, false, image)
        tx.then(function(transaction) {
            transaction.wait()
            .then(function(transactionReceipt) {
                stopLoader();
                receiptMessage = "You are registered successfully. Wait until the administrator approves you.";
                handleTransactionReceipt(transactionReceipt, receiptMessage);
            })
            .catch(function(error) {
                stopLoader();
                swal({
                    title: "Failed",
                    text: "Blockchain transaction failed. Please try again.",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Try Again",
                    closeOnConfirm: false
                  },
                  function(isConfirm)
                  {
                    if(isConfirm==true)
                    {
                      postSignUp(wallet, role, image)
                    }
                  });
                return;
            });
        }).catch(function(error) {
            stopLoader();
            // stopLoader();
            swal({
                title: "Failed",
                text: "Blockchain transaction failed. Please try again.",
                type: "error",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Try Again",
                closeOnConfirm: false
            },
            function(isConfirm)
            {
                if(isConfirm==true)
                {
                    postSignUp(wallet, role, image)
                }
            });
            return;
        });


    } catch (error) {
        stopLoader();
        swal({
            title: "Failed",
            text: "Blockchain transaction failed. Please try again.",
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Try Again",
            closeOnConfirm: false
        },
        function(isConfirm)
        {
            if(isConfirm==true)
            {
                postSignUp(wallet, role, image)
            }
        });
        return;
    }
}

function signIn() {
    var userName         = $("#userName").val();
    var userPassword     = $("#password").val();
    $("#btnSignIn").attr('disabled','disabled');
    $("#formSignIn").submit();
    globUserContractEthers.getUserByName(userName)
    .then((result)=>{
        if(result.userAddress == "0x0000000000000000000000000000000000000000"){
            sweetAlert("Error","Input correct information.","error");
        } else if(result.password !== hashCode(userPassword).toString()) {
            sweetAlert("Error","Password is wrong.","error");
        } else if(result.isActive == false){
            sweetAlert("Error","Wait until the administrator approves you.","error");
        } else {
            var user = {'address': result.userAddress};
            // sessionStorage.setItem('user', JSON.stringify(user));
            window.location = "user.php";
        }
        $("#btnSignIn").removeAttr('disabled');
        $("#btnSignIn").html('Sign In');
    })
    .catch((error)=>{
        sweetAlert("Error","Unable to get Details","error");
        $("#btnSignIn").removeAttr('disabled');
        $("#btnSignIn").html('Sign In');
        return;
    });
}
