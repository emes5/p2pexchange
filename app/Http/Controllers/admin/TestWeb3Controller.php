<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repository\CustomTokenRepository;
use App\Services\ERC20TokenApi;
use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Web3;
use Web3p\EthereumTx\Transaction;

class TestWeb3Controller extends Controller
{

    public function index()
    {
        $api =  new ERC20TokenApi();
        $repo = new CustomTokenRepository();
        $requestData = array(
            "type" => 1,
            "address" => "0xC0F7812d5050bC86063Cf9Af09843df5a3823e05",
        );
//        $data = $api->checkWalletBalance($requestData);
//        $data = $api->createNewWallet();
        $requestData = [
            "amount_value" => 3,
            "from_address" => "0xf2DF582ab8bA0C7E57e897Ca3371AAbB68648CA8",
            "to_address" => "0xe0eAf3B1eBc93e6f85F94c614122E3C15dADCFf9"
        ];
//        $data = $api->checkEstimateGas($requestData);
//        $requestData = [
//            "amount_value" => 2 ,
//            "from_address" => "0xC0F7812d5050bC86063Cf9Af09843df5a3823e05",
//            "to_address" => "0xf2DF582ab8bA0C7E57e897Ca3371AAbB68648CA8",
//        ];
//        $data1 = $api->checkEstimateGas($requestData);
//        $data2 = $api->sendCustomToken($requestData);
//        $requestData = [
//            "transaction_hash" => "0xc1ae54ede7aa0a49a567fb245cfac42472eeba8587d2e4592f5c84b08486b879",
//        ];
//        $data = $api->getTransactionData($requestData);
//        $requestData = [
//            "amount_value" => 4,
//            "from_address" => "0xf2DF582ab8bA0C7E57e897Ca3371AAbB68648CA8",
//            "to_address" => "0xe0eAf3B1eBc93e6f85F94c614122E3C15dADCFf9",
//        ];
//        $data = $api->sendEth($requestData);
//        $data = $api->getContractTransferEvent();

//        $wallet = WalletAddressHistory::where('id',21)->first();
//        $walletPk = explode('0x3536397468DAB2e10e6affEC584ee1B0af80d727',$wallet->pk);
        $data = $repo->depositCustomToken();
        dd($data);
    }
    public function testWeb3()
    {
        try {
            $networkChain = 'https://data-seed-prebsc-1-s1.binance.org:8545';
            $contractAddress = "";
            $myAddress = "0xf2DF582ab8bA0C7E57e897Ca3371AAbB68648CA8";
            $toAddress = "0xfA82053B9Cc96D0c249Eb694913956eeB6684FF0";
            $privateKey = "";
            $hash = '';
            $timeout = 30;
            $amount = 1;

            $web3 = new Web3(new HttpProvider(new HttpRequestManager($networkChain,$timeout)));
            $eth = $web3->getEth();
            $utils = $web3->getUtils();
            $contract = new Contract( new HttpProvider(new HttpRequestManager($networkChain, $timeout)) , $this->contractAbi());
//            $tx = [
//                'from' => $myAddress,
//                'to'=> $contractAddress,
//                'gas' => 216200,
//                'data' =>  $contract->methods->transfer($toAddress, $amount).encodeABI(),
//            ];
//            $checkVersion = $this->checkVersion($web3);
//            $checkEthMainBalance = $this->checkEthMainBalance($eth,$utils,$myAddress);
//            $checkTokenBalance = $this->checkTokenBalance($contract,$utils,$contractAddress,$myAddress);
//            $checkAddress = $this->checkAddress($utils,$toAddress);
//            $gasPrice = $this->getGasPrice($eth,$utils);
//            $gas = $this->getEstimateGas($contract,$contractAddress,$myAddress,$toAddress,$amount);
//            $gasFees = $this->calculateEstimateGasFees($eth,$utils,$contract,$contractAddress,$myAddress,$toAddress,$amount);
//            $send = $this->sendETH($eth,$contract,$contractAddress,$myAddress,$toAddress,$amount,$privateKey,$utils);
//            $send = $this->sendCustomToken($contract,$contractAddress,$myAddress,$toAddress,$amount,$privateKey);
//            $hashDetails = $this->getTransactionDetailsByHash($eth,$hash);
//            $hashDetails = $this->getTransactionReceipt($eth,$hash);
            $unlock = $this->unlockAccount($web3,$myAddress,$privateKey);
            dd($unlock);
        } catch (\Exception $e) {
            dd('exception -> '. $e->getMessage());
        }

    }

