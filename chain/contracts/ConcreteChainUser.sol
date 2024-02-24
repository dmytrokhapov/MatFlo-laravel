// SPDX-License-Identifier: MIT

pragma solidity ^0.8.0;
import "./ConcreteChainStorage.sol";
import "./Ownable.sol";

contract ConcreteChainUser is Ownable
{
     /*Events*/ 
    event UserUpdate(address indexed user, string role, bool isActive, string profileHash);
    event UserRoleUpdate(address indexed user, string role); 
    
     /* Storage Variables */    
    ConcreteChainStorage concreteChainStorage;
    
    constructor(address _supplyChainAddress) {
        concreteChainStorage = ConcreteChainStorage(_supplyChainAddress);
    }
    
    
     /* Create/Update User */

    function updateUser(string memory _role, bool _isActive, string memory _profileHash) public returns(bool)
    {
        require(msg.sender != address(0));
        
        /* Call Storage Contract */
        bool status = concreteChainStorage.setUser(msg.sender, _role, _isActive,_profileHash);
        
        /*call event*/
        emit UserUpdate(msg.sender,_role,_isActive,_profileHash);
        emit UserRoleUpdate(msg.sender,_role);
        
        return status;
    }
    
    /* Create/Update User For Admin  */
    function updateUserForAdmin(address _userAddress, string memory _role, bool _isActive, string memory _profileHash) public onlyOwner returns(bool)
    {
        require(_userAddress != address(0));
        
        /* Call Storage Contract */
        bool status = concreteChainStorage.setUser(_userAddress, _role, _isActive, _profileHash);
        
         /*call event*/
        emit UserUpdate(_userAddress,_role,_isActive,_profileHash);
        emit UserRoleUpdate(_userAddress,_role);
        
        return status;
    }
    
    /* get User */
    function getUser(address _userAddress) public view returns(string memory role, bool isActive , string memory profileHash){
        require(_userAddress != address(0));
        
        /*Getting value from struct*/
       (role, isActive, profileHash) = concreteChainStorage.getUser(_userAddress);
       
       return (role, isActive, profileHash);
    }

}
