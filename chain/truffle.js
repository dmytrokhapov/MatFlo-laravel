var HDWalletProvider = require("@truffle/hdwallet-provider");
module.exports = 
{
    networks: 
    {
	    development: 
		{
	   		host: "localhost",
	   		port: 8545,
	   		network_id: "*" // Match any network id
		},
    	sepolia: {
    	    provider: function() {
		      var mnemonic = "memory critic fee grief open appear outer fan silent tooth about wool";//put ETH wallet 12 mnemonic code	
		      return new HDWalletProvider(mnemonic, "https://eth-sepolia.g.alchemy.com/v2/aOMCRe9xE85gvm7xugtsqnocMnr4yCwa");
		    },
		    network_id: '11155111',
		    from: '0x669c7b5fd8f40D84d592fa7549F6D2f644f948fC',/*ETH wallet 12 mnemonic code wallet address*/
            networkCheckTimeout: 10000,
            timeoutBlocks: 200
		
        }  
    },
    compilers: {
        solc: {
            version: '^0.4.23'
        }
    }
};