    public function sendCustomToken($contract,$contractAddress,$fromAddress,$toAddress,$amount, $privateKey)
    {
        $tr = '';
        $data = $contract->getData('transfer', $toAddress, $amount);

//        $params = [
//            'nonce' => 1,
//            'from' => $fromAddress,
//            'to' => $contractAddress,
//            'gas'=> 216200,
//            'data' => sprintf('0x%s', $data)
//        ];
        $transaction = new Transaction([
            'nonce' => 15,
            'from' => $fromAddress,
            'to' => $contractAddress,
            'gas' => 216200,
            'value' => 1,
            'chainId' => 97, // Live - 56 / test - 97
            'data' => sprintf('0x%s', $data),
        ]);
//        dd($transaction);
        /* Sign Transaction */
        $signedTransaction = $transaction->sign($privateKey);
//        dd($signedTransaction);
        $contract->at($contractAddress)->send('transfer', $toAddress,$amount, function ($err, $transaction) use (&$tr) {
            if ($err !== null) {
                dd('eeror '.$err->getMessage());
            }
            $tr = $transaction;
        });

        return $tr;
    }
    public function sendETH($eth,$contract,$contractAddress,$fromAddress,$toAddress,$amount,$privateKey,$utils)
    {
        $trxResponse = '';
        $eth->getTransactionCount($fromAddress, 'pending', function ($err, $nonce) use ($eth,$fromAddress,$toAddress,$privateKey,$trxResponse) {
            if ($err !== null) {
                echo "Error: " . $err->getMessage();
            }
//            dd($nonce->toString());
//        $getGasPrice = $this->getGasPrice($eth,$utils);
//        $gasEstimate = $this->getEthEstimateGas($eth,$fromAddress);
//        dd($getGasPrice*$gasEstimate);

//        $data = $contract->getData('transfer', $toAddress, $amount);
//        $value = $utils->toWei(strval($amount),'ether');
            $value = '0x9184e72a';
//        dd($value);
//        $value1 = $utils->toHex(($amount),false);
//        dd($value,$value1);
            $transaction = new Transaction([
                'nonce' => 15,
                'from' => $fromAddress,
                'to' => $toAddress,
                'gas' => 20000000,
                'value' => 1,
                'chainId' => 97, // Live - 56 / test - 97
//            'data' => sprintf('0x%s', $data),
            ]);
//        dd($transaction);
            /* Sign Transaction */
            $signedTransaction = $transaction->sign($privateKey);

            /* Send Raw Transaction */
            $eth->sendRawTransaction('0x' . $signedTransaction, function ($error, $txn) use (&$trxResponse) {

                if ($error) {
                    $trxResponse = (object)['status' => false, 'message' => $error->getMessage()];
                    dd($trxResponse);
                    return false;
                }

                $trxResponse = (object)['status' => true, 'txn_hash' => $txn];

            });
        });
        return $trxResponse;
    }

    public function unlockAccount($web3,$myAddress,$phrase)
    {
        $response = '';
        $web3->personal->unlockAccount($myAddress, $phrase, 30, function ($err, $res) use(&$response) {
            if ($err) {
                $response = (object)['status' => false, 'message' => $err->getMessage()];
                dd($response);
            }
            $response = (object)['status' => true, 'data' => $res];
        });

        return $response;
    }
    public function checkAddress($utils,$address)
    {
        $check = $utils->isAddress($address);

        return $check;
    }

