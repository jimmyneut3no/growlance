<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\BlockchainService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    public function index()
    {
        $user = Auth::user();
        $balance = $user->getBalance();
        $pendingDeposits = $user->walletTransactions()
            ->where('type', 'deposit')
            ->where('status', 'pending')
            ->get();

        return view('wallet.index', compact('balance', 'pendingDeposits'));
    }

    public function deposit()
    {
        $user = Auth::user();
        $pendingDeposits = $user->walletTransactions()
            ->where('type', 'deposit')
            ->where('status', 'pending')
            ->get();
$emptyQr = 'No Image Available';
try {
    $address = $this->blockchainService->getDepositAddress($user);
} catch (\Exception $e) {
    // Log the error for admin/devs
    Log::error('Failed to generate deposit address: '.$e->getMessage());
    $address = null;
}

// Generate QR code or fallback
$qrCode = $address ? QrCode::size(200)->generate($address) : $emptyQr;
$address = $address ?? 'Wallet Address Unavailable';

// You should also make sure $pendingDeposits is defined
return view('wallet.deposit', compact('address', 'pendingDeposits', 'qrCode'));

    }
        public function viewWithdrawal()
    {
        $user = Auth::user();
        $balance = $user->getBalance();
        $pendingWithdraw = $user->walletTransactions()
            ->where('type', 'deposit')
            ->where('status', 'pending')
            ->get();
        
        return view('wallet.withdraw', compact('balance', 'pendingWithdraw'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.5', 'max:10000'],
            'address' => ['required', 'string', 'regex:/^0x[a-fA-F0-9]{40}$/'],
        ]);

        $user = Auth::user();
        if ($user->getBalance() < $request->amount) {
            return back()->with('error', 'Insufficient balance');
        }

        try {
            // DB::beginTransaction();

        // Create withdrawal transaction
        $transaction = [
            'userId' => $user->id,
            'amount' => $request->amount,
            'from' => 'OWNER_ADDRESS',
            'to' => $request->address
        ];
            // Process withdrawal through blockchain service
            $result = $this->blockchainService->processWithdrawal($transaction);
            if ($result) {
                return redirect()->route('wallet.index')->with('success', 'Withdrawal request submitted successfully');
            } else {
                return back()->with('error', 'Failed to process withdrawal');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process withdrawal');
        }
    }

    public function transactions()
    {
        $transactions = Auth::user()->walletTransactions()
            ->latest()
            ->paginate(15);

        return view('wallet.transactions', compact('transactions'));
    }

    public function webhook(Request $request)
{
    if (!$this->blockchainService->verifyWebhookSignature($request)) {
    Log::info(["data"=> 'Invalid signature']);
        return response()->json(['error' => 'Invalid signature'], 401);
    }

    try {
        DB::beginTransaction();

        $data = $request->all();
        $transaction = WalletTransaction::where('transaction_hash', $data['txHash'])->first();

        if ($transaction && $data['status'] == 'completed') {
            $transaction->update(['status' => 'completed']);
        } else {
            $amount = (float) $data['amount'];
DB::transaction(function () use ($data, $amount) {
    WalletTransaction::create([
        'user_id' => $data['userId'],
        'type' => $data['type'],
        'amount' => $amount,
        'status' => $data['status'],
        'transaction_hash' => $data['txHash'],
        'from_address' => $data['from'],
        'to_address' => $data['to'],
    ]);

    if ($data['type'] === 'withdrawal') {
        $fee = round(0.02 * $amount, 2);

        WalletTransaction::create([
            'user_id' => $data['userId'],
            'type' => 'fee',
            'amount' => $fee,
            'status' => $data['status'],
            'transaction_hash' => $data['txHash'],
            'from_address' => $data['from'],
            'to_address' => $data['to'],
        ]);
    }
});

        }

        DB::commit();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Webhook processing failed', [
            'exception' => $e->getMessage(),
            'data' => $request->all(),
        ]);

        return response()->json(['error' => 'Failed to process webhook'], 500);
    }
}

} 