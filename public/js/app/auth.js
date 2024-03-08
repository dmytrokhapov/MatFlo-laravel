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