    public function getGasPrice($eth,$utils)
    {
        $gasPrice = '';
        $eth->gasPrice( function ($err, $price) use (&$gasPrice,$utils) {
            if ($err !== null) {
                dd(" error: ".$err->getMessage());
            } else {
                list($bnq, $bnr) = $utils->fromWei($price->toString(),'ether');
                $gasPrice =  $bnq->toString() . '.' . str_pad($bnr->toString(), 18, '0', STR_PAD_LEFT);
            }
        }) ;

        return $gasPrice;
    }

    public function getTransactionDetailsByHash($eth,$hash)
    {
        $details = '';
        $eth->getTransactionByHash($hash, function ($err, $data) use (&$details) {
            if ($err !== null) {
                dd(" error: ".$err->getMessage());
            } else {
                $details = $data;
            }
        }) ;

        return $details;
    }
    public function getTransactionReceipt($eth,$hash)
    {
        $details = '';
        $eth->getTransactionReceipt($hash, function ($err, $data) use (&$details) {
            if ($err !== null) {
                dd(" error: ".$err->getMessage());
            } else {
                $details = $data;
            }
        }) ;

        return $details;
    }

    public function getEthEstimateGas($eth, $address)
    {
        $gasEstimate = '';
        $eth->estimateGas(['from' => $address], function ($err, $gas) use (&$gasEstimate) {
            if ($err !== null) {
                dd('error '.$err->getMessage());
            }
            $gasEstimate = $gas->toString();
        });
        return $gasEstimate;
    }
    public function getEstimateGas($contract,$contractAddress,$fromAddress,$toAddress,$amount)
    {
        $estimateGas = '';
        $data = $contract->getData('transfer', $toAddress, $amount);

        $params = [
            'nonce' => 1,
            'from' => $fromAddress,
            'to' => $contractAddress,
            'gas'=> 216200,
            'data' => sprintf('0x%s', $data)
        ];

        $contract->at($contractAddress)->estimateGas('transfer', $fromAddress, $amount, $params, function ($err, $gas) use (&$estimateGas) {
            if ($err !== null) {
               dd('eeror '.$err->getMessage());
            }
            $estimateGas = $gas->toString();
        });

        return $estimateGas;
    }

    public function calculateEstimateGasFees($eth,$utils,$contract,$contractAddress,$myAddress,$toAddress,$amount)
    {
        $estimateGasFees = 0;
        $gasPrice = $this->getGasPrice($eth,$utils);
        $gas = $this->getEstimateGas($contract,$contractAddress,$myAddress,$toAddress,$amount);
        $estimateGasFees = $gasPrice * $gas;

        return $estimateGasFees;
    }
    public function checkEthMainBalance($eth,$utils,$address)
    {
        $myEthBalance = '';
        $eth->getBalance($address, function ($err, $balance) use (&$myEthBalance,$utils) {
            if ($err !== null) {
                dd(" error: ".$err->getMessage());
            } else {
                list($bnq, $bnr) = $utils->fromWei($balance->value,'ether');
                $myEthBalance =  $bnq->toString() . '.' . str_pad($bnr->toString(), 18, '0', STR_PAD_LEFT);
            }
        }) ;

        return $myEthBalance;
    }

    public function checkTokenBalance($contract,$utils,$contractAddress,$address)
    {
        $myTokenBalance = '';
        $contract->at($contractAddress)->call('balanceOf', $address, function ($err, $data) use(&$myTokenBalance, $utils) {
            if ($err !== null) {
                dd(" error: ".$err->getMessage());
            } else {
                list($bnq, $bnr) = $utils->fromWei($data[0]->value,'picoether');
                $myTokenBalance = $bnq->toString() . '.' . str_pad($bnr->toString(), 6, '0', STR_PAD_LEFT);
            }
        });

        return $myTokenBalance;
    }

