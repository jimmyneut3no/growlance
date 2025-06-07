const express = require('express');
const Web3 = require('web3');
const cors = require('cors');
const dotenv = require('dotenv');

dotenv.config();

const app = express();
app.use(cors());
app.use(express.json());

// Initialize Web3
const web3 = new Web3(process.env.BSC_RPC_URL);

// USDT contract ABI (minimal)
const usdtAbi = [
    {
        "constant": true,
        "inputs": [{"name": "_owner", "type": "address"}],
        "name": "balanceOf",
        "outputs": [{"name": "balance", "type": "uint256"}],
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [
            {"name": "_to", "type": "address"},
            {"name": "_value", "type": "uint256"}
        ],
        "name": "transfer",
        "outputs": [{"name": "", "type": "bool"}],
        "type": "function"
    }
];

const usdtContract = new web3.eth.Contract(
    usdtAbi,
    process.env.USDT_CONTRACT_ADDRESS
);

// API key middleware
const apiKeyAuth = (req, res, next) => {
    const apiKey = req.headers['x-api-key'];
    if (!apiKey || apiKey !== process.env.API_KEY) {
        return res.status(401).json({ error: 'Invalid API key' });
    }
    next();
};

// Generate new address
app.post('/generate-address', apiKeyAuth, async (req, res) => {
    try {
        const account = web3.eth.accounts.create();
        res.json({ address: account.address });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Process withdrawal
app.post('/process-withdrawal', apiKeyAuth, async (req, res) => {
    try {
        const { transaction_id, user_id, amount, address } = req.body;
        
        // Convert amount to wei (USDT has 18 decimals)
        const amountWei = web3.utils.toWei(amount.toString(), 'ether');
        
        // Get admin wallet
        const adminAccount = web3.eth.accounts.privateKeyToAccount(
            process.env.ADMIN_PRIVATE_KEY
        );
        
        // Send USDT
        const tx = await usdtContract.methods
            .transfer(address, amountWei)
            .send({
                from: adminAccount.address,
                gas: 100000
            });
        
        res.json({ tx_hash: tx.transactionHash });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Verify transaction
app.get('/verify-transaction', apiKeyAuth, async (req, res) => {
    try {
        const { tx_hash } = req.query;
        const receipt = await web3.eth.getTransactionReceipt(tx_hash);
        
        res.json({
            verified: receipt && receipt.status,
            block_number: receipt ? receipt.blockNumber : null
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Get balance
app.get('/get-balance', apiKeyAuth, async (req, res) => {
    try {
        const { address } = req.query;
        const balance = await usdtContract.methods.balanceOf(address).call();
        
        res.json({
            balance: web3.utils.fromWei(balance, 'ether')
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Blockchain service running on port ${PORT}`);
}); 