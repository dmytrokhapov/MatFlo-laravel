var ConcreteChainStorage = artifacts.require("./ConcreteChainStorage");
var ConcreteSupplyChain = artifacts.require("./ConcreteChain");
var ConcreteChainUser = artifacts.require("./ConcreteChainUser");


module.exports = function(deployer){
	deployer.deploy(ConcreteChainStorage)
	.then(()=>{
		return deployer.deploy(ConcreteSupplyChain,ConcreteChainStorage.address);
	})
	.then(()=>{
		return deployer.deploy(ConcreteChainUser,ConcreteChainStorage.address);
	})
	.then(()=>{
   		return ConcreteChainStorage.deployed();
    }).then(async function(instance){
		await instance.authorizeCaller(ConcreteSupplyChain.address); 
		console.log('d')
		await instance.authorizeCaller(ConcreteChainUser.address);
		return instance;
	})
	.catch(function(error)
	{
		console.log(error);
	});
};



