// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

import "./ConcreteChainStorageOwnable.sol";

contract ConcreteChainStorage is ConcreteChainStorageOwnable {
    
    constructor() {
        authorizedCaller[msg.sender] = 1;
        emit AuthorizedCaller(msg.sender);
    }
    
    /* Events */
    event AuthorizedCaller(address caller);
    event DeAuthorizedCaller(address caller);
    
    /* Modifiers */
    
    modifier onlyAuthCaller(){
        require(authorizedCaller[msg.sender] == 1);
        _;
    }
    
    /* User Related */
    struct user {
        bool isActive;
        string profileHash;
        address userAddress;
    } 
    
    mapping(address => user) userDetails;
    mapping(string => user) userInfos;
    mapping(address => string) userRole;
    
    /* Caller Mapping */
    mapping(address => uint8) authorizedCaller;
    
    /* authorize caller */
    function authorizeCaller(address _caller) public onlyOwner returns(bool) 
    {
        authorizedCaller[_caller] = 1;
        emit AuthorizedCaller(_caller);
        return true;
    }
    
    /* deauthorize caller */
    function deAuthorizeCaller(address _caller) public onlyOwner returns(bool) 
    {
        authorizedCaller[_caller] = 0;
        emit DeAuthorizedCaller(_caller);
        return true;
    }
    
    /*User Roles
        SUPER_ADMIN,
        PRODUCER,
        CALCULATOR,
        VALIDATOR
    */
    
    /* Process Related */
    struct basicDetails {
        string registrationNo;
        string producerName;
        string factoryAddress;
        uint256 calculators;
        uint256 validators;
        uint256 parts;
    }
    
    struct producer {
        string concreteFamily;
        string typeOfCement;
    }
    
    struct calculator {
        uint256 checksums;
    }    
    
    struct validator {
        uint256 checksums;
    }
    
    mapping (address => basicDetails) batchBasicDetails;
    mapping (address => producer) batchProducer;
    mapping (address => calculator) batchCalculator;
    mapping (address => validator) batchValidator;
    mapping (address => string) nextAction;
    
    user userDetail;
    basicDetails basicDetailsData;
    producer producerData;
    calculator calculatorData;
    validator validatorData;
    
    /* Get User Role */
    function getUserRole(address _userAddress) public onlyAuthCaller view returns(string memory)
    {
        return userRole[_userAddress];
    }
    
    /* Get Next Action  */    
    function getNextAction(address _batchNo) public onlyAuthCaller view returns(string memory)
    {
        return nextAction[_batchNo];
    }
        
    /*set user details*/
    function setUser(address _userAddress,
                     string memory _role, 
                     bool _isActive,
                     string memory _profileHash) public onlyAuthCaller returns(bool){
        
        /*store data into struct*/
        userDetail.isActive = _isActive;
        userDetail.profileHash = _profileHash;
        userDetail.userAddress = _userAddress;
        
        /*store data into mapping*/
        userDetails[_userAddress] = userDetail;

        userRole[_userAddress] = _role;
        
        return true;
    }  
    
    /*get user details*/
    function getUser(address _userAddress) public onlyAuthCaller view returns(
                                                                    string memory role,
                                                                    bool isActive, 
                                                                    string memory profileHash
                                                                ){

        /*Getting value from struct*/
        user memory tmpData = userDetails[_userAddress];
        
        return (userRole[_userAddress], tmpData.isActive, tmpData.profileHash);
    }
    
    /*get batch basicDetails*/
    function getBasicDetails(address _batchNo) public onlyAuthCaller view returns(string memory registrationNo,
                             string memory producerName,
                             string memory factoryAddress,
                             uint256 calculators,
                             uint256 validators,
                             uint256 parts
                             ) {
        
        basicDetails memory tmpData = batchBasicDetails[_batchNo];
        
        return (tmpData.registrationNo, tmpData.producerName, tmpData.factoryAddress, tmpData.calculators, tmpData.validators, tmpData.parts);
    }
    
    /*set batch basicDetails*/
    function setBasicDetails(string memory _registrationNo,
                             string memory _producerName,
                             string memory _factoryAddress,
                             uint256 _calculators,
                             uint256 _validators,
                             uint256 _parts
                            ) public onlyAuthCaller returns(address) {
        
        uint tmpData = uint(keccak256(abi.encode(msg.sender, block.timestamp)));
        address batchNo = address(uint160(tmpData));
        
        basicDetailsData.registrationNo = _registrationNo;
        basicDetailsData.producerName = _producerName;
        basicDetailsData.factoryAddress = _factoryAddress;
        basicDetailsData.calculators = _calculators;
        basicDetailsData.validators = _validators;
        basicDetailsData.parts = _parts;
        
        batchBasicDetails[batchNo] = basicDetailsData;
        
        nextAction[batchNo] = 'CALCULATOR';   
        
        return batchNo;
    }
    

    /*set Calculator data*/
    function setCalculatorData(address batchNo) public onlyAuthCaller returns(bool){

        calculator memory tmpData = batchCalculator[batchNo];
        tmpData.checksums += 1;
        
        batchCalculator[batchNo] = tmpData;
        
        if(tmpData.checksums >= batchBasicDetails[batchNo].parts * batchBasicDetails[batchNo].calculators){
            nextAction[batchNo] = 'VALIDATOR'; 
        }
            
        return true;
    }
    
    /*get Calculator data*/
    function getCalculatorData(address batchNo) public onlyAuthCaller view returns(uint256 checksums){
        
        calculator memory tmpData = batchCalculator[batchNo];
        return (tmpData.checksums);
    }
    
    /*set Validator data*/
    function setValidatorData(address batchNo) public onlyAuthCaller returns(bool){
        
        validator memory tmpData = batchValidator[batchNo];
        tmpData.checksums += 1;
        
        batchValidator[batchNo] = tmpData;
        
        if(tmpData.checksums >= batchBasicDetails[batchNo].parts * batchBasicDetails[batchNo].validators){
            nextAction[batchNo] = 'DONE'; 
        }
        
        return true;
    }
    
    /*get Validator data*/
    function getValidatorData(address batchNo) public onlyAuthCaller view returns(uint256 checksums){
        
        
        validator memory tmpData = batchValidator[batchNo];
        
        return (tmpData.checksums);
                
        
    }
}    
