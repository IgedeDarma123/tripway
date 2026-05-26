<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'method',
        'name',
        'account_number',
        'account_name',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function getActiveMethods()
    {
        return self::where('is_active', true)->orderBy('sort_order')->get();
    }

public static function getByMethod($method)
    {
        return self::where('method', $method)->where('is_active', true)->first();
    }

    public static function getMethodOptions()
    {
        return [
            'qris' => 'QRIS',
            'bca' => 'BCA VA',
            'bni' => 'BNI VA',
            'mandiri' => 'Mandiri VA',
            'bri' => 'BRI VA',
            'gopay' => 'GoPay',
            'ovo' => 'OVO',
            'dana' => 'DANA',
            'credit_card' => 'Kartu Kredit',
        ];
    }

    public static function getTypeForMethod($method)
    {
        $bankTransferMethods = ['bca', 'bni', 'mandiri', 'bri'];
        $ewalletMethods = ['gopay', 'ovo', 'dana'];
        
        if (in_array($method, $bankTransferMethods)) {
            return 'bank_transfer';
        } elseif (in_array($method, $ewalletMethods)) {
            return $method;
        } elseif ($method === 'qris') {
            return 'qris';
        } elseif ($method === 'credit_card') {
            return 'credit_card';
        }
        
        return $method;
    }
}
