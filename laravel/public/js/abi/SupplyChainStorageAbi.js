var SupplyChainStorageAbi = [
	{
		"inputs": [],
		"stateMutability": "nonpayable",
		"type": "constructor"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "address",
				"name": "caller",
				"type": "address"
			}
		],
		"name": "AuthorizedCaller",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"internalType": "address",
				"name": "caller",
				"type": "address"
			}
		],
		"name": "DeAuthorizedCaller",
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
		"inputs": [
			{
				"internalType": "address",
				"name": "_caller",
				"type": "address"
			}
		],
		"name": "authorizeCaller",
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
				"name": "_caller",
				"type": "address"
			}
		],
		"name": "deAuthorizeCaller",
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
				"name": "batchNo",
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
				"name": "",
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
				"name": "_userAddress",
				"type": "address"
			}
		],
		"name": "getUser",
		"outputs": [
			{
				"internalType": "string",
				"name": "role",
				"type": "string"
			},
			{
				"internalType": "bool",
				"name": "isActive",
				"type": "bool"
			},
			{
				"internalType": "string",
				"name": "profileHash",
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
				"name": "_userAddress",
				"type": "address"
			}
		],
		"name": "getUserRole",
		"outputs": [
			{
				"internalType": "string",
				"name": "",
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
				"name": "batchNo",
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
			}
		],
		"name": "setBasicDetails",
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
				"name": "batchNo",
				"type": "address"
			}
		],
		"name": "setCalculatorData",
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
				"name": "_userAddress",
				"type": "address"
			},
			{
				"internalType": "string",
				"name": "_role",
				"type": "string"
			},
			{
				"internalType": "bool",
				"name": "_isActive",
				"type": "bool"
			},
			{
				"internalType": "string",
				"name": "_profileHash",
				"type": "string"
			}
		],
		"name": "setUser",
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
				"name": "batchNo",
				"type": "address"
			}
		],
		"name": "setValidatorData",
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
				"name": "newOwner",
				"type": "address"
			}
		],
		"name": "transferOwnership",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	}
]