
npm install -g truffle
npm install @truffle/hdwallet-provider

truffle compile
# deploy to the network
truffle migrate --network sepolia reset 
# in the terminal window, find the contract address in the section: #Deploying 'CoffeeSupplyChain', 'SupplyChainUser', 'SupplyChainStorage'
# copy them to ui/js/app/app.js

#https://www.alchemy.com/
#https://sepoliafaucet.com/


