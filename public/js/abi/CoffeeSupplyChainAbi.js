var CoffeeSupplyChainAbi = [
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_supplyChainAddress",
				"type": "address"
			}
		],
		"stateMutability": "nonpayable",
		"type": "constructor"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "user",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "batchNo",
				"type": "address"
			}
		],
		"name": "DoneExporting",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "user",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "batchNo",
				"type": "address"
			}
		],
		"name": "DoneHarvesting",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "user",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "batchNo",
				"type": "address"
			}
		],
		"name": "DoneInspection",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "previousOwner",
				"type": "address"
			}
		],
		"name": "OwnershipRenounced",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "previousOwner",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "newOwner",
				"type": "address"
			}
		],
		"name": "OwnershipTransferred",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "user",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "batchNo",
				"type": "address"
			}
		],
		"name": "PerformCultivation",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_sender",
				"type": "address"
			},
			{
				"internalType": "string",
				"name": "_registrationNo",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "_producerName",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "_factoryAddress",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "_calculators",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "_validators",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "_parts",
				"type": "uint256"
			},
			{
				"internalType": "address[]",
				"name": "_calculatorAddress",
				"type": "address[]"
			},
			{
				"internalType": "address[]",
				"name": "_validatorAddress",
				"type": "address[]"
			}
		],
		"name": "addBasicDetails",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_batchNo",
				"type": "address"
			}
		],
		"name": "getBasicDetails",
		"outputs": [
			{
				"internalType": "string",
				"name": "registrationNo",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "producerName",
				"type": "string"
			},
			{
				"internalType": "string",
				"name": "factoryAddress",
				"type": "string"
			},
			{
				"internalType": "uint256",
				"name": "calculators",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "validators",
				"type": "uint256"
			},
			{
				"internalType": "uint256",
				"name": "parts",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_batchNo",
				"type": "address"
			}
		],
		"name": "getCalculatorData",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "checksums",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_batchNo",
				"type": "address"
			}
		],
		"name": "getNextAction",
		"outputs": [
			{
				"internalType": "string",
				"name": "action",
				"type": "string"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_batchNo",
				"type": "address"
			}
		],
		"name": "getValidatorData",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "checksums",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "owner",
		"outputs": [
			{
				"internalType": "address",
				"name": "",
				"type": "address"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "renounceOwnership",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "newOwner",
				"type": "address"
			}
		],
		"name": "transferOwnership",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_sender",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "_batchNo",
				"type": "address"
			}
		],
		"name": "updateCalculatorData",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "_sender",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "_batchNo",
				"type": "address"
			}
		],
		"name": "updateValidatorData",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	}
]