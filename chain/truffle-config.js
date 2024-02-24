var HDWalletProvider = require("@truffle/hdwallet-provider");
module.exports = 
{
    networks: 
    {
	    development: 
		{
	   		host: "localhost",
	   		port: 7545,
	   		network_id: "5777" // Match any network id
		},
		//rinkeby
    	sepolia: {
    	    provider: function() {
		      	var mnemonic = "network inner warm double sister lonely pattern hand alone hover day appear";//put ETH wallet 12 mnemonic code	
				//metamask.io
		      	return new HDWalletProvider(mnemonic, "https://eth-sepolia.g.alchemy.com/v2/VfmrCWXL4WbXXLCXY9yzfXV35IgegQmP");
		    },
		    network_id: "11155111",
		    from: '0x148b6c3A901130A1248B748C898F183524BB4Dde',/*ETH wallet 12 mnemonic code wallet address*/
		}  
    },
	compilers: {
		solc: {
		  version: '0.8.0'
		}
	}
};