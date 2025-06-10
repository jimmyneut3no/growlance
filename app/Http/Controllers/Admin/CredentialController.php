<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Credential;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BlockchainService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CredentialController extends Controller
{
        protected $blockchainService;
        public function __construct(BlockchainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }
        public function index()
    {
        $user = Auth::user();
        $credentials = Credential::latest()->first();
        return view('admin.credentials.index', compact('credentials','user'));
    }
    public function restartServer(Request $request)
    {
            $response = $this->blockchainService->restartServer();
            try {            
            if ($response) {
                return redirect()->route('admin.credentials.health')
                    ->with('success', 'Server Restart initiated');
            }
            return back()->with('error', 'Failed to Server Restart Node.js API');
        } catch (\Exception $e) {
            return back()->with('error', 'Error connecting to Node.js API: ' . $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bsc_private_key' => ['required', 'string'],
            'wallet_address' => ['required', 'string'],
            'mnemonic' => ['required', 'string'],
        ]);

        // Send to Node.js API
        try {            
            if (Credential::create($validated)) {
                return redirect()->route('admin.credentials.index')
                    ->with('success', 'Credentials saved successfully');
            }
            
            return back()->with('error', 'Failed to save credentials to Node.js API');
        } catch (\Exception $e) {
            return back()->with('error', 'Error connecting to Node.js API: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Credential $credential)
    {
        $validated = $request->validate([
            'bsc_private_key' => ['required', 'string'],
            'wallet_address' => ['required', 'string'],
            'mnemonic' => ['required', 'string'],
        ]);

        // Send to Node.js API
        try {            
            if ($credential->update($validated)) {
                // Update in database
                return redirect()->route('admin.credentials.index')
                    ->with('success', 'Credentials updated successfully');
            }
            
            return back()->with('error', 'Failed to update credentials in Node.js API');
        } catch (\Exception $e) {
            return back()->with('error', 'Error connecting to Node.js API: ' . $e->getMessage());
        }
    }
public function sweepAll()
{
    $successCount = 0;
    $errorCount = 0;

    User::chunk(200, function ($users) use (&$successCount, &$errorCount) {
        foreach ($users as $user) {
            try {
                $response = $this->blockchainService->sweep($user);
                Log::info('Sweep completed', ['user_id' => $user->id, 'response' => $response]);
                $successCount++;
            } catch (\Exception $e) {
                Log::error('Sweep failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $errorCount++;
            }
        }
    });

    if ($errorCount > 0) {
        return back()->with('error', "Sweep completed with $errorCount errors.");
    }

    return redirect()
        ->route('admin.credentials.index')
        ->with('success', "Successfully swept $successCount wallets!");
}
    public function health()
    {
        try {
            // Fetch data from your Node.js API
            // $response = Http::get(config('services.node_api.url').'/api/health');
            $response = $this->blockchainService->healthCheck();
            // $response->successful()
            // dd($response);
            if ($response['status']) {
                $healthData = $response['data'];
            } else {
                $healthData = $this->getFallbackData();
            }
        } catch (\Exception $e) {
            $healthData = $this->getFallbackData();
        }

        return view('admin.credentials.health', compact('healthData'));
    }

    private function getFallbackData()
    {
        return [
            'status' => 'error',
            'message' => 'Unable to fetch health data',
            'timestamp' => now()->toISOString(),
            'components' => [
                'api' => [
                    'status' => 'error',
                    'uptime' => 0,
                    'memoryUsage' => [
                        'rss' => 0,
                        'heapTotal' => 0,
                        'heapUsed' => 0
                    ]
                ],
                'blockchain' => [
                    'status' => 'error',
                    'network' => 'unknown',
                    'chainId' => 0,
                    'blockNumber' => 0,
                    'gasPrice' => '0 gwei',
                    'lastChecked' => now()->toISOString()
                ]
            ]
        ];
    }
}