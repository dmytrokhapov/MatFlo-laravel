// SPDX-License-Identifier: MIT

pragma solidity ^0.8.0;
import "./ConcreteChainStorage.sol";
import "./Ownable.sol";

contract ConcreteChain is Ownable
{
  
    event PerformCultivation(address indexed user, address indexed batchNo);
    event DoneInspection(address indexed user, address indexed batchNo);
    event DoneHarvesting(address indexed user, address indexed batchNo);
    event DoneExporting(address indexed user, address indexed batchNo);
    
    /*Modifier*/
    modifier isValidPerformer(address sender, address batchNo, string memory role) {
    
        require(keccak256(abi.encode(concreteChainStorage.getUserRole(sender))) == keccak256(abi.encode(role)));
        require(keccak256(abi.encode(concreteChainStorage.getNextAction(batchNo))) == keccak256(abi.encode(role)));
        _;
    }

    modifier isValidCalculator(address sender, address batchNo) {
        bool isAllowed = false;
        for (uint256 i = 0; i < allowedCalculators[batchNo].length; i++) {
            if (sender == allowedCalculators[batchNo][i]) {
                isAllowed = true;
                break;
            }
        }
        require(isAllowed, "Access denied.");
        _;
    }

    modifier isValidValidator(address sender, address batchNo) {
        bool isAllowed = false;
        for (uint256 i = 0; i < allowedValidators[batchNo].length; i++) {
            if (sender == allowedValidators[batchNo][i]) {
                isAllowed = true;
                break;
            }
        }
        require(isAllowed, "Access denied.");
        _;
    }

    modifier isProducer(address sender, string memory role) {
    
        require(keccak256(abi.encode(concreteChainStorage.getUserRole(sender))) == keccak256(abi.encode(role)));
        _;
    }
    
    /* Storage Variables */    
    ConcreteChainStorage concreteChainStorage;

    mapping(address => address[]) allowedCalculators;
    mapping(address => address[]) allowedValidators;
    
    constructor(address _supplyChainAddress) {
        concreteChainStorage = ConcreteChainStorage(_supplyChainAddress);
    }
    
    
    /* Get Next Action  */    

    function getNextAction(address _batchNo) public view returns(string memory action)
    {
       (action) = concreteChainStorage.getNextAction(_batchNo);
       return (action);
    }
    

    /* get Basic Details */
    
    function getBasicDetails(address _batchNo) public view returns (string memory registrationNo,
                                                                     string memory producerName,
                                                                     string memory factoryAddress,
                                                                     uint256 calculators,
                             uint256 validators,
                             uint256 parts) {
        /* Call Storage Contract */
        (registrationNo, producerName, factoryAddress, calculators, validators, parts) = concreteChainStorage.getBasicDetails(_batchNo);  
        return (registrationNo, producerName, factoryAddress, calculators, validators, parts);
    }

    /* perform Basic Cultivation */
    
    function addBasicDetails(address _sender,
                             string memory _registrationNo,
                             string memory _producerName,
                             string memory _factoryAddress,
                             uint256 _calculators,
                             uint256 _validators,
                             uint256 _parts,
                             address[] calldata _calculatorAddress,
                             address[] calldata _validatorAddress
                            ) public isProducer(_sender, 'PRODUCER') returns(address) {
    
        address batchNo = concreteChainStorage.setBasicDetails(_registrationNo,
                                                            _producerName,
                                                            _factoryAddress,
                                                            _calculators,
                                                            _validators,
                                                            _parts);
        allowedCalculators[batchNo] = _calculatorAddress;
        allowedValidators[batchNo] = _validatorAddress;
        
        emit PerformCultivation(_sender, batchNo); 
        
        return (batchNo);
    }                            

    /* get Calculate */
    
    function getCalculatorData(address _batchNo) public view returns (uint256 checksums) {
        /* Call Storage Contract */
        (checksums) =  concreteChainStorage.getCalculatorData(_batchNo);  
        return (checksums);
    }
    
    /* perform Calculate */
    
    function updateCalculatorData(address _sender, address _batchNo) 
                                public isValidPerformer(_sender, _batchNo,'CALCULATOR') isValidCalculator(_sender, _batchNo) returns(bool) {
                                    
        /* Call Storage Contract */
        bool status = concreteChainStorage.setCalculatorData(_batchNo);  
        
        emit DoneHarvesting(_sender, _batchNo);
        return (status);
    }
    
    /* get Validator */
    
    function getValidatorData(address _batchNo) public view returns (uint256 checksums) {
        /* Call Storage Contract */
       (checksums) =  concreteChainStorage.getValidatorData(_batchNo);  
        
        return (checksums);
    }
    
    /* perform Validate */
    
    function updateValidatorData(address _sender, address _batchNo) 
                                public isValidPerformer(_sender, _batchNo,'VALIDATOR') isValidValidator(_sender, _batchNo) returns(bool) {
                                    
        /* Call Storage Contract */
        bool status = concreteChainStorage.setValidatorData(_batchNo);  
        
        emit DoneExporting(_sender, _batchNo);
        return (status);
    }
    
}