    public function createNewAccount($web3)
    {
        $newAccount = '';
//            dd($web3->getPersonal());
        $web3->personal->newAccount('123456', function ($err, $account) use (&$newAccount) {
            if ($err !== null) {
                dd( 'Error: ' . $err->getMessage());
            }
            $newAccount = $account;
        });

        return $newAccount;
    }

    public function checkVersion($web3)
    {
        $checkVersion = '';
        $web3->clientVersion(function ($err, $version) use(&$checkVersion) {
            if ($err !== null) {
                dd(" error: ".$err->getMessage());
            }
            if (isset($version)) {
                $checkVersion = $version;
            }
        });

        return $checkVersion;
    }
    public function contractAbi()
    {
        return [
            [
                "inputs" => [
                ],
                "stateMutability" => "nonpayable",
                "type" => "constructor"
            ],
            [
                "anonymous" => false,
                "inputs" => [
                    [
                        "indexed" => true,
                        "internalType" => "address",
                        "name" => "owner",
                        "type" => "address"
                    ],
                    [
                        "indexed" => true,
                        "internalType" => "address",
                        "name" => "spender",
                        "type" => "address"
                    ],
                    [
                        "indexed" => false,
                        "internalType" => "uint256",
                        "name" => "value",
                        "type" => "uint256"
                    ]
                ],
                "name" => "Approval",
                "type" => "event"
            ],
            [
                "inputs" => [
                    [
                        "internalType" => "address",
                        "name" => "spender",
                        "type" => "address"
                    ],
                    [
                        "internalType" => "uint256",
                        "name" => "amount",
                        "type" => "uint256"
                    ]
                ],
                "name" => "approve",
                "outputs" => [
                    [
                        "internalType" => "bool",
                        "name" => "",
                        "type" => "bool"
                    ]
                ],
                "stateMutability" => "nonpayable",
                "type" => "function"
            ],
            [
                "inputs" => [
                    [
                        "internalType" => "address",
                        "name" => "spender",
                        "type" => "address"
                    ],
                    [
                        "internalType" => "uint256",
                        "name" => "subtractedValue",
                        "type" => "uint256"
                    ]
                ],
                "name" => "decreaseAllowance",
                "outputs" => [
                    [
                        "internalType" => "bool",
                        "name" => "",
                        "type" => "bool"
                    ]
                ],
                "stateMutability" => "nonpayable",
                "type" => "function"
            ],
            [
                "inputs" => [
                    [
                        "internalType" => "address",
                        "name" => "spender",
                        "type" => "address"
                    ],
                    [
                        "internalType" => "uint256",
                        "name" => "addedValue",
                        "type" => "uint256"
                    ]
                ],
                "name" => "increaseAllowance",
                "outputs" => [
                    [
                        "internalType" => "bool",
                        "name" => "",
                        "type" => "bool"
                    ]
                ],
                "stateMutability" => "nonpayable",
                "type" => "function"
            ],
            [
                "anonymous" => false,
                "inputs" => [
                    [
                        "indexed" => true,
                        "internalType" => "address",
                        "name" => "previousOwner",
                        "type" => "address"
                    ],
                    [
                        "indexed" => true,
                        "internalType" => "address",
                        "name" => "newOwner",
                        "type" => "address"
                    ]
                ],
                "name" => "OwnershipTransferred",
                "type" => "event"
            ],
            [
                "inputs" => [
                ],
                "name" => "renounceOwnership",
                "outputs" => [
                ],
                "stateMutability" => "nonpayable",
                "type" => "function"
            ],
            [
                "inputs" => [
                    [
                        "internalType" => "address",
                        "name" => "recipient",
                        "type" => "address"
                    ],
                    [
                        "internalType" => "uint256",
                        "name" => "amount",
                        "type" => "uint256"
                    ]
                ],
                "name" => "transfer",
                "outputs" => [
                    [
                        "internalType" => "bool",
                        "name" => "",
                        "type" => "bool"
                    ]
                ],
                "stateMutability" => "nonpayable",
                "type" => "function"
            ],
            [
                "anonymous" => false,
                "inputs" => [
                    [
                        "indexed" => true,
                        "internalType" => "address",
                        "name" => "from",
                        "type" => "address"
                    ],
                    [
                        "indexed" => true,
                        "internalType" => "address",
                        "name" => "to",
                        "type" => "address"
                    ],
                    [
                        "indexed" => false,
                        "internalType" => "uint256",
                        "name" => "value",
                        "type" => "uint256"
                    ]
                ],
                "name" => "Transfer",
                "type" => "event"
            ],
            [
                "inputs" => [
                    [
                        "internalType" => "address",
                        "name" => "sender",
                        "type" => "address"
                    ],
                    [
                        "internalType" => "address",
                        "name" => "recipient",
                        "type" => "address"
                    ],
                    [
                        "internalType" => "uint256",
                        "name" => "amount",
                        "type" => "uint256"
                    ]
                ],
                "name" => "transferFrom",
                "outputs" => [
                    [
                        "internalType" => "bool",
                        "name" => "",
                        "type" => "bool"
                    ]
                ],
                "stateMutability" => "nonpayable",
                "type" => "function"
            ],
            [
                "inputs" => [
                    [
                        "internalType" => "address",
                        "name" => "newOwner",
                        "type" => "address"
                    ]
                ],
                "name" => "transferOwnership",
                "outputs" => [
                ],
                "stateMutability" => "nonpayable",
                "type" => "function"
            ],
            [
                "inputs" => [
                    [
                        "internalType" => "address",
                        "name" => "owner",
                        "type" => "address"
                    ],
                    [
                        "internalType" => "address",
                        "name" => "spender",
                        "type" => "address"
                    ]
                ],
                "name" => "allowance",
                "outputs" => [
                    [
                        "internalType" => "uint256",
                        "name" => "",
                        "type" => "uint256"
                    ]
                ],
                "stateMutability" => "view",
                "type" => "function"
            ],
            [
                "inputs" => [
                    [
                        "internalType" => "address",
                        "name" => "account",
                        "type" => "address"
                    ]
                ],
                "name" => "balanceOf",
                "outputs" => [
                    [
                        "internalType" => "uint256",
                        "name" => "",
                        "type" => "uint256"
                    ]
                ],
                "stateMutability" => "view",
                "type" => "function"
            ],
            [
                "inputs" => [
                ],
                "name" => "decimals",
                "outputs" => [
                    [
                        "internalType" => "uint8",
                        "name" => "",
                        "type" => "uint8"
                    ]
                ],
                "stateMutability" => "view",
                "type" => "function"
            ],
            [
                "inputs" => [
                ],
                "name" => "name",
                "outputs" => [
                    [
                        "internalType" => "string",
                        "name" => "",
                        "type" => "string"
                    ]
                ],
                "stateMutability" => "view",
                "type" => "function"
            ],
            [
                "inputs" => [
                ],
                "name" => "owner",
                "outputs" => [
                    [
                        "internalType" => "address",
                        "name" => "",
                        "type" => "address"
                    ]
                ],
                "stateMutability" => "view",
                "type" => "function"
            ],
            [
                "inputs" => [
                ],
                "name" => "symbol",
                "outputs" => [
                    [
                        "internalType" => "string",
                        "name" => "",
                        "type" => "string"
                    ]
                ],
                "stateMutability" => "view",
                "type" => "function"
            ],
            [
                "inputs" => [
                ],
                "name" => "totalSupply",
                "outputs" => [
                    [
                        "internalType" => "uint256",
                        "name" => "",
                        "type" => "uint256"
                    ]
                ],
                "stateMutability" => "view",
                "type" => "function"
            ]
        ];


    }
}
